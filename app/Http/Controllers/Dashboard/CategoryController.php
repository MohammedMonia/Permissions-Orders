<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    
    public function index(Request $request)
    {
        $categories = Category::when($request->search, function($q) use ($request)
    {

        return $q->whereTranslationLike('name', '%' . $request->search . '%');

    })->latest()->paginate(5);

        return view('dashboard.categories.index', compact('categories')); 
    }

    
    public function create()
    {
        return view('dashboard.categories.create');
    }

    
    public function store(Request $request)
    {

        $ruels = [];

        foreach(config('translatable.locales') as $locale)
        {

            $ruels += [$locale . '.name' => ['required', Rule::unique('category_translations','name')]];

        }//end of foreach


        $request->validate($ruels);

        Category::create($request->all());

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

        
    public function edit($id)
    {
        $category = Category::find($id);

        return view('dashboard.categories.edit', compact('category'));
    }

    
    public function update(Request $request, Category $category)
    {
        $ruels = [];

        foreach(config('translatable.locales') as $locale)
        {

            $ruels += [$locale . '.name' => ['required', Rule::unique('category_translations','name')->ignore($category->id, 'category_id')]];

        }//end of foreach

        $request->validate($ruels);

        $category->update($request->all());

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

   
    public function destroy(Category $category)
    {
        
        $category->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }
}
