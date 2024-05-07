<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function showCart()
    {
        $user = Auth::user(); // obtén el usuario actual
        $cartItems = Cart::where('id_user', $user->id)->get(); // obtén los elementos del carrito para este usuario

        // puedes optar por cargar los productos relacionados en la misma consulta
        // $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        return view('cart', ['cartItems' => $cartItems]); // pasa los elementos del carrito a la vista
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|integer|exists:producto,id_producto',
            'cantidad' => 'required|integer|min:1'
        ]);

        $user = Auth::user();

        $id_producto = $request->input('id_producto');
        $cantidad = $request->input('cantidad');
        $id_user = $request->input('id_user');

        // Comprueba si el producto ya está en el carrito
        $cart = Cart::where('id_producto', $id_producto)->where('id_user', $id_user)->first();

        if($cart){
            return response()->json(['success' => false, 'message' => 'El producto ya ha sido reservado.']);
        }

        // Si el producto no está en el carrito, guárdalo
        $cart = new Cart;
        $cart->id_producto = $id_producto;
        $cart->cantidad = $cantidad;
        $cart->id_user = $id_user;
        $cart->save();

        return response()->json(['success' => true, 'message' => 'Producto reservado con éxito!']);
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart.cart', ['cart' => $cart]);
    }
}
