<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['name' => "Manage Employees"]
        ];
        return view('content.employees', ['breadcrumbs' => $breadcrumbs]);
    }

    public function addEmployee()
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/employees", 'name' => "Manage Employees"], ['name' => "Add Employee"]
        ];
        $employee = [];
        return view('content.add-employee', ['employee' => $employee, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editEmployee($id)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/employees", 'name' => "Manage Employees"], ['name' => "Edit Employee"]
        ];
        $employee = Employee::find($id);
        return view('content.add-employee', ['employee' => $employee, 'breadcrumbs' => $breadcrumbs]);
    }
}
