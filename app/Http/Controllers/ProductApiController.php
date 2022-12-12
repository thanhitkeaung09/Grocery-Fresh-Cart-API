<?php

namespace App\Http\Controllers;

use App\Http\Resources\PhotoResource;
use App\Http\Resources\ProductResource;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest("id")->get();
//        dd($products);
//        return response()->json($products,200);
        return ProductResource::collection($products);
//        return $products;
//        dd($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           "product"=>"required|min:3",
           "price"=>"required|min:1|max:5",
           "stock"=>"required",
            "photos"=>"required",
            "photos.*"=>"file|mimes:jpeg,png|max:512"
        ]);

        $product = Product::create([
           "product" => $request->product,
           "price" => $request->price,
           "stock" => $request->stock,
        ]);

        $photos = [];

        foreach ($request->file('photos') as $key => $photo){
            $newName = $photo->store("public");
            $photos[$key] = new Photo(['name'=>$newName]);
        }

        $product->photos()->saveMany($photos);

        return response()->json($product,200);
//        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(is_null($product)){
            return response()->json(["message"=>"There is no products"],404);
        }
        return response()->json([
            "product" => $product,
            "photo" => PhotoResource::collection($product->photos)
        ]);
//        return PhotoResource::collection($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if(is_null($product)){
            return response(["message"=>"Product is not found"],404);
        }

        $request->validate([
            "product"=>"required|min:3",
            "price"=>"required|min:1|max:5",
            "stock"=>"required",

        ]);

        $product->product = $request->product;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->update();

        return response()->json([
            "message" => "Product is updated",
            "success" => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(is_null($product)){
            return response()->json(["message"=>"Product Not Found"],404);
        }

        $product->delete();
        return response()->json(["message"=>"Product is deleted"],200);
    }
}
