<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\ProjectScholar;
use App\Models\Scholar;
use Illuminate\Http\Request;

class ScholarController extends Controller
{
    public function index(Request $request)
    {
        $scholarsData = Scholar::select('id', 'first_name', 'last_name', 'description', 'status', 'email');
        if (isset($request->search)) {
            $scholarsData = $this->search($scholarsData, $request->search);
        }
        $scholars = $scholarsData->orderBy('id', 'desc')->paginate(10);

        return response()->json($scholars);
    }


    function search($scholarsData, $search)
    {
        return $scholarsData->where(function ($query) use ($search) {
            $query->where('id', 'like', '%' . $search . '%')
                ->orWhere('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
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
            if ($request->hasFile('picture')) {
                $request->validate([
                    'picture' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048'
                ]);
                $picture = Helpers::upload($request->picture, 'scholar');
            }
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
            Scholar::create(
                [
                    'first_name' => isset($request->first_name) ? $request->first_name : '',
                    'last_name' => isset($request->last_name) ? $request->last_name : '',
                    'picture' => isset($picture) ? $picture : '',
                    'status' => 1,
                    'created_by' => $request->user_id,
                    'updated_by' => $request->user_id,
                    'email' => $request->email,
                    'first_name_ar' => $request->first_name_ar,
                    'last_name_ar' => $request->last_name_ar
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
            $scholar = Scholar::where('id', $id)->first();

            if ($request->hasFile('picture')) {
                $request->validate([
                    'picture' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048'
                ]);
                $picture = Helpers::upload($request->picture, 'scholar');
            }

            $data = [
                'first_name' => isset($request->first_name) ? $request->first_name : '',
                'last_name' => isset($request->last_name) ? $request->last_name : '',
                'picture' => isset($picture) ? $picture : $scholar->picture,
                'email' => $request->email,
                'first_name_ar' => $request->first_name_ar,
                'last_name_ar' => $request->last_name_ar
            ];

            $scholar->update($data);
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
            Scholar::where('id', $id)->delete();
        }
    }


    function upload($file)
    {
        $picture = time() . '.' . $file->extension();
        $file->move(public_path('uploads'), $picture);
        return $picture;
    }

    public function updateStatus($id)
    {
        if ($id) {
            $row = Scholar::where('id', $id)->first();
            if ($row->status == 1) {
                $row->status = 0;
            } else {
                $row->status = 1;
            }
            $row->update();
        }
    }

    public function checkSignature($id)
    {
        $project_scholar = ProjectScholar::where('project_id', $id)->get();
        if (count($project_scholar) > 0) {
            $scholars = '';
            foreach ($project_scholar as $item) {
                $scholar = Scholar::where('id', $item->scholar_id)->whereNotNull('picture')->select('first_name', 'last_name', 'picture')->first();
                if ($scholar && $scholar->picture != '') {
                    if (!empty($scholars)) {
                        $scholars .= ', ';
                    }
                    $scholars .= $scholar->first_name . ' ' . $scholar->last_name;
                }
            }
            if (!empty($scholars)) {
                return response()->json($scholars);
            }
        }
    }

}
