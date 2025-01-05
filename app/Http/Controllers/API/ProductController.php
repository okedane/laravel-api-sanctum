<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $produts = Product::latest()->paginate(5);

        return response()->json([
            'status'    => true,
            'message'   => 'list data product ',
            'data'      => $produts,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name'    => 'required',
            'price'           => 'required',
            'category'        => 'required',
        ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors() . 422);
        // }

        // $product = Product::create($validator->validated());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            // Membuat product dengan data tervalidasi
            $product = Product::create($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan',
                'data'    => $product
            ], 201); // Menggunakan status code 201 untuk Created

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan produk',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name'    => 'required',
            'price'           => 'required',
            'category'        => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors() . 422);
        }
        $product = Product::find($id);
        $product->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product Berhasil Ditambahkan',
            'data' => $product,
        ], 201);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product Berhasil Dihapus',
        ], 201);
    }
}
