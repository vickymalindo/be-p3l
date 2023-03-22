<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCheckoutRequest;
use App\Http\Requests\UpdateCheckoutRequest;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      $isExixts = Checkout::where('user_id', $id)->exists();

      if (!$isExixts) {
        return response()->json([
          'message' => 'User havent add item yet',
          'status' => 400
        ]);
      }

      $data = User::with('checkouts')->find($id);

      return response()->json([
        'message' => 'Get successfully',
        'data' => $data,
        'status' => 200,
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $user_id, $code)
    {
      $request->validate([
        'user_id' => 'required',
        'product_code' => 'required',
        'product_name' => 'required',
        'product_image' => 'required',
        'product_price' => 'required',
      ]);

      $isExixts = Checkout::where('user_id', $user_id)->where('product_code', $code)->exists();
      if($isExixts){
        return response()->json([
          'message' => 'Data already in cart',
          'status' => 400,
        ]);
      }

      $data = Checkout::create([
        'user_id' => $request->user_id,
        'product_code' => $request->product_code,
        'product_name' => $request->product_name,
        'product_image' => $request->product_image,
        'product_price' => $request->product_price,
      ]);

      return response()->json([
        'message' => 'Data successfully insert to cart',
        'data' => $data,
        'status' => 200,
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCheckoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCheckoutRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Checkout::with('user')->find($id);

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCheckoutRequest  $request
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCheckoutRequest $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    // TODO: buat fitur biar bisa hapus semua data sekaligus
    public function destroy($id)
    {
        $cart = Checkout::find($id);
        $cart->delete();

        return response()->json([
          'message' => 'delete successfully',
          'status' => 200
        ]);
    }
}
