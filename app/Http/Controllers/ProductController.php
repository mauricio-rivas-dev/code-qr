<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function updatedCode(Request $request)
    {
        $code = $request->input('code');
        $product = Product::where('bar_code', $code)->first();

        if ($product) {
            // Si ya existe, podrías incrementar cantidad o devolver info
            $product->cantidad += 1;
            $product->save();
            return response()->json(['mensaje' => 'product updated', 'product' => $product]);
        } else {
            // Si no existe, crea uno nuevo (puedes pedir más datos después)
            $product = Product::create([
                'name' => 'product unknown',
                'bar_code' => $code,
                'quantiy' => 1
            ]);
            return response()->json(['mensaje' => 'product add', 'product' => $product]);
        }
    }
}
