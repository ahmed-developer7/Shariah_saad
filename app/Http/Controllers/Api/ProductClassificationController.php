<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductClassification;
use Illuminate\Http\Request;

class ProductClassificationController extends Controller
{
    public function index(Request $request)
    {
        $productClassificationData = ProductClassification::select('id','name', 'status');
        if (isset($request->search)) {
            $productClassificationData = $this->search($productClassificationData, $request->search);
        }
        $productClassifications = $productClassificationData->paginate(10);

        return response()->json($productClassifications);
    }

    function search($productClassificationData, $search)
    {
        return $productClassificationData->where(function ($query) use ($search) {
            $query->where('id', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%');
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
//            if ($request->hasFile('terminationLetter')) {
//                $request->validate([
//                    'terminationLetter' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048'
//                ]);
//                $terminationLetter = $this->upload($request->terminationLetter);
//            }
//            return $terminationLetter;
//            return \request()->all();
//            $company = new Company();
//            $company->name = isset($request->name) ? $request->name : '';
//            $company->short_name = isset($request->short_name) ? $request->short_name : '';
//            $company->description = isset($request->description) ? $request->description : '';
//            $company->picture = $terminationLetter ?? '';
//            $company->status = 1;
//            $company->created_by = 1;
//            $company->updated_by = 1;
//            $company->created_at = 1;
//            $company->updated_at = 1;
//            $company->save();
            ProductClassification::create(
                [
                    'name' => isset($request->name) ? $request->name : '',
                    'sector_id' => 1,
                    'status' => 1,
                    'created_by' => $request->user_id,
                    'updated_by' => $request->user_id
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
//            if ($request->hasFile('terminationLetter')) {
//                $request->validate([
//                    'terminationLetter' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048'
//                ]);
//                $terminationLetter = $this->upload($request->terminationLetter);
//            }

            $data = [
                'name' => isset($request->name) ? $request->name : '',
//                'short_name' => isset($request->short_name) ? $request->short_name : '',
//                'description' => isset($request->description) ? $request->description : '',
//                'picture' => $terminationLetter ?? '',
            ];

            ProductClassification::where('id', $id)->update($data);
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
            ProductClassification::where('id', $id)->delete();
        }
    }

    public function updateStatus($id)
    {
        if ($id) {
            $row = ProductClassification::where('id', $id)->first();
            if ($row->status == 1) {
                $row->status = 0;
            } else {
                $row->status = 1;
            }
            $row->update();
        }
    }

    public function getProductClassification()
    {
        return ProductClassification::select('id', 'name')->where('status', 1)->get();
    }
}
