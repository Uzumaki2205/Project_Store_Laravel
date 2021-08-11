<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carts;
use App\Products;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // POST 
    // public function GetCart(Request $request)
    // {
    //     // username, password, email
    //     // $cart = Carts::Find('id_user', $id_user);
    //     // return $cart;
    //     $value = $request->session()->get('user');
    //     return $value;
    // }

    public function GetCart()
    {
        $carts = Carts::where('id_user', Session('user')->id)->get();
        return view('user.cart', compact('carts'));
    }

    // POST
    public function AddToCart(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required|int|min:1|max:20',
            'id' => 'required|int'
        ]);

        $inv = \App\Products::Find($request->id);
        if ($inv->quantity_product <= 0 || $inv == null || ($inv->quantity_product - $request->quantity) < 0)
            return abort(404, 'Product Not Contain Into Inventory.');

        $session = $request->session()->get('user');
        $cart = new Carts();
        $cart->id_product = $request->id;
        $cart->id_user = $session->id;
        $cart->quantity = $request->quantity;

        $final_price = $inv->price_product - $inv->promotion->price_promotion;

        if ($final_price < 0)
            $final_price = 0;

        $cart->total_money = $request->quantity * $final_price;

        $cart->save();

        // Decrease Quantity into inventory
        // $inv->quantity = $inv->quantity - $request->quantity;
        // $inv->save();

        return redirect()->back()->with('status', 'Thêm vào giỏ hàng thàng công!');
    }

    public function UpdateCart(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required|int|min:1|max:20',
            'id' => 'required|int'
        ]);

        $cart = Carts::Find($request->id);

        // Get old quantity to store inventory
        // $old_quantity = $cart->quantity;

        $inv = \App\Products::Find($cart->id_product);

        // Decrease Quantity into inventory
        // if ($old_quantity > $request->quantity)
        //     $inv->quantity = $inv->quantity + ($old_quantity - $request->quantity);
        // if ($old_quantity < $request->quantity) //+
        //     $inv->quantity = $inv->quantity - ($request->quantity - $old_quantity);

        if ($inv->quantity_product <= 0 || $inv == null || ($inv->quantity_product - $request->quantity) < 0)
            return abort(404, 'Product Not Contain Into Inventory.');

        $cart->quantity = $request->quantity;
        $final_price = $inv->price_product - $inv->promotion->price_promotion;

        if ($final_price < 0)
            $final_price = 0;

        $cart->total_money = $request->quantity * $final_price;
        $cart->save();

        //$inv->save();

        return redirect()->back()->with('status', 'Update giỏ hàng thàng công!');
    }

    public function RemoveCart(Request $request)
    {
        $cart = Carts::where('id_user', $request->session()->get('user')->id)
            ->where('id', $request->id)->first();

        if ($cart == null) {
            return abort(404, 'Product Not Contain Into Inventory.');
        }

        $inv = \App\Products::Find($cart->id_product);
        // $inv->quantity = $inv->quantity + $cart->quantity;
        // $inv->save();

        $cart->delete();

        return redirect()->back()->with('status', 'Remove thàng công!');
    }
}
