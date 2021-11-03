<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;
use App\Models\Follow;

class ProfileController extends Controller
{
    const LOCAL_STORAGE_FOLDER  = 'public/avatars/';
    const S3_AVATAR_FOLDER      = 'avatars/';

    const LOCAL_DISK        = 'local';
    const S3_DISK           = 's3';

    /**
     * The User model instance.
     */
	private $user;

    /**
     * Profile Controller instance.
     *
     * @param  \App\Models\User  $user
     * 
     * @return void
     */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
	public function show($id)
	{
        if ($id != Auth::user()->id && Auth::user()->role_id !== User::ADMIN_ROLE_ID) { abort(403); }

		$user = $this->user->withTrashed()->findOrFail($id);

		return view('users.profile.show')->with('user', $user);

	}

    /**
     * Edit the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
	public function edit($id)
	{
        if ($id != Auth::user()->id && Auth::user()->role_id !== User::ADMIN_ROLE_ID) { abort(403); }

		$user = $this->user->withTrashed()->findOrFail($id);

		return view('users.profile.edit')->with('user', $user);
	}

    /**
     * Update the profile for a given user.
     *
     * @param int  $id
     * @param Request $request
     * @return \Illuminate\Support\Facades\Redirect
     */
	public function update($id, Request $request)
	{
		$request->validate([
            'name'      => 'required|min:1|max:50',
            'email'     => 'required|email|max:50|' . Rule::unique('users')->ignore($id),
            'avatar'    => 'mimes:jpg,png,jpeg,gif|max:1048',
            'introduction' => 'max:100'
        ]);

        $user           = $this->user->withTrashed()->findOrFail($id);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->introduction = $request->introduction;


        if ($request->avatar) {
            $user->avatar = $this->saveImage($request, $user->avatar);
        }

        $user->save();

        return redirect()->route('profile.show', $id);
	}

	/**
     * Update and rename image file for saving
     *
     * @param Request $request
     * @param String $avatar
     * @return String
     */
    private function saveImage($request, $avatar = null)
    {
        # rename the image to remove the risk of overwriting 
        $name   = time().'.'.$request->avatar->extension();
        $disk   = config('app.env') !== 'local' ? self::S3_DISK : '';
        $folder = config('app.env') !== 'local' ? self::S3_AVATAR_FOLDER : self::LOCAL_STORAGE_FOLDER;

        # put into public to be accessible
        $request->avatar->storeAs($folder, $name, $disk);
        
        # check if has existing avatar saved in db && in storage
        if ($avatar) { $this->deleteAvatar($avatar); }

        return $name;
    }

    /**
     * Delete avatar when deleting the profile
     *
     * @param String $avatar
     * @return Void
     */
    private function deleteAvatar($avatar)
    {
        $folder = config('app.env') === 'local' 
                ? self::LOCAL_STORAGE_FOLDER
                : self::S3_AVATAR_FOLDER;

        $disk   = config('app.env') === 'local' 
                ? self::LOCAL_DISK 
                : self::S3_DISK;

        if (Storage::disk($disk)->exists($folder . $avatar)) {
            Storage::disk($disk)->delete($folder . $avatar);
        }
    }
}
