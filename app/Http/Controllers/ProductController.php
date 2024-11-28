<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function store(Request $request, $warehouseId)
    {
        try {

            $warehouse = Warehouse::find($warehouseId);

            if (!$warehouse) {
                throw new \Exception('Warehouse not found');
            }

            $request->validate([
                'name' => ['required',
                    Rule::unique('products')->where('warehouse_id', $warehouseId)],
                'quantity' => 'required|integer|min:0',
                'price' => 'required|integer|min:0',
            ]);

            $warehouse = Product::create([
                'name' => $request->name,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'warehouse_id' => $warehouseId,
            ]);

            $response = [
                'success' => true,
                'message' => "Warehouse Product successfully stored",
                'data' => $warehouse,
            ];

            return response()->json($response);

        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function index($warehouseId)
    {
        $products = Product::where('warehouse_id', $warehouseId)->paginate(10);

        $response = [
            'success' => true,
            'message' => "Product List",
            'data' => $products,
        ];

        return response()->json($response);
    }
}
