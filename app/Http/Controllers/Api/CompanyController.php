<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Project;
use App\Models\ShariyahCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companiesData = Company::select('id', 'name', 'short_name', 'description', 'status', 'picture');
        if (isset($request->search)) {
            $companiesData = $this->search($companiesData, $request->search);
        }
        $companies = $companiesData->orderBy('id', 'desc')->paginate(10);

        return response()->json($companies);
    }


    function search($companiesData, $search)
    {
        return $companiesData->where(function ($query) use ($search) {
            $query->where('id', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('short_name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request->terminationLetter;
        if (!empty($request)) {
            if ($request->hasFile('terminationLetter')) {
                $request->validate([
                    'terminationLetter' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048'
                ]);
                $terminationLetter = Helpers::upload($request->terminationLetter, 'company');
            }
            $request->validate([
                'short_name' => 'required|unique:companies,short_name'
            ]);
            Company::create(
                [
                    'name' => isset($request->name) ? $request->name : '',
                    'name_ar' => $request->name_ar,
                    'short_name' => isset($request->short_name) ? $request->short_name : '',
                    'description' => isset($request->description) ? $request->description : '',
                    'picture' => isset($terminationLetter) ? $terminationLetter : '',
                    'status' => 1,
                    'created_by' => $request->user_id,
                    'updated_by' => $request->user_id,
                    'shariyah_company_id' => $request->shariyah_company_id
                ]
            );
        }
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
            if ($request->hasFile('terminationLetter')) {
                $request->validate([
                    'terminationLetter' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048'
                ]);
                $terminationLetter = Helpers::upload($request->terminationLetter, 'company');
            }
            $request->validate([
                'short_name' => 'required|unique:companies,short_name,' . $id
            ]);
            $data = [
                'name' => isset($request->name) ? $request->name : '',
                'name_ar' => $request->name_ar,
                'short_name' => isset($request->short_name) ? $request->short_name : '',
                'description' => isset($request->description) ? $request->description : '',
                'shariyah_company_id' => $request->shariyah_company_id
            ];

            if (isset($terminationLetter)) {
                $data['picture'] = $terminationLetter;
            }

            Company::where('id', $id)->update($data);
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
            Company::where('id', $id)->delete();
        }
    }

    function upload($file)
    {
        $letter = time() . '.' . $file->extension();
        $file->move(public_path('uploads'), $letter);
        return $letter;
    }

    public function updateStatus($id)
    {
        if ($id) {
            $row = Company::where('id', $id)->first();
            if ($row->status == 1) {
                $row->status = 2;
            } else {
                $row->status = 1;
            }
            $row->update();
        }
    }

    public function getCode($id)
    {
        if ($id) {
            $code = Company::select('short_name')->where('id', $id)->first()->short_name;

            $project_data = Project::selectRaw("AES_DECRYPT(`certificate_number`, 's17') certificate_number")->whereNotNull("certificate_number");

            $total_certificates = $project_data->count();

            $certificate_numbers_data = $project_data->where(DB::raw("AES_DECRYPT(client_code, 's17')"), $code);

            $total_certificates_client = $certificate_numbers_data->count();
            $total_certificates_client += 1;
            $total_certificates_client = sprintf("%02d", $total_certificates_client);

            $total_certificates_client_year = $certificate_numbers_data->where(DB::raw("AES_DECRYPT(year, 's17')"), date("Y"))->count();
            $total_certificates_client_year += 1;
            $total_certificates_client_year = sprintf("%02d", $total_certificates_client_year);

            $month = date("m");

            $year = date("y");

            $certificate_number = $code . '-' . $total_certificates . '-' . $total_certificates_client . '-' .
                $total_certificates_client_year . '-' . $month . '-' . $year;

            return response()->json(['code' => $code, 'certificate_number' => $certificate_number]);
        }
    }

    function deleteTermination($id)
    {
        if ($id) {
            $company = Company::where('id', $id);
            $picture = $company->select('picture')->first()->picture;
            $company->update(['picture' => 'n/a']);
            $path = public_path("uploads/" . $picture);
            if (is_file($path)) {
                unlink($path);
            }
        }
    }

    public function getShariyahCompanies()
    {
        return ShariyahCompany::select('id', 'name')->get();
    }

}
