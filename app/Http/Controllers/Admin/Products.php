<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DeleteHelper;
use App\Http\Controllers\Traits\TraitHelper;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\ModelFilters\ProductFilter;
use App\Models\Color;
use App\Models\Product;
use Auth;
use File;
use Illuminate\Http\Request;
use Validator;


class Products extends Controller
{
    use TraitHelper;
  
    public function index(Request $request)
    {
        $products = Product::filter($request->all())->withSum('auctionProducts','count_pieces')->paginate();
        return view('pages.products.index', compact('products'));
    }

    public function create()
    {   
      $colors = Color::select('id','name')->pluck('name','id')->toArray();
      return view('pages.products.add',compact('colors'));
    }
    
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->uploadImage('products', $request->image);

        Product::create($data);
        alert()->success('تم الأضافة بنجاح');
        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
      return view('pages.products.edit', compact('product'));
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $data = $request->validated();
       
        if($request->has("image")){
          $this->deleteImage($product->image); 
          $data['image'] = $this->uploadImage('Products', $request->image);
        }else{
          $data['image'] = $product->image ;
        }
    
        $product->update($data);
        alert()->success('تم التحديث بنجاح');
        return redirect()->route('products.index');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        alert()->success('تم الحذف مؤقتا');
        return back();
    }


}
