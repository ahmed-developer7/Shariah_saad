<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['name' => "Client List"]
        ];
        return view('content.company', ['breadcrumbs' => $breadcrumbs]);
    }

    public function addCompany()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/companies", 'name' => "Client List"], ['name' => "Add Client"]
        ];
        $company = [];
        return view('content.add-company', ['company' => $company, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editCompany($id)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/companies", 'name' => "Client List"], ['name' => "Edit Client"]
        ];
        $company = Company::where('id', $id)->select('id',
            'name', 'short_name', 'description', 'name_ar', 'shariyah_company_id')->first();

        return view('content.add-company', ['company' => $company, 'breadcrumbs' => $breadcrumbs]);
    }

}
