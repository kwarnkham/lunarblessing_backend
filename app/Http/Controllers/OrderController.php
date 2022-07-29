<?php

namespace App\Http\Controllers;

use App\Enums\ResponseStatus;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json(Order::of($request->user())->paginate());
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'in:1,2,3,4,5'],
        ]);

        $user = $request->user();

        abort_if(!$user->isAdmin() && !is_null($order->screenshot), ResponseStatus::BAD_REQUEST->value);
        abort_if(
            !$user->isAdmin() && $request->status != 5,
            ResponseStatus::UNAUTHORIZED->value
        );
        abort_if(
            $order->user_id != $user->id && !$user->isAdmin(),
            ResponseStatus::UNAUTHORIZED->value
        );
        abort_if($order->status == $request->status, ResponseStatus::BAD_REQUEST->value);

        $order->status = $request->status;
        $order->save();
        return response()->json($order);
    }

    public function pay(Request $request, Order $order)
    {
        $request->validate([
            'payment_id' => ['required', 'exists:payments,id'],
            'screenshot' => ['required', 'image'],
        ]);

        $order->screenshot = basename(Storage::disk('s3')->putFile(env('APP_NAME') . "/order_paid", $request->screenshot, 'public'));
        $order->payment_id = $request->payment_id;
        $order->save();

        return response()->json($order);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $itemids = array_map(fn ($val) => $val['id'], $data['items']);
        return response()->json(DB::transaction(function () use ($user, $itemids, $data) {
            $data['user_id'] = $user->id;
            $order = Order::create($data);
            $items = Item::whereIn('id', $itemids)->get();

            $order->items()->attach(
                array_combine(
                    $itemids,
                    array_map(fn ($val) => [
                        'quantity' => $val['quantity'],
                        'sale_price' => $items->first(fn ($v) => $v->id == $val['id'])->price,
                        'text' => $val['text'],
                        'dimmed_lid' => $val['dimmed_lid']
                    ], $data['items'])
                )
            );
            return $order;
        }));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Order $order)
    {
        $user = $request->user();
        abort_if($order->user_id != $user->id && !$user->isAdmin(), ResponseStatus::NOT_FOUND->value);
        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
