<?php

namespace App\Http\Controllers;

use App\Models\ProductClassification;
use Illuminate\Http\Request;

class ProductClassificationController extends Controller
{
    public function index()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['name' => "Product Classification"]
        ];
        return view('content.product-classification', ['breadcrumbs' => $breadcrumbs]);
    }

    public function addProductClassification()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/product-classifications", 'name' => "Product Classification"], ['name' => "Add Product Classification"]
        ];
        $product_classification = [];
        return view('content.add-product-classification', ['product_classification' => $product_classification, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editProductClassification($id)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/product-classifications", 'name' => "Product Classification"], ['name' => "Edit Product Classification"]
        ];
        $product_classification = ProductClassification::where('id', $id)->select('id',
            'name')->first();

        return view('content.add-product-classification', ['product_classification' => $product_classification, 'breadcrumbs' => $breadcrumbs]);
    }
}
