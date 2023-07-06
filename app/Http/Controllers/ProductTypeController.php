<?php

namespace App\Http\Controllers;

use App\Models\KindOfProduct;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }


        $breadcrumbs = [
            ['name' => "Product Type"]
        ];
        return view('content.product-type', ['breadcrumbs' => $breadcrumbs]);
    }

    public function addProductType()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }


        $breadcrumbs = [
            ['link' => "admin/product-types", 'name' => "Product Type"], ['name' => "Add Product Type"]
        ];
        $productType = [];
        return view('content.add-product-type', ['productType' => $productType, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editProductType($id)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/product-types", 'name' => "Product Type"], ['name' => "Edit Product Type"]
        ];
        $productType = KindOfProduct::where('id', $id)->select('id', 'name')->with('classifications:id,name')->first();

        return view('content.add-product-type', ['productType' => $productType, 'breadcrumbs' => $breadcrumbs]);
    }
}
