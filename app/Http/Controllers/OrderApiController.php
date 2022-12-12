<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::all();
//        $product = Order::find(3)->product;
//        $order = Order::find(1)->product();
//        $singleProduct = Order::find(1)->product;
//            return OrderResource::collection($order);
      return OrderResource::collection($order);
//        return response()->json($order);
//        dd($order);
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
            "name"=>"required",
            "phone_number"=>"required",
            "address" => "required",
            "product_id" => "required|exists:products,id"
        ]);



        $order = Order::create([
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "address" => $request->address,
            "product_id" => $request->product_id,
        ]);

//        $product = Product::find(1);
//
//        $order->product()->save($product);




        return response()->json($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $order = Order::find($id)->product;
        return response()->json($order);
//        $owner = Order::find($id);
//        return response()->json([
//           "owner" => new OrderResource($owner),
//           "product" => $order
//        ]);
//        return OrderResource($order);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if(is_null($order)){
            return response()->json(["message"=>"Product Not Found"],404);
        }
        $order->delete();
        return response()->json(["message"=>"Product is deleted"],200);
    }
}
