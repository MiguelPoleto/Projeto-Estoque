<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function newProduct(Request $request)
    {

        $request->validate([
            "product_id" => "required|unique:stocks,product_id,NULL,id,user_id," . auth()->id(),
            "name" => "required|string",
            "category" => "required|string",
            "unit" => "required|string",
            "amount" => "required|int",
            "price" => "required|numeric",
            "description" => "nullable|string",
            "total_price" => "nullable|numeric",
            "sku" => "nullable|string",
            "barcode" => "nullable|string",
            "supplier" => "nullable|string",
            "supplier_contact" => "nullable|string|max:14",
            "brand" => "nullable|string",
            "location" => "nullable|string",
            "minimum_stock" => "required|min:1",
        ], [
            "product_id.unique" => "O ID do produto já existe no banco de dados.",
        ]);

        try {
            $product = new Stock();

            $product->product_id = $request->product_id;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->amount = $request->amount;
            $product->price = $request->price;
            $product->total_price = $request->total_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->supplier = $request->supplier;
            $product->supplier_contact = $request->supplier_contact;
            $product->category = $request->category;
            $product->brand = $request->brand;
            $product->location = $request->location;
            $product->minimum_stock = $request->minimum_stock;
            $product->unit = $request->unit;

            $product->user_id = auth()->check() ? auth()->id() : null;

            $product->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function listProducts()
    {
        $products = Stock::where('user_id', auth()->id())->get();


        return view('stock', compact('products'));
    }

    public function saleProduct() {}

    public function detail() {}

    public function editProduct() {}

    public function deleteProduct()
    {
        dd("teste");
        $product = Stock::where('user_id', auth()->id())
            ->where('product_id', request('product_id'))
            ->first();

        if ($product) {
            $product->delete();
            return redirect()->route('stock')->with('success', 'Produto deletado com sucesso');
        }

        return redirect()->route('stock')->with('error', 'Produto não encontrado');
    }
}
