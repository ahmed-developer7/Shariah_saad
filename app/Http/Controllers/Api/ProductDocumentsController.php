<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductDocument;
use App\Models\Project;
use App\Models\ProjectCertificate;
use App\Models\ProjectDocument;
use App\Models\ProjectHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $productDocumentsData = ProductDocument::select('id', 'name', 'name_ar', 'status');
        if (isset($request->search)) {
            $productDocumentsData = $this->search($productDocumentsData, $request->search);
        }
        $productDocuments = $productDocumentsData->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($productDocuments);
    }

    function search($productDocumentsData, $search)
    {
        return $productDocumentsData->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('name_ar', 'like', '%' . $search . '%');
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
            $document = ProductDocument::create(
                [
                    'name' => $request->name,
                    'name_ar' => $request->name_ar,
                    'pages' => $request->pages
                ]
            );

            if ($request->types != 'undefined') {
                $types = explode(',', $request->types);
                $document->types()->sync($types);
            }
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
            $data = [
                'name' => $request->name,
                'name_ar' => $request->name_ar,
                'pages' => $request->pages
            ];

            ProductDocument::where('id', $id)->update($data);

            $document = ProductDocument::find($id);
            $types = explode(',', $request->types);
            $document->types()->sync($types);
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
            ProductDocument::where('id', $id)->delete();
        }
    }

    public function updateStatus($id)
    {
        if ($id) {
            $row = ProductDocument::where('id', $id)->first();
            if ($row->status == 1) {
                $row->status = 0;
            } else {
                $row->status = 1;
            }
            $row->update();
        }
    }

    public function getProductDocument($id = null)
    {
        $docs = ProductDocument::select('id', DB::raw("CONCAT(name, ' / ', name_ar) AS name"))->where('status', 1);
        if ($id) {
            $docs = $docs->whereHas('types', function ($query) use ($id) {
                $query->where('id', $id);
            });
        }
        return $docs->get();
    }

    public function saveDocuments($id, $type, Request $request)
    {
        $original_documents = ProjectDocument::where('project_id', $id)->where('type', $type)->pluck('document_id')->toArray();

        $project = Project::selectRaw("project_id, AES_DECRYPT(`certificate_number`, 's17') certificate_number")
            ->where('project_id', $id)->first();

        $req = $request->all();

        $documents = explode(',', $req['documents']);
        $response = $project->documents()->wherePivotIn('type', ['add', 'amend'])->syncWithPivotValues($documents, ['type' => $type, 'created_at' => now()]);

        if (count($response['attached']) > 0 || count($response['detached']) > 0 || count($response['updated']) > 0) {
            $certificates = ProjectCertificate::getCertificateByClientName($project->certificate_number);
            if (!empty($certificates->certificate_1) && $certificates->certificate_1 != 'n/a' && !str_contains($certificates->certificate_1, '.')) {
                $certificates->certificate_1 = 'n/a';
                $certificates->update();
            }

            $docs = '';
            if (count($original_documents) > 0) {
                foreach ($original_documents as $document) {
                    if (!empty($docs)) {
                        $docs .= ', ';
                    }
                    $docs .= ProductDocument::where('id', $document)->select('name')->first()->name;
                }
            }
            $changed_documents = ProjectDocument::where('project_id', $id)->where('type', $type)->pluck('document_id')->toArray();
            $changed_docs = '';
            if (count($changed_documents) > 0) {
                foreach ($changed_documents as $document) {
                    if (!empty($changed_docs)) {
                        $changed_docs .= ', ';
                    }
                    $changed_docs .= ProductDocument::where('id', $document)->select('name')->first()->name;
                }
            }
            ProjectHistory::create([
                'field' => $type == 'add' ? 'Add Documents' : 'Amend Documents',
                'original_value' => $docs,
                'changed_value' => $changed_docs,
                'project_id' => $id
            ]);

            $number = explode('-', $project->certificate_number);
            if (count($number) == 6) {
                if ($type == 'amend') {
                    $number[6] = '#01';
                } else {
                    $number[6] = '01';
                }
            } elseif (count($number) == 7) {
                if ($type == 'amend') {
                    if (str_contains($number[6], '#')) {
                        $num = explode('#', $number[6]);
                        $num = (int)$num[1] + 1;
                        $number[6] = '#' . sprintf("%02d", $num);
                    } else {
                        $number[7] = '#01';
                    }
                } else {
                    if (!str_contains($number[6], '#')) {
                        $num = (int)$number[6] + 1;
                        $number[6] = sprintf("%02d", $num);
                    } else {
                        $number[7] = '01';
                    }
                }
            } elseif (count($number) == 8) {
                if ($type == 'amend') {
                    if (str_contains($number[6], '#')) {
                        $num = explode('#', $number[6]);
                        $num = (int)$num[1] + 1;
                        $number[6] = '#' . sprintf("%02d", $num);
                    } else {
                        $num = explode('#', $number[7]);
                        $num = (int)$num[1] + 1;
                        $number[7] = '#' . sprintf("%02d", $num);
                    }
                } else {
                    if (!str_contains($number[6], '#')) {
                        $num = (int)$number[6] + 1;
                        $number[6] = sprintf("%02d", $num);
                    } else {
                        $num = (int)$number[7] + 1;
                        $number[7] = sprintf("%02d", $num);
                    }
                }
            }
            $number = implode('-', $number);

            ProjectHistory::create([
                'field' => 'Certificate Number',
                'original_value' => $project->certificate_number,
                'changed_value' => $number,
                'project_id' => $id
            ]);

            $project->certificate_number = DB::raw("AES_ENCRYPT('" . $number . "', 's17')");
            $project->update();
        }

        if (!isset($number)) {
            $number = $project->certificate_number;
        }

        return response()->json(['number' => $number]);
    }

    public function getDocumentsEstimate(Request $request)
    {
        if (isset($request->documents) && count($request->documents) > 0) {
            $hours_for_review = $hours_for_review_by_sam = 0;
            foreach ($request->documents as $document) {
                $pages = ProductDocument::where('id', $document)->select('pages')->first()->pages;
                if (!empty($pages)) {
                    if (isset($request->language_1)) {
                        if ($request->language_1 == 2) {
                            $hours_for_review += $pages * 0.1;
                            $hours_for_review_by_sam += $pages * 0.0478;
                        } elseif ($request->language_1 == 3) {
                            $hours_for_review += $pages * 0.1148;
                            $hours_for_review_by_sam += $pages * 0.0318844;
                        }
                    }
                    if (isset($request->language_2)) {
                        if ($request->language_2 == 2) {
                            $hours_for_review += $pages * 0.1;
                            $hours_for_review_by_sam += $pages * 0.0478;
                        } elseif ($request->language_2 == 3) {
                            $hours_for_review += $pages * 0.1148;
                            $hours_for_review_by_sam += $pages * 0.0318844;
                        }
                    }
                }
            }
            return response()->json(['hours_for_review' => round($hours_for_review, 2), 'hours_for_review_by_sam' => round($hours_for_review_by_sam, 2)]);
        }
    }
}
