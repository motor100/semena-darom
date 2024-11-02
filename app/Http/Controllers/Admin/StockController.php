<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Product;

class StockController extends Controller
{
    /**
     * Поиск товара по штрихкоду
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function stock(Request $request): View
    {   
        $validated = $request->validate([
            'search_query' => 'nullable|numeric|digits:13'
        ]);

        if (isset($validated['search_query'])) {
            $product = Product::where('barcode', 'like', "%{$validated['search_query']}%")->first();

            return view('dashboard.stock', compact('product'));
        }

        return view('dashboard.stock');
    }

    public function stock_update(Request $request)
    {   
        $validated = $request->validate([
            'id' => 'required|numeric',
            'quantity' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($validated['id']);

        $product->update([
            'stock' => $product->stock + intval($validated['quantity']) // текущее количество товара на складе плюс новое поступление
        ]);

        return redirect()->back();
    }

}
