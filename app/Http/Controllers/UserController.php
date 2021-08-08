<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function ViewCheckout(Request $request)
    {
        $info = $request->session()->get('user');
        $carts = \App\Carts::where('id_user', $info->id)->get();

        $subtotal = 0;
        $payment = 0;
        $discount = 0;

        foreach ($carts as $cart) {
            $subtotal = $subtotal + ($cart->product->price_product * $cart->quantity);
            if ($cart->product->promotion->price_promotion - $cart->product->price_product < 0)
                $discount = $discount + ($cart->product->promotion->price_promotion * $cart->quantity);
            $payment = $payment + $cart->total_money;
        }

        return view('user.checkout', compact('info', 'carts', 'payment', 'subtotal', 'discount'));
    }

    public function Checkout(Request $request)
    {
        $carts = \App\Carts::where('id_user', $request->session()->get('user')->id)->get();

        try {
            $orders = \App\Orders::where('id_user', $request->session()->get('user')->id)->get()->count();
            $code = $orders + 1;

            foreach ($carts as $cart) {
                $order = new \App\Orders();
                $order->id_user = $request->session()->get('user')->id;
                $order->name = $request->name;
                $order->address = $request->address;
                $order->name_product = $cart->product->name_product;
                $order->quantity = $cart->quantity;
                $order->code = $code;
                $order->price_promotion = $cart->product->promotion->price_promotion;
                $order->price = $cart->product->price_product;
                $order->total_money = $cart->total_money;
                $order->save();
                $cart->delete();
            }
            return redirect(route('Cart'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function CancelOrder(Request $request)
    {
        try {
            foreach ($request->id as $item) {
                $cancel = new \App\OrderCancels();
                $cancel->id_order = $item;
                $cancel->save();

                $order = \App\Orders::Find($item);
                $order->is_active = 1;
                $order->save();
            }
            return redirect()->back()->with('status', 'Update thàng công!');
        } catch (Exception $e) {
            return abort(404, 'Update Fail');
            //echo $e->getMessage();
        }
    }

    public function Info(Request $request)
    {
        $user = \App\User::Find($request->session()->get('user')->id);
        $order = \App\Orders::where('id_user', $user->id)
            ->where('accept', 0)->where('is_active', 0)->get();
        $orders = $order->groupBy('code');
        return view('user.info', compact('user', 'orders'));
    }

    public function UpdateInfo(Request $request)
    {
        try {
            $user = \App\User::Find($request->session()->get('user')->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return redirect()->back()->with('success', 'your message,here');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function Logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
