<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Observation;
use App\Models\ObservationHistory;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ObservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $observations = Observation::orderBy('id', 'desc');
        if (isset($request->search)) {
            $search = $request->search;
            $observations = $observations->where(function ($query) use ($search) {
                $query->where('year', 'like', '%' . $search . '%')
                    ->orWhere('function', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('observation_details', 'like', '%' . $search . '%')
                    ->orWhere('risk', 'like', '%' . $search . '%')
                    ->orWhere('recommendation', 'like', '%' . $search . '%')
                    ->orWhere('management_response', 'like', '%' . $search . '%')
                    ->orWhere('date_of_audit', 'like', '%' . $search . '%');
            });
        }
        if (isset($request->c_filter)) {
            $observations = $observations->where('company_id', $request->c_filter);
        }
        if (isset($request->p_filter)) {
            $observations = $observations->where('project_id', $request->p_filter);
        }
        $observations = $observations->with('company:id,name')->paginate(10);
        $observations->load(['project' => function ($query) {
            $query->selectRaw("project_id, AES_DECRYPT(`product`, 's17') product");
        }]);
        return $observations;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty($request)) {
            foreach ($request->fields as $field) {
                Observation::create(
                    [
                        'year' => $field['year'],
                        'function' => $field['function'],
                        'description' => $field['description'],
                        'observation_details' => $field['observation_details'],
                        'risk' => $field['risk'],
                        'recommendation' => $field['recommendation'],
                        'management_response' => $field['management_response'],
                        'date_of_audit' => $field['date_of_audit'],
                        'company_id' => $request->company_id,
                        'project_id' => $request->project_id,
                        'status' => 0
                    ]
                );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!empty($request)) {
            foreach ($request->fields as $field) {
                $data = [
                    'year' => $field['year'],
                    'function' => $field['function'],
                    'description' => $field['description'],
                    'observation_details' => $field['observation_details'],
                    'risk' => $field['risk'],
                    'recommendation' => $field['recommendation'],
                    'management_response' => $field['management_response'],
                    'date_of_audit' => $field['date_of_audit'],
                    'company_id' => $request->company_id,
                    'project_id' => $request->project_id,
                ];
                $observation = Observation::where('id', $id)->first();
                $observation->update($data);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id) {
            Observation::where('id', $id)->delete();
        }
    }

    public function getObservationsCompanies()
    {
        $companies = Company::select('id', 'name')->where('status', 1)->get();
        return response()->json($companies);
    }

    public function getObservationsProducts($id = null)
    {
        $products = Project::selectRaw("project_id, AES_DECRYPT(`product`, 's17') product");
        if ($id) {
            $products = $products->where(DB::raw("AES_DECRYPT(company_client, 's17')"), $id);
        }
        $products = $products->get();
        return response()->json($products);
    }

    public function updateStatus($id, Request $request)
    {
        if ($id && !empty($request)) {
            $observation = Observation::where('id', $id)->first();
            $observation->reason = $request->reason;
            $observation->status = 1;
            $observation->update();
        }
    }

    public function getObservationHistory($id, Request $request)
    {
        $history = ObservationHistory::where('observation_id', $id)->select('field', 'original_value', 'changed_value', 'created_at');
        if (isset($request->search)) {
            $search = $request->search;
            $history = $history->where(function ($query) use ($search) {
                $query->where('field', 'like', '%' . $search . '%')
                    ->orWhere('original_value', 'like', '%' . $search . '%')
                    ->orWhere('changed_value', 'like', '%' . $search . '%');
            });
        }
        return $history->orderBy('created_at', 'desc')->paginate(15);
    }
}
