<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoriesController extends Controller
{
    const PER_PAGE = 10;

    /**
     * The Category model instance.
     */
    private $category;

    /**
     * Categories Controller instance.
     *
     * @param  \App\Models\Category  $category
     * 
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->category->orderBy('name')->paginate(self::PER_PAGE);

        return view('admin.categories.index')->with('categories', $categories);
    }

    /**
     * Store the new given category resource.
     *
     * @param  Request $request
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:50']);

        $category       = new Category;
        $category->name = ucfirst($request->name);
        $category->slug = str_replace(' ', '-', strtolower($request->name));
        $category->save();

        return redirect()->route('admin.categories.index');
    }

    /**
     * Update the category.
     *
     * @param int  $id
     * @param Request $request
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'name' . $id => 'required|max:50'
        ],
        [
            'name' . $id . '.required' => 'The name field is required.',
            'name' . $id . '.max' => 'The name must not be greater than 50 characters.'   
        ]);

        $category       = $this->category->findOrFail($id);
        $category->name = ucfirst($request->input('name'. $id));
        $category->slug = str_replace(' ', '-', strtolower($request->input('name'. $id)));
        $category->save();

        return redirect()->back();

    }

    /**
     * Destroy the category.
     *
     * @param int  $id
     * 
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function destroy($id)
    {
        $this->category->findOrFail($id)->delete();

        return redirect()->back();
    }
}
