<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\Sale;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function getBuys()
    {
        try {
            $buys = Buy::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

            if ($buys) {
                return response()->json([
                    'success' => true,
                    'buys' => $buys->toArray()
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Nenhuma compra encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getSells()
    {
        try {
            $sells = Sale::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

            if ($sells) {
                return response()->json([
                    'success' => true,
                    'sells' => $sells->toArray()
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Nenhuma venda encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
