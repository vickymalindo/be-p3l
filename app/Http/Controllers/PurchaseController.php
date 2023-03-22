<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCheckoutRequest;
use App\Http\Requests\UpdateCheckoutRequest;

class PurchaseController extends Controller
{

    public function delivered($id)
    {
      $data = Purchase::find($id);

      if(!$data) {
         return response()->json([
          'message' => 'List not find or not created',
          'status' => 400,
        ]);
      }
      $data->update(['delivered' => 'true']);
      return response()->json([
        'message' => 'Update to delivered success',
        'status' => 200
      ]);
    }

    public function getPurchaseAdmin()
    {
      $isExixts = Purchase::where('payment', '!=', null)->exists();

      if (!$isExixts) {
        return response()->json([
            'message' => 'Data not Found',
            'status' => 400
        ]);
      }

      $data = Purchase::where('payment', '!=', '')->get();

      return response()->json([
        'message' => 'Get successfully',
        'data' => $data,
        'status' => 200,
      ]);
    }

    public function payment(Request $request, $user_id, $id)
    {
      $request->validate([
        'payment' => 'required'
      ]);

      $payment = $request->file('payment')->getClientOriginalName();
      $request->file('payment')->move('payments', $payment);

      $data = Purchase::where('user_id', $user_id)->find($id);
      $data->payment = url('payments/'.$payment);
      $data->save();

      return response()->json([
        'message' => 'Get successfully',
        'data' => $data,
        'status' => 200,
      ]);
    }

    public function index($id)
    {
        $isExixts = Purchase::where('user_id', $id)->exists();

        if(!$isExixts){
            return response()->json([
            'message' => 'User havent add item yet',
            'status' => 400
          ]);
        }

        $data = User::with('purchases')->find($id);

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
    public function create(Request $request)
    {
        $request->validate([
          'user_id' => 'required',
          'user_address' => 'required',
          'user_fullname' => 'required',
          'total_price' => 'required',
          'list_product' => 'required',
          'user_phone' => 'required',
        ]);

        $data = Purchase::create([
          'user_id' => $request->user_id,
          'user_address' => $request->user_address,
          'user_fullname' => $request->user_fullname,
          'payment' => '',
          'total_price' => $request->total_price,
          'delivered' => 'false',
          'list_product' => $request->list_product,
          'user_phone' => $request->user_phone,
        ]);

        return response()->json([
          'message' => 'Data successfully added',
          'data' => $data,
          'status' => 200,
        ]);
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
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Purchase::with('user')->find($id);

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Purchase::find($id);
        $product->delete();

         return response()->json([
          'message' => 'delete successfully',
          'status' => 200
        ]);
    }
}
