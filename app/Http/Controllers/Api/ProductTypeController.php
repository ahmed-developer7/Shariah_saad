<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KindOfProduct;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index(Request $request)
    {
        $productTypeData = KindOfProduct::select('id','name', 'status');
        if (isset($request->search)) {
            $productTypeData = $this->search($productTypeData, $request->search);
        }
        $productTypes = $productTypeData->orderBy('id', 'desc')->paginate(10);

        return response()->json($productTypes);
    }


    function search($productTypeData, $search)
    {
        return $productTypeData->where(function ($query) use ($search) {
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
        if (!empty($request)) {
            $type = KindOfProduct::create(
                [
                    'name' => isset($request->name) ? $request->name : '',
                    'status' => 1,
                    'created_by' => $request->user_id,
                    'updated_by' => $request->user_id
                ]
            );

            if ($request->classifications != 'undefined') {
                $classifications = explode(',', $request->classifications);
                $type->classifications()->sync($classifications);
            }
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
            $data = [
                'name' => $request->name ?? '',
            ];

            KindOfProduct::where('id', $id)->update($data);

            $type = KindOfProduct::find($id);
            $classifications = explode(',', $request->classifications);
            $type->classifications()->sync($classifications);
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
            KindOfProduct::where('id', $id)->delete();
        }
    }

    public function updateStatus($id)
    {
        if ($id) {
            $row = KindOfProduct::where('id', $id)->first();
            if ($row->status == 1) {
                $row->status = 0;
            } else {
                $row->status = 1;
            }
            $row->update();
        }
    }

    public function getProductType($id = null)
    {
        $types = KindOfProduct::select('id', 'name')->where('status', 1);
        if ($id) {
            $types->whereHas('classifications', function ($query) use ($id) {
                $query->where('id', $id);
            });
        }
        return $types->get();
    }
}
