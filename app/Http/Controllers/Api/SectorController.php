<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index(Request $request)
    {
        $sectorsData = Sector::select('id','name', 'status');
        if (isset($request->search)) {
            $sectorsData = $this->search($sectorsData, $request->search);
        }
        $sectors = $sectorsData->paginate(10);

        return response()->json($sectors);
    }


    function search($sectorsData, $search)
    {
        return $sectorsData->where(function ($query) use ($search) {
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
            Sector::create(
                [
                    'name' => isset($request->name) ? $request->name : '',
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

            Sector::where('id', $id)->update($data);
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
            Sector::where('id', $id)->delete();
        }
    }

    public function updateStatus($id)
    {
        if ($id) {
            $row = Sector::where('id', $id)->first();
            if ($row->status == 1) {
                $row->status = 0;
            } else {
                $row->status = 1;
            }
            $row->update();
        }
    }
}
