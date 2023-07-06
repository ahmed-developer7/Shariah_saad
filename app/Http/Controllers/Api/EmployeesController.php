<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $employees = Employee::orderBy('created_at', 'desc');
        if (isset($request->search)) {
            $search = $request->search;
            $employees = $employees->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('short_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        return $employees->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty($request)) {
            if ($request->hasFile('picture')) {
                $request->validate([
                    'picture' => 'mimes:pdf,jpeg,jpg,png|max:2048'
                ]);
                $request->picture = Helpers::upload($request->picture, 'employee');
            }

            Employee::create(
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'short_name' => $request->short_name,
                    'picture' => $request->picture,
                    'description' => $request->description,
                    'status' => 1,
                    'created_by' => $request->user_id,
                    'updated_by' => $request->user_id,
                    'first_name_ar' => $request->first_name_ar,
                    'last_name_ar' => $request->last_name_ar
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!empty($request)) {
            if ($request->hasFile('picture')) {
                $request->validate([
                    'picture' => 'mimes:pdf,jpeg,jpg,png|max:2048'
                ]);
                $picture = Helpers::upload($request->picture, 'employee');
            }

            $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'short_name' => $request->short_name,
                'description' => $request->description,
                'updated_by' => $request->user_id,
                'first_name_ar' => $request->first_name_ar,
                'last_name_ar' => $request->last_name_ar
            ];
            if (isset($picture)) {
                $data['picture'] = $picture;
            }

            Employee::where('id', $id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id) {
            Employee::where('id', $id)->delete();
        }
    }

    public function updateStatus($id)
    {
        if ($id) {
            $employee = Employee::where('id', $id)->first();
            if ($employee->status == 1) {
                $employee->status = 0;
            } else {
                $employee->status = 1;
            }
            $employee->update();
        }
    }
}
