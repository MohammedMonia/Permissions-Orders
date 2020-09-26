<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search, function ($q) use ($request) 
        {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) 
        {

            return $q->where('category_id', $request->category_id);

        })->latest()->paginate(5);

        return view('dashboard.products.index', compact('categories', 'products'));

    }//end of index

    
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.products.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $ruels = [
            'category_id' => 'required'
        ];

        foreach(config('translatable.locales') as $locale)
        {

            $ruels += [$locale . '.name' => ['required', Rule::unique('product_translations','name')]];
            $ruels += [$locale . '.description' => ['required']];

            
        }//end of foreach

        $ruels += [
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];

        $request->validate($ruels);

        $request_data = $request->all();


        if($request->image)
        {
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/product_images/' . $request->image->hashName()));

                $request_data['image'] = $request->image->hashName();

        }//end of if
        
        Product::create($request_data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        
        return view('dashboard.products.edit', compact('categories', 'product'));
    }

    
    public function update(Request $request, Product $product)
    {
        $ruels = [
            'category_id' => 'required'
        ];

        foreach(config('translatable.locales') as $locale)
        {

            $ruels += [$locale . '.name' => ['required', Rule::unique('product_translations','name')->ignore($product->id, 'product_id')]];
            $ruels += [$locale . '.description' => ['required']];

            
        }//end of foreach

        $ruels += [
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];

        $request->validate($ruels);

        $request_data = $request->all();


        if($request->image)
        {

            if($product->image != 'default.png')
            {
                
                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);           

            }//end of inner if

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/product_images/' . $request->image->hashName()));

                $request_data['image'] = $request->image->hashName();

        }//end of if

        $product->update($request_data);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    
    public function destroy($id)
    {
        $product = Product::find($id);

        if($product->image != 'default.png')
            {
                
                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);           

            }//end of inner if
            
        $product->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }
}
