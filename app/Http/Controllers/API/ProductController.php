<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $produts = Product::latest()->paginate(5);

        return response()->json([
            'status'    => true,
            'message'   => 'data Berhasil ditambahkan',
            'data'      => $produts,
        ], 200);
    }
}
