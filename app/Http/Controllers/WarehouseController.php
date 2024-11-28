<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:warehouses',
            'location' => 'required',
        ]);

        $warehouse = Warehouse::create($request->all());

        $response = [
            'success' => true,
            'message' => "Warehouse successfully stored",
            'data' => $warehouse,
        ];

        return response()->json($response);
    }

    public function index($pageId)
    {
        $warehouse = Warehouse::paginate(5, ['*'], 'page', $pageId);

        $response = [
            'success' => true,
            'message' => "Warehouse List",
            'data' => $warehouse,
        ];

        return response()->json($response);
    }

    public function destroy($warehouseId, $moveWarehouseId)
    {
        try {

            $warehouse = Warehouse::find($warehouseId);

            if (!$warehouse) {
                throw new \Exception("Warehouse not found.");
            }

            $moveWarehouse = Warehouse::find($moveWarehouseId);

            if (!$moveWarehouse) {
                throw new \Exception("Move warehouse not found.");
            }

            Product::where('warehouse_id', $warehouse->id)->update([
                'warehouse_id' => $moveWarehouseId,
            ]);

            $warehouse->delete();

            $response = [
                'success' => true,
                'message' => "Warehouse delete and product moved",
            ];

            return response()->json($response);

        } catch (\Exception $e) {


            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
