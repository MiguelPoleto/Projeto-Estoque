<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\Sale;
use App\Models\Stock;
use Dotenv\Exception\ValidationException;
use Exception;
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

    public function infoProduct($id)
    {
        try {
            $product = Stock::where('user_id', auth()->id())
                ->where('product_id', $id)
                ->first();

            if ($product) {
                return response()->json([
                    'success' => true,
                    'product' => [
                        'amount' => $product->amount,
                        'price' => $product->price,
                        'minimum_stock' => $product->minimum_stock,
                        'total_price' => $product->total_price
                    ]
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Produto não encontrado.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function buyProduct(Request $request)
    {
        try {
            $request->validate([
                "product_id_buy" => "required|exists:stocks,product_id,user_id," . auth()->id(),
                "buy_amount" => "required|numeric|min:1",
                'product_price' => 'required|numeric|min:0',
            ]);

            $product = Stock::where('user_id', auth()->id())
                ->where('product_id', $request->product_id_buy)
                ->first();

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Produto não encontrado.'], 404);
            }

            $product->amount += $request->buy_amount;
            $product->save();

            $buy = Buy::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id_buy,
                'amount' => $request->buy_amount,
                'price' => $request->product_price,
                'total_price' => $request->buy_amount * $request->product_price,
                'buy_date' => now()
            ]);

            return response()->json(['success' => true, 'message' => "Compra realizada com sucesso.",
                                    'data' => ['buy' => $buy, 'new_stock_amount' => $product->amount]]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao realizar compra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sellProduct(Request $request)
    {
        try {
            $request->validate([
                "product_id_sell" => "required|exists:stocks,product_id,user_id," . auth()->id(),
                "sell_amount" => "required|numeric|min:1",
                'product_price' => 'required|numeric|min:0',
            ]);

            $product = Stock::where('user_id', auth()->id())
                ->where('product_id', $request->product_id_sell)
                ->first();

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Produto não encontrado.'], 404);
            }

            $avaibleQuantity = $product->amount - $product->minimum_stock;
            if ($request->sell_amount > $avaibleQuantity) {
                return response()->json(['success' => false, 'message' => 'Quantidade insuficiente em estoque.'], 400);
            }

            $product->amount -= $request->sell_amount;
            $product->save();

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id_sell,
                'amount' => $request->sell_amount,
                'price' => $request->product_price,
                'total_price' => $request->sell_amount * $request->product_price,
                'sale_date' => now()
            ]);

            return response()->json(['success' => true, 'message' => "Venda realizada com sucesso.",
                                    'data' => ['sale' => $sale, 'new_stock_amount' => $product->amount]]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao realizar venda: ' . $e->getMessage()
            ], 500);
        }
    }

    public function detailsProduct($id)
    {
        try {
            $product = Stock::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->first();

            if ($product) {
                return response()->json([
                    'success' => true,
                    'product' => $product->toArray()
                ]);

            } else {
                return response()->json(['success' => false, 'message' => 'Produto não encontrado.']);
            }
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
        
    }

    public function editProduct()
    {

    }

    public function deleteProduct()
    {
        try {
            $product = Stock::where('user_id', auth()->id())
                ->where('product_id', request('product_id'))
                ->first();

            $product->delete();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
