<?php

namespace App\Http\Controllers;

use App\Models\Scholar;
use Illuminate\Http\Request;

class ScholarController extends Controller
{
    public function index()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['name' => "Scholar Management"]
        ];
        return view('content.scholar', ['breadcrumbs' => $breadcrumbs]);
    }

    public function addScholar()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/scholars", 'name' => "Scholar Management"], ['name' => "Add Scholar"]
        ];
        $scholar = [];
        return view('content.add-scholar', ['scholar' => $scholar, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editScholar($id)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/scholars", 'name' => "Scholar Management"], ['name' => "Edit Scholar"]
        ];
        $scholar = Scholar::where('id', $id)->select('id',
            'first_name', 'last_name', 'picture', 'email', 'first_name_ar', 'last_name_ar')->first();

        return view('content.add-scholar', ['scholar' => $scholar, 'breadcrumbs' => $breadcrumbs]);
    }
}
