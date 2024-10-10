<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $carts = Cart::with(['product.galleries', 'product.category', 'user'])
            ->where('users_id', Auth::user()->id)
            ->get();
        return view('pages.cart', [
            'carts' => $carts,
        ]);
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        return redirect()->route('cart');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        if ($request->has('quantity')) {
            $cart->quantity = $request->quantity;
        }

        if ($request->has('notes')) {
            $cart->notes = $request->notes;
        }

        $cart->save();

        return response()->json(['success' => true, 'message' => 'Cart updated successfully']);
    }

    public function success()
    {
        return view('pages.success');
    }
}
