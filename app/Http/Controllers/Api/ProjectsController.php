<?php

namespace App\Http\Controllers\Api;

use App\Exports\ProjectsExport;
use App\Helpers\Helpers;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Guideline;
use App\Models\KindOfProduct;
use App\Models\Language;
use App\Models\ProductClassification;
use App\Models\ProductDocument;
use App\Models\Project;
use App\Models\ProjectCertificate;
use App\Models\ProjectDocument;
use App\Models\ProjectHistory;
use App\Models\ProjectScholar;
use App\Models\Scholar;
use App\Models\Sector;
use App\Models\User;
use App\Models\UserSector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $projectsData = Project::selectRaw("project_id,
                                          AES_DECRYPT(company_client, 's17') company_client,
                                          AES_DECRYPT(client_code, 's17') client_code,
                                          AES_DECRYPT(certificate_status, 's17') certificate_status,
                                          AES_DECRYPT(`contact_person`, 's17') contact_person,
                                          AES_DECRYPT(`email`, 's17') email,
                                          AES_DECRYPT(`contact_number`, 's17') contact_number,
                                          AES_DECRYPT(`certificate_number`, 's17') certificate_number,
                                          AES_DECRYPT(`year`, 's17') year,
                                          AES_DECRYPT(`month`, 's17') month,
                                          AES_DECRYPT(`name_of_fund`, 's17') name_of_fund,
                                          AES_DECRYPT(`type_of_fund`, 's17') type_of_fund,
                                          AES_DECRYPT(`fund_size`, 's17') fund_size,
                                          AES_DECRYPT(`fund_currency`, 's17') fund_currency,
                                          AES_DECRYPT(`domicile`, 's17') domicile,
                                          AES_DECRYPT(`work_type`, 's17') work_type,
                                          AES_DECRYPT(`query`, 's17') query,
                                          AES_DECRYPT(`launch_status`, 's17') launch_status,
                                          AES_DECRYPT(`not_launched`, 's17') not_launched,
                                          AES_DECRYPT(`product`, 's17') product,
                                          AES_DECRYPT(`date_received`, 's17') date_received,
                                          AES_DECRYPT(`date_completed`, 's17') date_completed,
                                          AES_DECRYPT(`no_of_days`, 's17') no_of_days,
                                          AES_DECRYPT(`hours_for_review`, 's17') hours_for_review,
                                          AES_DECRYPT(`pages`, 's17') pages,
                                          AES_DECRYPT(`language`, 's17') language,
                                          AES_DECRYPT(`scholars_name`, 's17') scholars_name,
                                          AES_DECRYPT(`other_employees`, 's17') other_employees,
                                          AES_DECRYPT(`no_of_touchpoints`, 's17') no_of_touchpoints,
                                          AES_DECRYPT(`estimated_calls`, 's17') estimated_calls,
                                          AES_DECRYPT(`audit`, 's17') audit,
                                          AES_DECRYPT(`screening`, 's17') screening,
                                          AES_DECRYPT(`certificate_1`, 's17') certificate_1,
                                          AES_DECRYPT(`certificate_2`, 's17') certificate_2,
                                          AES_DECRYPT(`projects`.`status`, 's17')   status,
                                          AES_DECRYPT(`remarks_1`, 's17') remarks_1,
                                          AES_DECRYPT(`remarks_2`, 's17') remarks_2,
                                          AES_DECRYPT( `data_entry_operator`, 's17') data_entry_operator,
                                          `date_and_time`,
                                          AES_DECRYPT(`last_update`, 's17' ) last_update,
                                          AES_DECRYPT(`currency_table`, 's17' ) currency_table ,
                                          AES_DECRYPT(`language_1`, 's17') language_1 ,
                                          AES_DECRYPT(`language_2`, 's17') language_2,
                                          AES_DECRYPT(`employee_1`, 's17') employee_1,
                                          AES_DECRYPT(`employee_2`, 's17') employee_2,
                                          AES_DECRYPT(`employee_3`, 's17') employee_3,
                                          AES_DECRYPT(`employee_4`, 's17') employee_4,
                                          AES_DECRYPT(`kind_of_doc`, 's17') kind_of_doc,
                                          AES_DECRYPT(`kind_of_product`, 's17') kind_of_product,
                                          AES_DECRYPT(projects.sector_id, 's17') sector_id,
                                          AES_DECRYPT(`product_classification_id`, 's17') product_classification_id,
                                          product_ar");

        if (isset($request->company_client)) {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(`company_client`, 's17')"), (int)$request->company_client);
        }
        if (isset($request->kind_of_product)) {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(kind_of_product, 's17')"), (int)$request->kind_of_product);
        }
        if (isset($request->product_classification_id)) {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(product_classification_id, 's17')"), (int)$request->product_classification_id);
        }
        if (isset($request->scholar_id)) {
            $scholar_id = (int)$request->scholar_id;
            $projectsData = $projectsData->where(function ($query) use ($scholar_id) {
                $query->where(DB::raw("AES_DECRYPT(scholar_1, 's17')"), $scholar_id)
                    ->orWhere(DB::raw("AES_DECRYPT(scholar_2, 's17')"), $scholar_id)
                    ->orWhere(DB::raw("AES_DECRYPT(scholar_3, 's17')"), $scholar_id)
                    ->orWhere(DB::raw("AES_DECRYPT(scholar_4, 's17')"), $scholar_id);
            });
        }
        if (isset($request->sector_id)) {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(sector_id, 's17')"), (int)$request->sector_id);
        }
        if (isset($request->year) && $request->year != 'All years') {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(year, 's17')"), (int)$request->year);
        }
        if (isset($request->year_range_1) && isset($request->year_range_2)) {
            $projectsData = $projectsData->whereBetween(DB::raw("AES_DECRYPT(year, 's17')"), [$request->year_range_1, $request->year_range_2]);
        }

        $user = User::where('id', $request->user_id)->select('usertype')->first();
        if ($user && $user->usertype == 'SAM') {
            $sectors = UserSector::where('user_id', $request->user_id)->pluck('sector_id')->toArray();
            $projectsData = $projectsData->whereIn(DB::raw("AES_DECRYPT(projects.sector_id, 's17')"), $sectors);
        }

        if (isset($request->id) && !empty($request->id) && $request->id != 'null') {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(projects.company_client, 's17')"), $request->id);
        }

        if (isset($request->search)) {
            $projectsData = $this->search($projectsData, $request->search);
        }

        $projects = $projectsData->with('company:id,name', 'sector:id,name', 'productClassification:id,name',
            'kindOfProd:id,name', 'scholars:id,first_name,last_name')->orderBy('date_and_time', 'desc')->paginate(10);

        $projects->load(['documents' => function ($query) {
            $query->where('type', 'regular');
        }]);

        $projects = $this->extras($projects);

        return response()->json($projects);
    }

    function extras($projects)
    {
        foreach ($projects as $project) {
            $project->certificates = ProjectCertificate::getCertificateByClientName($project->certificate_number);
        }
        return $projects;
    }

    function search($projectsData, $search)
    {
        return $projectsData
            ->leftJoin('companies', DB::raw("AES_DECRYPT(projects.company_client, 's17')"), '=', 'companies.id')
            ->leftJoin('sector', DB::raw("AES_DECRYPT(projects.sector_id, 's17')"), '=', 'sector.id')
            ->leftJoin('product_classification', DB::raw("AES_DECRYPT(projects.product_classification_id, 's17')"), '=', 'product_classification.id')
            ->leftJoin('kind_of_products', DB::raw("AES_DECRYPT(projects.kind_of_product, 's17')"), '=', 'kind_of_products.id')
            ->where(function ($query) use ($search) {
                $query->where('companies.name', 'like', '%' . $search . '%')
                    ->orWhere('sector.name', 'like', '%' . $search . '%')
                    ->orWhere('product_classification.name', 'like', '%' . $search . '%')
                    ->orWhere('kind_of_products.name', 'like', '%' . $search . '%')
                    ->orWhere(DB::raw("AES_DECRYPT(kind_of_product, 's17')"), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw("AES_DECRYPT(certificate_number, 's17')"), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw("AES_DECRYPT(product, 's17')"), 'like', '%' . $search . '%')
                    ->orWhere(DB::raw("AES_DECRYPT(date_completed, 's17')"), 'like', '%' . $search . '%')
                    ->orWhereHas('scholars', function ($query) use ($search) {
                        $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%" . $search . "%");
                    })
                    ->orWhereHas('documents', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%" . $search . "%")->where('type', 'regular');
                    });
            });
    }

    function deleteCertification(Request $request)
    {
        if (!empty($request) && $request->id) {
            ProjectCertificate::deleteCertificateById($request->id);
        }
    }

    function deleteTermination(Request $request)
    {
        if (!empty($request) && $request->id) {
            ProjectCertificate::deleteTerminationById($request->id);
        }
    }

    public function getProjectData($excel = null)
    {
        $data['sectors'] = Sector::select('id', 'name')->where('status', 1)->get();
        $data['product_classification'] = ProductClassification::select('id', 'name')->where('status', 1)->get();
        $data['companies'] = Company::select('id', DB::raw("CONCAT(name, ' / ', name_ar) AS name"))->where('status', 1)->get();
        $data['languages'] = Language::select('id', 'name')->where('status', 1)->get();
        $data['scholars'] = Scholar::select('id', 'first_name', 'last_name')->where('status', 1)->get();
        $data['employees'] = Employee::select('id', DB::raw("CONCAT(first_name, ' ', last_name) AS name"))->where('status', 1)->get();

        $data['guidelines'] = Guideline::select('id', 'name')->get()->toArray();
        $guideline = [['id' => '', 'name' => '', 'heading' => 'Guidelines for Funds']];
        array_splice($data['guidelines'], 0, 0, $guideline);
        $guideline = [['id' => '', 'name' => '', 'heading' => 'Guidelines for Products']];
        array_splice($data['guidelines'], 7, 0, $guideline);
        $guideline = [['id' => '', 'name' => '', 'heading' => 'Guidelines for Structure']];
        array_splice($data['guidelines'], 12, 0, $guideline);

        if ($excel) {
            $data['kind_of_products'] = KindOfProduct::select('id', 'name')->where('status', 1)->get();
        }
        return response()->json($data);
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
            if ($request->hasFile('certificate_1')) {
                $request->validate([
                    'certificate_1' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048'
                ]);
                $certificate_1 = Helpers::upload($request->certificate_1, 'certificate');
            }
            if ($request->hasFile('certificate_2')) {
                $request->validate([
                    'certificate_2' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048'
                ]);
                $certificate_2 = Helpers::upload($request->certificate_2, 'termination');
            }

            $project = Project::create(
                [
                    'sector_id' => isset($request->sector_id) && !empty($request->sector_id) ? $this->encrypt($request->sector_id) : $this->encrypt(''),
                    'product_classification_id' => isset($request->product_classification_id) && !empty($request->product_classification_id) ? $this->encrypt($request->product_classification_id) : $this->encrypt(''),
                    'company_client' => $this->encrypt($request->company_client),
                    'client_code' => $this->encrypt($request->client_code),
                    'certificate_number' => isset($request->certificate_number) && !empty($request->certificate_number) ? $this->encrypt($request->certificate_number) : $this->encrypt(''),
                    'status' => isset($request->status) && !empty($request->status) ? $this->encrypt($request->status) : $this->encrypt(''),
                    'remarks_1' => isset($request->remarks_1) && !empty($request->remarks_1) ? $this->encrypt($request->remarks_1) : $this->encrypt(''),
                    'last_update' => $this->encrypt("Please contact +973 17215898 to learn about the status of Sharia audit"),
                    'date_received' => isset($request->date_received) && !empty($request->date_received) ? $this->encrypt($request->date_received) : $this->encrypt(''),
                    'date_completed' => isset($request->date_completed) && !empty($request->date_completed) ? $this->encrypt($request->date_completed) : $this->encrypt(''),
                    'kind_of_product' => isset($request->kind_of_product) && !empty($request->kind_of_product) ? $this->encrypt($request->kind_of_product) : $this->encrypt(''),
                    'product' => isset($request->product) && !empty($request->product) ? $this->encrypt($request->product) : $this->encrypt(''),
                    'product_ar' => isset($request->product_ar) && !empty($request->product_ar) ? $request->product_ar : '',
                    'fund_size' => isset($request->fund_size) && !empty($request->fund_size) ? $this->encrypt($request->fund_size) : $this->encrypt(''),
                    'fund_currency' => isset($request->fund_currency) && !empty($request->fund_currency) ? $this->encrypt($request->fund_currency) : $this->encrypt(''),
                    'no_of_documents' => isset($request->no_of_documents) && !empty($request->no_of_documents) ? $this->encrypt($request->no_of_documents) : $this->encrypt(''),
                    'hours_for_review' => isset($request->hours_for_review) && !empty($request->hours_for_review) ? $this->encrypt($request->hours_for_review) : $this->encrypt(''),
                    'hours_for_review_by_sam' => isset($request->hours_for_review_by_sam) && !empty($request->hours_for_review_by_sam) ? $this->encrypt($request->hours_for_review_by_sam) : $this->encrypt(''),
                    'no_of_days' => isset($request->no_of_days) && !empty($request->no_of_days) ? $this->encrypt($request->no_of_days) : $this->encrypt(''),
                    'no_of_touchpoints' => isset($request->no_of_touchpoints) && !empty($request->no_of_touchpoints) ? $this->encrypt($request->no_of_touchpoints) : $this->encrypt(''),
                    'estimated_calls' => isset($request->estimated_calls) && !empty($request->estimated_calls) ? $this->encrypt($request->estimated_calls) : $this->encrypt(''),
                    'call_timing' => isset($request->call_timing) && !empty($request->call_timing) ? $this->encrypt($request->call_timing) : $this->encrypt(''),
                    'language_1' => $this->encrypt($request->language_1),
                    'language_2' => $this->encrypt($request->language_2),
                    'employee_1' => $this->encrypt($request->employee_1),
                    'employee_2' => $this->encrypt($request->employee_2),
                    'x_xs' => $this->encrypt('N/A'),
                    'y_xs' => $this->encrypt('N/A'),
                    'currency_table' => $this->encrypt('N/A'),
                    'updated_by' => $request->updated_by,
                    'employee_3' => $this->encrypt('N/A'),
                    'employee_4' => $this->encrypt('N/A'),
                    'certificate_1' => isset($certificate_1) ? $this->encrypt($certificate_1) : $this->encrypt(''),
                    'certificate_2' => isset($certificate_2) ? $this->encrypt($certificate_2) : $this->encrypt(''),
                    'date_and_time' => now(),
                    'year' => $this->encrypt(date("Y")),
                    'template' => $request->template,
                    'guideline_id' => $request->guideline_id
                ]
            );

            if ($request->scholars != 'undefined') {
                $scholars = explode(',', $request->scholars);
                $project->scholars()->sync($scholars);
            }

            if (isset($request->documents) && !empty($request->documents) && $request->documents != 'undefined') {
                $documents = explode(',', $request->documents);
                $project->documents()->wherePivot('type', 'regular')->syncWithPivotValues($documents, ['type' => 'regular', 'created_at' => now()]);
            }

            if (isset($certificate_1) || isset($certificate_2)) {
                ProjectCertificate::create(
                    [
                        'certificate_number' => !empty($request->certificate_number) ? $request->certificate_number : 'N/A',
                        'certificate_1' => $certificate_1 ?? 'N/A',
                        'certificate_2' => $certificate_2 ?? null,
                        'created_by' => $request->updated_by
                    ]
                );
            }

            return $project;
        }
    }

    function upload($file, $name)
    {
        $certificate = $name . '_' . time() . '.' . $file->extension();
        $file->move(public_path('uploads'), $certificate);
        return $certificate;
    }

    function encrypt($data)
    {
        if (empty($data)) {
            return DB::raw("AES_ENCRYPT('', 's17')");
        }
        return DB::raw("AES_ENCRYPT('" . $data . "', 's17')");
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
            $certificates = ProjectCertificate::where('certificate_number', $request->certificate_number)->first();
            if ($certificates) {
                $certificate_1 = $certificates->certificate_1;
                $certificate_2 = $certificates->certificate_2;
            } else {
                $certificate_1 = 'N/A';
                $certificate_2 = null;
            }
            if ($request->hasFile('certificate_1')) {
                $request->validate([
                    'certificate_1' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048'
                ]);
                $certificate_1 = Helpers::upload($request->certificate_1, 'certificate');
            }
            if ($request->hasFile('certificate_2')) {
                $request->validate([
                    'certificate_2' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048'
                ]);
                $certificate_2 = Helpers::upload($request->certificate_2, 'termination');
            }

            $this->setHistory($id, $request->all(), $certificate_1, $certificate_2);

            $data = [
                'sector_id' => $this->encrypt($request->sector_id),
                'product_classification_id' => $this->encrypt($request->product_classification_id),
                'certificate_number' => $this->encrypt($request->certificate_number),
                'status' => $this->encrypt($request->status),
                'remarks_1' => $this->encrypt($request->remarks_1),
                'last_update' => $this->encrypt($request->last_update),
                'date_received' => $this->encrypt($request->date_received),
                'date_completed' => $this->encrypt($request->date_completed),
                'kind_of_product' => $this->encrypt($request->kind_of_product),
                'product' => $this->encrypt($request->product),
                'product_ar' => $request->product_ar,
                'fund_size' => $this->encrypt($request->fund_size),
                'fund_currency' => $this->encrypt($request->fund_currency),
                'no_of_documents' => $this->encrypt($request->no_of_documents),
                'hours_for_review' => $this->encrypt($request->hours_for_review),
                'hours_for_review_by_sam' => $this->encrypt($request->hours_for_review_by_sam),
                'no_of_days' => $this->encrypt($request->no_of_days),
                'no_of_touchpoints' => $this->encrypt($request->no_of_touchpoints),
                'estimated_calls' => $this->encrypt($request->estimated_calls),
                'call_timing' => $this->encrypt($request->call_timing),
                'language_1' => $this->encrypt($request->language_1),
                'language_2' => $this->encrypt($request->language_2),
                'employee_1' => $this->encrypt($request->employee_1),
                'employee_2' => $this->encrypt($request->employee_2),
                'certificate_1' => $this->encrypt($certificate_1),
                'certificate_2' => $this->encrypt($certificate_2),
                'updated_by' => $request->updated_by,
                'template' => $request->template,
                'guideline_id' => $request->guideline_id
            ];

            $project = Project::find($id);
            $project->update($data);

            $scholars = explode(',', $request->scholars);
            ProjectScholar::where('project_id', $id)->delete();
            $project->scholars()->sync($scholars);

            if (isset($request->documents) && !empty($request->documents) && $request->documents != 'undefined') {
                $documents = explode(',', $request->documents);
                $response = $project->documents()->wherePivot('type', 'regular')->syncWithPivotValues($documents, ['type' => 'regular', 'created_at' => now()]);
                if (count($response['attached']) > 0 || count($response['detached']) > 0 || count($response['updated']) > 0) {
                    $this->updateCertificate($id);
                }
            } else {
                ProjectDocument::where('project_id', $id)->where('type', 'regular')->delete();
                $this->updateCertificate($id);
            }

            if ($certificates) {
                $data = [
                    'certificate_1' => $certificate_1,
                    'certificate_2' => $certificate_2
                ];
                ProjectCertificate::where('certificate_number', $request->certificate_number)->update($data);
            } else {
                ProjectCertificate::create(
                    [
                        'certificate_number' => !empty($request->certificate_number) ? $request->certificate_number : 'N/A',
                        'certificate_1' => $certificate_1,
                        'certificate_2' => $certificate_2,
                        'created_by' => $request->updated_by
                    ]
                );
            }
        }
    }

    public function updateCertificate($id)
    {
        $project = Project::selectRaw("project_id, AES_DECRYPT(`certificate_number`, 's17') certificate_number")->where('project_id', $id)->first();
        $project->certificates = ProjectCertificate::getCertificateByClientName($project->certificate_number);
        if (!empty($project->certificates->certificate_1) && $project->certificates->certificate_1 != 'n/a' && !str_contains($project->certificates->certificate_1, '.')) {
            $project->certificates->certificate_1 = 'n/a';
            $project->certificates->update();
        }
    }

    public function setHistory($id, $request, $certificate_1, $certificate_2)
    {
        $project = Project::selectRaw("AES_DECRYPT(`certificate_number`, 's17') certificate_number,
        AES_DECRYPT(`fund_size`, 's17') fund_size, AES_DECRYPT(`fund_currency`, 's17') fund_currency,
        AES_DECRYPT(`product`, 's17') product, AES_DECRYPT(`date_received`, 's17') date_received,
        AES_DECRYPT(`hours_for_review`, 's17') hours_for_review, AES_DECRYPT(`hours_for_review_by_sam`, 's17') hours_for_review_by_sam,
        AES_DECRYPT(`estimated_calls`, 's17') estimated_calls, AES_DECRYPT(`certificate_1`, 's17') certificate_1, AES_DECRYPT(`certificate_2`, 's17') certificate_2,
        AES_DECRYPT(`projects`.`status`, 's17') status, AES_DECRYPT(`remarks_1`, 's17') remarks_1,
        AES_DECRYPT(`language_1`, 's17') language_1, AES_DECRYPT(`language_2`, 's17') language_2,
        AES_DECRYPT(`employee_1`, 's17') employee_1, AES_DECRYPT(`employee_2`, 's17') employee_2,
        AES_DECRYPT(`kind_of_product`, 's17') kind_of_product, AES_DECRYPT(projects.sector_id, 's17') sector_id,
        AES_DECRYPT(`product_classification_id`, 's17') product_classification_id, AES_DECRYPT(`call_timing`, 's17') call_timing,
        product_ar, updated_by, template, guideline_id")->where('project_id', $id)->first()->toArray();

        $fields = ['template', 'guideline_id', 'sector_id', 'product_classification_id', 'certificate_number', 'status',
            'remarks_1', 'date_received', 'kind_of_product', 'product', 'product_ar', 'fund_size', 'fund_currency',
            'hours_for_review', 'hours_for_review_by_sam', 'estimated_calls', 'call_timing', 'language_1', 'language_2',
            'employee_1', 'employee_2', 'updated_by', 'certificate_1', 'certificate_2'];

        foreach ($fields as $field) {
            if ($project[$field] != $request[$field]) {
                if ($field == 'template') {
                    $field_name = 'Template';
                    if ($project[$field] == 'srb_template') {
                        $project[$field] = 'SRB template';
                    } else if ($project[$field] == 'al_marjea_template') {
                        $project[$field] = 'Al-Marjea template';
                    }
                    if ($request[$field] == 'srb_template') {
                        $request[$field] = 'SRB template';
                    } else if ($request[$field] == 'al_marjea_template') {
                        $request[$field] = 'Al-Marjea template';
                    }
                } elseif ($field == 'guideline_id') {
                    $guideline = Guideline::where('id', $project[$field])->select('name')->first();
                    if ($guideline) {
                        $project[$field] = $guideline->name;
                    } else {
                        $project[$field] = '';
                    }
                    $guideline = Guideline::where('id', $request[$field])->select('name')->first();
                    if ($guideline) {
                        $request[$field] = $guideline->name;
                    } else {
                        $request[$field] = '';
                    }
                    $field_name = 'Guideline';
                } elseif ($field == 'sector_id') {
                    $sector = Sector::where('id', $project[$field])->select('name')->first();
                    if ($sector) {
                        $project[$field] = $sector->name;
                    } else {
                        $project[$field] = '';
                    }
                    $sector = Sector::where('id', $request[$field])->select('name')->first();
                    if ($sector) {
                        $request[$field] = $sector->name;
                    } else {
                        $request[$field] = '';
                    }
                    $field_name = 'Sector';
                } elseif ($field == 'product_classification_id') {
                    $class = ProductClassification::where('id', $project[$field])->select('name')->first();
                    if ($class) {
                        $project[$field] = $class->name;
                    } else {
                        $project[$field] = '';
                    }
                    $class = ProductClassification::where('id', $request[$field])->select('name')->first();
                    if ($class) {
                        $request[$field] = $class->name;
                    } else {
                        $request[$field] = '';
                    }
                    $field_name = 'Product Classification';
                } elseif ($field == 'certificate_number') {
                    $field_name = 'Certificate Number';
                } elseif ($field == 'status') {
                    $field_name = 'Status';
                } elseif ($field == 'remarks_1') {
                    $field_name = 'Remarks';
                } elseif ($field == 'date_received') {
                    $field_name = 'Date Received';
                } elseif ($field == 'kind_of_product') {
                    $kind_of_product = KindOfProduct::where('id', $project[$field])->select('name')->first();
                    if ($kind_of_product) {
                        $project[$field] = $kind_of_product->name;
                    } else {
                        $project[$field] = '';
                    }
                    $kind_of_product = KindOfProduct::where('id', $request[$field])->select('name')->first();
                    if ($kind_of_product) {
                        $request[$field] = $kind_of_product->name;
                    } else {
                        $request[$field] = '';
                    }
                    $field_name = 'Product Type';
                } elseif ($field == 'product') {
                    $field_name = 'Name of Product';
                } elseif ($field == 'product_ar') {
                    $field_name = 'Name of Product (In Arabic)';
                } elseif ($field == 'fund_size') {
                    $field_name = 'Product Size';
                } elseif ($field == 'fund_currency') {
                    $field_name = 'Product Currency';
                } elseif ($field == 'hours_for_review') {
                    $field_name = 'Hours for Review';
                } elseif ($field == 'hours_for_review_by_sam') {
                    $field_name = 'Hours for Review by SAM';
                } elseif ($field == 'estimated_calls') {
                    $field_name = 'Estimated Calls';
                } elseif ($field == 'call_timing') {
                    $field_name = 'Call timings (minutes)';
                } elseif ($field == 'language_1' || $field == 'language_2') {
                    $language = Language::where('id', $project[$field])->select('name')->first();
                    if ($language) {
                        $project[$field] = $language->name;
                    } else {
                        $project[$field] = '';
                    }
                    $language = Language::where('id', $request[$field])->select('name')->first();
                    if ($language) {
                        $request[$field] = $language->name;
                    } else {
                        $request[$field] = '';
                    }
                    $field_name = ($field == 'language_1') ? 'Language 1' : 'Language 2';
                } elseif ($field == 'employee_1' || $field == 'employee_2') {
                    $employee_project = Employee::where('id', $project[$field])->select('first_name', 'last_name')->first();
                    $employee_request = Employee::where('id', $request[$field])->select('first_name', 'last_name')->first();
                    if ($employee_project) {
                        $project[$field] = $employee_project->first_name . ' ' . $employee_project->last_name;
                    } else {
                        $project[$field] = '';
                    }
                    if ($employee_request) {
                        $request[$field] = $employee_request->first_name . ' ' . $employee_request->last_name;
                    } else {
                        $request[$field] = '';
                    }
                    $field_name = ($field == 'employee_1') ? 'Employee 1' : 'Employee 2';
                } elseif ($field == 'updated_by') {
                    $user_project = User::where('id', $project[$field])->select('name')->first();
                    $user_request = User::where('id', $request[$field])->select('name')->first();
                    $field_name = 'Updated By';
                    if ($user_project) {
                        $project[$field] = $user_project->name;
                    } else {
                        $project[$field] = '';
                    }
                    if ($user_request) {
                        $request[$field] = $user_request->name;
                    } else {
                        $request[$field] = '';
                    }
                } elseif ($field == 'certificate_2') {
                    $project[$field] = ProjectCertificate::where('certificate_number', $request['certificate_number'])
                        ->select('certificate_2')->first()->certificate_2;
                    $request[$field] = $certificate_2;
                    $field_name = 'Terminate Certificate';
                } elseif ($field == 'certificate_1') {
                    $project[$field] = ProjectCertificate::where('certificate_number', $request['certificate_number'])
                        ->select('certificate_1')->first()->certificate_1;
                    $request[$field] = $certificate_1;
                    $field_name = 'Certificate';
                }

                ProjectHistory::create([
                    'field' => $field_name,
                    'original_value' => $project[$field],
                    'changed_value' => $request[$field],
                    'project_id' => $id
                ]);
            }
        }

        if (!empty($request['scholars'])) {
            $original_scholars = ProjectScholar::where('project_id', $id)->select('scholar_id')->get()->toArray();
            $scholars = explode(',', $request['scholars']);
            $original_scholars_count = count($original_scholars);
            $scholars_count = count($scholars);
            if ($original_scholars_count == $scholars_count) {
                foreach ($original_scholars as $s => $scholar) {
                    if ($scholar['scholar_id'] != $scholars[$s]) {
                        $original = Scholar::where('id', $scholar['scholar_id'])->select('first_name', 'last_name')->first();
                        $changed = Scholar::where('id', $scholars[$s])->select('first_name', 'last_name')->first();
                        ProjectHistory::create([
                            'field' => 'Scholar ' . $s + 1,
                            'original_value' => $original->first_name . ' ' . $original->last_name,
                            'changed_value' => $changed->first_name . ' ' . $changed->last_name,
                            'project_id' => $id
                        ]);
                    }
                }
            } else {
                $length = $original_scholars_count > $scholars_count ? $original_scholars_count : $scholars_count;
                for ($i = 0; $i < $length; $i++) {
                    $original_present = isset($original_scholars[$i]);
                    $changed_present = isset($scholars[$i]);
                    if (($original_present && $changed_present) && ($original_scholars[$i]['scholar_id'] != $scholars[$i])) {
                        $original = Scholar::where('id', $original_scholars[$i]['scholar_id'])->select('first_name', 'last_name')->first();
                        $changed = Scholar::where('id', $scholars[$i])->select('first_name', 'last_name')->first();
                        ProjectHistory::create([
                            'field' => 'Scholar ' . $i + 1,
                            'original_value' => $original->first_name . ' ' . $original->last_name,
                            'changed_value' => $changed->first_name . ' ' . $changed->last_name,
                            'project_id' => $id
                        ]);
                    } else {
                        if ($original_present && !$changed_present) {
                            $original = Scholar::where('id', $original_scholars[$i]['scholar_id'])->select('first_name', 'last_name')->first();
                            ProjectHistory::create([
                                'field' => 'Scholar ' . $i + 1,
                                'original_value' => $original->first_name . ' ' . $original->last_name,
                                'changed_value' => '',
                                'project_id' => $id
                            ]);
                        } else if ($changed_present && !$original_present) {
                            $changed = Scholar::where('id', $scholars[$i])->select('first_name', 'last_name')->first();
                            ProjectHistory::create([
                                'field' => 'Scholar ' . $i + 1,
                                'original_value' => '',
                                'changed_value' => $changed->first_name . ' ' . $changed->last_name,
                                'project_id' => $id
                            ]);
                        }
                    }
                }
            }
        }

        $original_documents = ProjectDocument::where('project_id', $id)->where('type', 'regular')->pluck('document_id')->toArray();
        $original_documents_count = count($original_documents);
        if ($original_documents_count > 0) {
            $original_docs = implode(',', $original_documents);
            $original_docs_reverse = implode(',', array_reverse($original_documents));
        } else {
            $original_docs = $original_docs_reverse = '';
        }
        if (($original_docs != $request['documents']) && ($original_docs_reverse != $request['documents'])) {
            $docs = '';
            if ($original_documents_count > 0) {
                foreach ($original_documents as $document) {
                    if (!empty($docs)) {
                        $docs .= ', ';
                    }
                    $docs .= ProductDocument::where('id', $document)->select('name')->first()->name;
                }
            }
            $changed_docs = '';
            if (!empty($request['documents'])) {
                $changed = explode(',', $request['documents']);
                foreach ($changed as $item) {
                    if (!empty($changed_docs)) {
                        $changed_docs .= ', ';
                    }
                    $changed_docs .= ProductDocument::where('id', $item)->select('name')->first()->name;
                }
            }
            ProjectHistory::create([
                'field' => 'Product Documents',
                'original_value' => $docs,
                'changed_value' => $changed_docs,
                'project_id' => $id
            ]);
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
            Project::where('project_id', $id)->delete();
        }
    }

    public function excelExport(Request $request)
    {
        $fileName = 'projects.xlsx';
        $path = 'exports/' . $fileName;
        Excel::store(new ProjectsExport($request), $path);
        return response()->download(storage_path('app/' . $path), $fileName);
    }

    public function getProjectHistory($id, Request $request)
    {
        $history = ProjectHistory::where('project_id', $id)->select('field', 'original_value', 'changed_value', 'created_at');
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

    public function generateMMReport(Request $request)
    {
        if ($request->language == 'English') {
            $templateProcessor = new TemplateProcessor('New English MM SRB.docx');

            if ($request->quarter == 'Q1') {
                $start = $request->year . '-01-01';
                $end = $request->year . '-03-31';
            } elseif ($request->quarter == 'Q2') {
                $start = $request->year . '-04-01';
                $end = $request->year . '-06-30';
            } elseif ($request->quarter == 'Q3') {
                $start = $request->year . '-07-01';
                $end = $request->year . '-09-30';
            } elseif ($request->quarter == 'Q4') {
                $start = $request->year . '-10-01';
                $end = $request->year . '-12-31';
            } elseif ($request->quarter == 'First Six Months') {
                $start = $request->year . '-01-01';
                $end = $request->year . '-06-30';
            } elseif ($request->quarter == 'Last Six Months') {
                $start = $request->year . '-07-01';
                $end = $request->year . '-12-31';
            } else {
                $start = $request->year . '-01-01';
                $end = $request->year . '-12-31';
            }
            $start = Carbon::createFromFormat('Y-m-d', $start)->startOfDay();
            $end = Carbon::createFromFormat('Y-m-d', $end)->endOfDay();

            $company = Company::where('id', $request->company_id)->select('id', 'name', 'shariyah_company_id')->first();

            $projects = Project::selectRaw("project_id,
            AES_DECRYPT(`employee_1`, 's17') employee_1, AES_DECRYPT(`employee_2`, 's17') employee_2,
            AES_DECRYPT(`certificate_number`, 's17') certificate_number, AES_DECRYPT(`product`, 's17') product,
            AES_DECRYPT(`date_completed`, 's17') date_completed")
                ->where(DB::raw("AES_DECRYPT(company_client, 's17')"), $request->company_id)
                ->whereBetween('date_and_time', [$start, $end])
                ->get();

            $endorsed = $AONP = $AddDocs = $ReDocs = $OB = $other = [];
            $AONP_WAS = $ADD_WAS = $RE_WAS = 'was';
            if (count($projects) > 0) {
                $index = $obIndex = 0;
                foreach ($projects as $p => $project) {
                    $product_name = str_replace("&", "and", $project->product);

                    if (count($project->scholars) > 0) {
                        foreach ($project->scholars as $scholar) {
                            $endorsed[$index]['endorsed_name'] = $scholar->first_name . ' ' . $scholar->last_name;
                            $endorsed[$index]['endorsed_position'] = !empty($company->shariyah_company_id) ? $company->shariyahCompany->name . ' Member' : 'Member';
                            $endorsed[$index]['endorsed_at'] = 'Call';
                            $index++;
                        }
                    }
                    if ($project->employee1) {
                        $endorsed[$index]['endorsed_name'] = $project->employee1->first_name . ' ' . $project->employee1->last_name;
                        $endorsed[$index]['endorsed_position'] = !empty($company->shariyah_company_id) ? $company->shariyahCompany->name . ' Member' : 'Member';
                        $endorsed[$index]['endorsed_at'] = 'Present';
                        $index++;
                    }
                    if ($project->employee2) {
                        $endorsed[$index]['endorsed_name'] = $project->employee2->first_name . ' ' . $project->employee2->last_name;
                        $endorsed[$index]['endorsed_position'] = !empty($company->shariyah_company_id) ? $company->shariyahCompany->name . ' Member' : 'Member';
                        $endorsed[$index]['endorsed_at'] = 'Present';
                        $index++;
                    }

                    $history = $project->history()->where('field', 'Name of Product')->exists();
                    if ($history) {
                        $ReDocs[$p]['RE_CERT'] = $project->certificate_number;
                        $ReDocs[$p]['RE_NAME'] = $product_name;
                        $ReDocs[$p]['RE_DOCS'] = $project->documents()->where('type', 'regular')->get()->implode('name', ' | ');
                        $ReDocs[$p]['RE_DATE'] = Carbon::parse($project->date_completed)->format('Y-m-d');
                    }

                    if (!$history) {
                        $AONP[$p]['AONP_CERT'] = $project->certificate_number;
                        $AONP[$p]['AONP_NAME'] = $product_name;
                        $AONP[$p]['AONP_DOCS'] = $project->documents()->where('type', 'regular')->get()->implode('name', ' | ');
                        $AONP[$p]['AONP_DATE'] = Carbon::parse($project->date_completed)->format('Y-m-d');
                    }
                    if (!$history && (str_contains($product_name, 'Compliant Company Certificate') || str_contains($product_name, 'compliant company certificate'))) {
                        $AONP[$p]['AONP_CERT'] = $project->certificate_number;
                        $AONP[$p]['AONP_NAME'] = $product_name;
                        $AONP[$p]['AONP_DOCS'] = $project->documents()->where('type', 'regular')->get()->implode('name', ' | ');
                        $AONP[$p]['AONP_DATE'] = Carbon::parse($project->date_completed)->format('Y-m-d');
                    }

                    $add_documents = $project->documents()->whereIn('type', ['add', 'amend'])->whereBetween('projects_documents.created_at', [$start, $end])->get();
                    if (count($add_documents) > 0) {
                        $AddDocs[$p]['ADD_CERT'] = $project->certificate_number;
                        $AddDocs[$p]['ADD_NAME'] = $product_name;
                        $AddDocs[$p]['ADD_DOCS'] = $add_documents->implode('name', ' | ');
                        $AddDocs[$p]['ADD_DATE'] = Carbon::parse($project->date_completed)->format('Y-m-d');
                    }
                }

                $observations = $company->observations()->where('status', '!=', 1)->get();
                if (count($observations) > 0) {
                    foreach ($observations as $observation) {
                        $OB[$obIndex]['OB_YEAR'] = $observation->year;
                        $OB[$obIndex]['OB_FUNC'] = $observation->function;
                        $OB[$obIndex]['OB_DESC'] = $observation->description;
                        $OB[$obIndex]['OB_DET'] = $observation->observation_details;
                        $OB[$obIndex]['OB_RISK'] = $observation->risk;
                        $OB[$obIndex]['OB_REC'] = $observation->recommendation;
                        $OB[$obIndex]['OB_RES'] = $observation->management_response;
                        $OB[$obIndex]['OB_DATE'] = $observation->date_of_audit;
                        $obIndex++;
                    }
                }

                if (count($AONP) == 0) {
                    $AONP[0]['AONP_CERT'] = 'N/A';
                    $AONP[0]['AONP_NAME'] = 'N/A';
                    $AONP[0]['AONP_DOCS'] = 'N/A';
                    $AONP[0]['AONP_DATE'] = 'N/A';
                }
                if (count($AddDocs) == 0) {
                    $AddDocs[0]['ADD_CERT'] = 'N/A';
                    $AddDocs[0]['ADD_NAME'] = 'N/A';
                    $AddDocs[0]['ADD_DOCS'] = 'N/A';
                    $AddDocs[0]['ADD_DATE'] = 'N/A';
                }
                if (count($ReDocs) == 0) {
                    $ReDocs[0]['RE_CERT'] = 'N/A';
                    $ReDocs[0]['RE_NAME'] = 'N/A';
                    $ReDocs[0]['RE_DOCS'] = 'N/A';
                    $ReDocs[0]['RE_DATE'] = 'N/A';
                }
                if (count($OB) == 0) {
                    $OB[0]['OB_YEAR'] = 'N/A';
                    $OB[0]['OB_FUNC'] = 'N/A';
                    $OB[0]['OB_DESC'] = 'N/A';
                    $OB[0]['OB_DET'] = 'N/A';
                    $OB[0]['OB_RISK'] = 'N/A';
                    $OB[0]['OB_REC'] = 'N/A';
                    $OB[0]['OB_RES'] = 'N/A';
                    $OB[0]['OB_DATE'] = 'N/A';
                }

                if (count($AONP) > 1) {
                    $AONP_WAS = 'were';
                } else {
                    $AONP_WAS = 'was';
                }
                if (count($AddDocs) > 1) {
                    $ADD_WAS = 'were';
                } else {
                    $ADD_WAS = 'was';
                }
                if (count($ReDocs) > 1) {
                    $RE_WAS = 'were';
                } else {
                    $RE_WAS = 'was';
                }

                $endorsed = array_values(array_unique($endorsed, SORT_REGULAR));
                $AONP = array_values($AONP);
                $AddDocs = array_values($AddDocs);
                $ReDocs = array_values($ReDocs);
            }

            $otherProjects = Project::selectRaw("project_id,
            AES_DECRYPT(`certificate_number`, 's17') certificate_number,
            AES_DECRYPT(`product`, 's17') product")
                ->where(DB::raw("AES_DECRYPT(company_client, 's17')"), $request->company_id)
                ->whereNotBetween('date_and_time', [$start, $end])
                ->get();
            if (count($otherProjects) > 0) {
                foreach ($otherProjects as $p => $project) {
                    $other[$p]['OTHER_CERT'] = $project->certificate_number;
                    $other[$p]['OTHER_NAME'] = $project->product;
                }
            }
            if (count($other) == 0) {
                $other[0]['OTHER_CERT'] = 'N/A';
                $other[0]['OTHER_NAME'] = 'N/A';
            }

            $templateProcessor->setValues(['company_name' => $company->name, 'quarter' => $request->quarter,
                'year' => $request->year, 'shariyah_company' => !empty($company->shariyah_company_id) ? $company->shariyahCompany->name : '',
                'shariyah_company_short' => !empty($company->shariyah_company_id) ? $company->shariyahCompany->code : '',
                'AONP_WAS' => $AONP_WAS, 'ADD_WAS' => $ADD_WAS, 'RE_WAS' => $RE_WAS]);
            $fileName = $company->name . ' - MM Report.docx';
            $templateProcessor->cloneRowAndSetValues('endorsed_name', $endorsed);
            $templateProcessor->cloneRowAndSetValues('AONP_CERT', $AONP);
            $templateProcessor->cloneRowAndSetValues('ADD_CERT', $AddDocs);
            $templateProcessor->cloneRowAndSetValues('RE_CERT', $ReDocs);
            $templateProcessor->cloneRowAndSetValues('OB_YEAR', $OB);
            $templateProcessor->cloneRowAndSetValues('OTHER_CERT', $other);
            $templateProcessor->saveAs($fileName);
            return response()->download($fileName)->deleteFileAfterSend(true);
        }
    }

    /*public function mmReportArabic()
    {
        $month = now()->month;
        if ($month >= 1 && $month <= 3) {
            $quarter = 'الأول';
        } elseif ($month >= 4 && $month <= 6) {
            $quarter = 'الثاني';
        } elseif ($month >= 7 && $month <= 9) {
            $quarter = 'الثالث';
        } else {
            $quarter = 'الرابع';
        }
        $templateProcessor = new TemplateProcessor('New Arabic MM SRB.docx');
        $templateProcessor->setValue('company_name', 'ABC');
        $templateProcessor->setValue('quarter', $quarter);
        $templateProcessor->setValue('year', now()->year);
        $fileName = 'test.docx';
        $templateProcessor->saveAs($fileName);
        return response()->download($fileName)->deleteFileAfterSend(true);
    }*/
}
