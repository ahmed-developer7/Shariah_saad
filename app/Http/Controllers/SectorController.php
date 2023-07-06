<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['name' => "Sector List"]
        ];
        return view('content.sector', ['breadcrumbs' => $breadcrumbs]);
    }

    public function addSector()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/sectors", 'name' => "Sector List"], ['name' => "Add Sector"]
        ];
        $sector = [];
        return view('content.add-sector', ['sector' => $sector, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editSector($id)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/sectors", 'name' => "Sector List"], ['name' => "Edit Sector"]
        ];
        $sector = Sector::where('id', $id)->select('id',
            'name')->first();

        return view('content.add-sector', ['sector' => $sector, 'breadcrumbs' => $breadcrumbs]);
    }
}
