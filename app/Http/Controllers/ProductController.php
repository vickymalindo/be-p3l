<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $products = Product::all();

      if (!$products) {
        return response()->json([
          'message' => 'Failed or Empty Products',
          'status' => 400,
        ]);
      }

      return response()->json([
        'message' => 'Success',
        'status' => 200,
        'data' => $products
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
          'code' => 'required|unique:products',
          'title' => 'required',
          'image' => 'required',
          'price' => 'required',
        ]);

        $image = $request->file('image')->getClientOriginalName();
        $request->file('image')->move('products', $image);

        $data = [
          'code' => $request->code,
          'title' => $request->title,
          'image' => url('products/'.$image),
          'price' => $request->price
        ];

        $product = Product::create($data);

        if($product){
          $result = [
            'message' => 'insert successfully',
            'data' => $data,
            'status' => 200,
          ];
        } else {
          $result = [
            'message' => 'insert failed',
            'status' => 400,
          ];
        }

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
          return response()->json([
            'message' => 'product cannot show',
            'status' => 400,
          ]);
        }

        return response()->json($product, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $product = Product::find($id);

        // if(!$product) {
        //   return response()->json([
        //     'message' => 'product cannot find',
        //     'status' => 400,
        //   ]);
        // }

        // $data = $product->update([
        //   $product->code => $request->code,
        //   $product->title => $request->title,
        //   $product->price => $request->price
        // ]);

        // if (!$data) {
        //   return response()->json([
        //     'message' => 'product cannot updated',
        //     'status' => 400,
        //   ]);
        // } else {
        //   return response()->json([
        //     'message' => 'product successfully updated',
        //     'data' => $data,
        //     'status' => 200,
        //   ]);
        // }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
          'message' => 'delete successfully',
          'status' => 200
        ]);
    }
}
