<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getTransactions()
    {
        try {
            $buys = Buy::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

            $sells = Sale::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

            if ($buys || $sells) {
                return response()->json([
                    'success' => true,
                    'buys' => $buys->toArray(),
                    'sells' => $sells->toArray()
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Nenhuma compra ou venda encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
