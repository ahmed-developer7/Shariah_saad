<?php

namespace App\Http\Controllers;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Mail\SendCertificateMail;
use App\Mail\SuccessCertificateMail;
use App\Models\Project;
use App\Models\ProjectCertificate;
use App\Models\Scholar;
use App\Models\Signature;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use HelloSign\Client;
use Office365\Runtime\Auth\UserCredentials;
use Office365\SharePoint\ClientContext;
use Office365\SharePoint\FileCreationInformation;
use Illuminate\Support\Facades\Mail;

class ProjectsController extends Controller
{
    public function index($id = null)
    {
        $breadcrumbs = [
            ['name' => "Certification"]
        ];
        return view('content.projects', ['breadcrumbs' => $breadcrumbs, 'id' => $id, 'user_id' => Auth::user()->id]);
    }

    public function addProject()
    {
        $breadcrumbs = [
            ['link' => "admin/projects", 'name' => "Certification"], ['name' => "Add Project"]
        ];
        $project = [];
        return view('content.add-project', ['project' => $project, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editProject($id, $duplicate = false)
    {
        if ($duplicate) {
            $name = 'Duplicate Project';
        } else {
            $name = 'Edit Project';
        }
        $breadcrumbs = [
            ['link' => "admin/projects", 'name' => "Certification"], ['name' => $name]
        ];
        $project = Project::where('project_id', $id)->selectRaw("project_id,
                                          AES_DECRYPT(`sector_id`, 's17') sector_id,
                                          AES_DECRYPT(`product_classification_id`, 's17') product_classification_id,
                                          AES_DECRYPT(`company_client`, 's17') company_client,
                                          AES_DECRYPT(`client_code`, 's17') client_code,
                                          AES_DECRYPT(`certificate_number`, 's17') certificate_number,
                                          AES_DECRYPT(`status`, 's17') status,
                                          AES_DECRYPT(`certificate_status`, 's17') certificate_status,
                                          AES_DECRYPT(`remarks_1`, 's17') remarks_1,
                                          AES_DECRYPT(`last_update`, 's17') last_update,
                                          AES_DECRYPT(`date_received`, 's17') date_received,
                                          AES_DECRYPT(`date_completed`, 's17') date_completed,
                                          AES_DECRYPT(`kind_of_product`, 's17') kind_of_product,
                                          AES_DECRYPT(`product`, 's17') product,
                                          AES_DECRYPT(`fund_size`, 's17') fund_size,
                                          AES_DECRYPT(`fund_currency`, 's17') fund_currency,
                                          AES_DECRYPT(`no_of_documents`, 's17') no_of_documents,
                                          AES_DECRYPT(`pages`, 's17') pages,
                                          AES_DECRYPT(`hours_for_review`, 's17') hours_for_review,
                                          AES_DECRYPT(`hours_for_review_by_sam`, 's17') hours_for_review_by_sam,
                                          AES_DECRYPT(`no_of_days`, 's17') no_of_days,
                                          AES_DECRYPT(`no_of_touchpoints`, 's17') no_of_touchpoints,
                                          AES_DECRYPT(`estimated_calls`, 's17') estimated_calls,
                                          AES_DECRYPT(`call_timing`, 's17') call_timing,
                                          AES_DECRYPT(`language_1`, 's17') language_1,
                                          AES_DECRYPT(`language_2`, 's17') language_2,
                                          AES_DECRYPT(`employee_1`, 's17') employee_1,
                                          AES_DECRYPT(`employee_2`, 's17') employee_2,
                                          product_ar, template, guideline_id")->first();

        $project->language_1 = !empty($project->language_1) ? (int)$project->language_1 : $project->language_1;
        $project->language_2 = !empty($project->language_2) ? (int)$project->language_2 : $project->language_2;
        $project->employee_1 = !empty($project->employee_1) ? (int)$project->employee_1 : $project->employee_1;
        $project->employee_2 = !empty($project->employee_2) ? (int)$project->employee_2 : $project->employee_2;
        $project->kind_of_product = is_numeric($project->kind_of_product) ? (int)$project->kind_of_product : $project->kind_of_product;
        $project->sector_id = !empty($project->sector_id) ? (int)$project->sector_id : $project->sector_id;
        $project->product_classification_id = !empty($project->product_classification_id) ? (int)$project->product_classification_id : $project->product_classification_id;
        $project->company_client = !empty($project->company_client) ? (int)$project->company_client : $project->company_client;
        $project->load(['scholars' => function ($query) {
            $query->select('id', 'first_name', 'last_name');
        }]);
        $project->load(['documents' => function ($query) {
            $query->where('type', 'regular');
        }]);
        $project->load(['guideline' => function ($query) {
            $query->select('id', 'name');
        }]);

        return view('content.add-project', ['project' => $project, 'breadcrumbs' => $breadcrumbs, 'duplicate' => $duplicate]);
    }

    public function excelExport()
    {
        $breadcrumbs = [
            ['name' => "Excel Export"]
        ];
        return view('content.excel-export', ['breadcrumbs' => $breadcrumbs, 'id' => null, 'user_id' => Auth::user()->id]);
    }

    public function searchCertificate()
    {
        return view('content.search-certificate');
    }

    public function postCertificate(Request $request)
    {
        if (!empty($request) && isset($request->search)) {
            $project = Project::selectRaw("project_id,
                AES_DECRYPT(company_client, 's17') company_client,
                AES_DECRYPT(certificate_status, 's17') certificate_status,
                AES_DECRYPT(`certificate_number`, 's17') certificate_number,
                AES_DECRYPT(`remarks_1`, 's17') remarks_1,
                AES_DECRYPT(`last_update`, 's17' ) last_update,
                AES_DECRYPT(`status`, 's17' ) status")
                ->where(DB::raw("AES_DECRYPT(certificate_number, 's17')"), 'like', $request->search . '%')
                ->first();

            if ($project) {
                $project->certificates = ProjectCertificate::getCertificateByClientName($project->certificate_number);

                if (!empty($project->documents)) {
                    $project->documents = $project->documents()->where('type', 'regular')->get()->implode('name', ' | ');
                }

                $subject = $subject_value = $status = $status_value = $letter = $letter_text = $letter_value = $certificate_text = '';
                if (isset($project->company)) {
                    if ($project->company->status == 2 || $project->certificate_status == 'Terminated') {
                        $subject = 'Company Short Code';
                        $subject_value = $project->company->short_name;
                        if ($project->status != 'in-active') {
                            $status = "Last Shari'a Audit";
                            $status_value = $project->last_update;
                        } else {
                            $status = 'Current Status';
                            $status_value = 'Terminated';
                        }
                        $letter = 'Terminate Letter';
                        if (!empty($project->company->picture)) {
                            $letter_text = 'Download Termination Letter';
                            $letter_value = "/uploads/" . $project->company->picture;
                        } else {
                            $letter_text = 'No Termination Letter';
                        }
                    } elseif ($project->company->status == 1) {
                        $subject = 'Current Status';
                        if ($project->status == 'active') {
                            $letter = 'Sharia Opinion';
                            if (!empty($project->certificates->certificate_1) && $project->certificates->certificate_1 != 'n/a') {
                                $letter_text = 'View Document';
                                if (str_contains($project->certificates->certificate_1, '.')) {
                                    if (file_exists(public_path('uploads/') . $project->certificates->certificate_1)) {
                                        $letter_value = "/uploads/" . $project->certificates->certificate_1;
                                    }
                                }
                            } else {
                                $cert_num = explode('-', $project->certificate_number);
                                $num = $cert_num[0] . '-' . $cert_num[1] . '-' . $cert_num[2] . '-' . $cert_num[3]
                                    . '-' . $cert_num[4] . '-' . $cert_num[5];
                                if (file_exists(public_path('uploads/') . $num . '.pdf')) {
                                    $letter_text = 'View Document';
                                    $letter_value = "/uploads/" . $num . '.pdf';
                                } else {
                                    $letter_text = 'This is an internal document (not a public offering document), hence no certificate is issued.';
                                }
                            }
                        } else {
                            $letter = 'Terminate Letter';
                            if (!empty($project->certificates->certificate_2)) {
                                $letter_text = 'Download Termination';
                                $letter_value = "/uploads/" . $project->certificates->certificate_2;
                            } else {
                                $letter_text = 'No Termination';
                            }
                        }
                        if ($project->certificate_status == 'termination') {
                            $show_termination = false;
                            $certificate_text = "Serving notice of termination";
                        } elseif ($project->certificate_status == 'Terminated') {
                            $show_termination = false;
                            $certificate_text = 'Terminated';
                        } else {
                            $show_termination = true;
                            $certificate_text = ucfirst($project->status);
                        }
                        if ($show_termination) {
                            $status = "Last Shari'a Audit";
                            $status_value = $project->last_update;
                        }
                        $subject_value = $certificate_text;
                    }
                }

                return view('content.post-search-certificate', compact('project', 'subject', 'subject_value',
                    'status', 'status_value', 'letter', 'letter_text', 'letter_value', 'certificate_text'));
            }
        }
    }

    public function sendCertificate($id, $number, $send = null, $download = false, $all = false)
    {
        if ($download && $download != 'false') {
            $certificate = ProjectCertificate::where('certificate_number', $number)->select('certificate_1')->first();
            if ($certificate && str_contains($certificate->certificate_1, '.')) {
                $file = public_path('uploads/') . $certificate->certificate_1;
                if (file_exists($file)) {
                    return \Response::download($file);
                }
            }
            $cert_num = explode('-', $number);
            $num = $cert_num[0] . '-' . $cert_num[1] . '-' . $cert_num[2] . '-' . $cert_num[3]
                . '-' . $cert_num[4] . '-' . $cert_num[5];
            $file = public_path('uploads/') . $num . '.pdf';
            if (file_exists($file)) {
                return \Response::download($file);
            }
        }

        if ($id) {
            $project = Project::selectRaw("project_id, AES_DECRYPT(`certificate_number`, 's17') certificate_number,
            AES_DECRYPT(`company_client`, 's17') company_client, AES_DECRYPT(`product`, 's17') product,
            AES_DECRYPT(`date_completed`, 's17') date_completed, AES_DECRYPT(`language_1`, 's17') language_1,
            AES_DECRYPT(`language_2`, 's17') language_2, date_and_time, product_ar, guideline_id, template")
                ->where('project_id', $id)
                ->first();

            if ($project) {
                $data['project'] = $project;

                $due = strtotime($data['project']->date_and_time);
                if ($due != -62169984000) {
                    $data['date'] = Hijri::Date('l، j F، Y', Carbon::parse($data['project']->date_and_time));
                } else {
                    $data['date'] = '';
                }

                $cert_number = explode('-', $project->certificate_number);
                $data['number'] = $cert_number[0] . '-' . $cert_number[1] . '-' . $cert_number[2] . '-' . $cert_number[3]
                    . '-' . $cert_number[4] . '-' . $cert_number[5];

                $data['docs'] = $project->documents()->orderByPivot('created_at', 'asc')->get()
                    ->groupBy(function ($item) {
                        return $item->pivot->created_at->format('Y-m-d');
                    });

                $data['languages'] = $data['languages_ar'] = '';
                if (!empty($data['project']->language_1)) {
                    $data['languages'] = $data['project']->language1->name;
                    if ($data['languages'] == 'English') {
                        $data['languages_ar'] = 'الإنجليزية';
                    } else {
                        $data['languages_ar'] = 'العربية';
                    }
                }
                if (!empty($data['project']->language_2)) {
                    $data['languages'] .= ' and ' . $data['project']->language2->name;
                    if ($data['project']->language2->name == 'English') {
                        $data['languages_ar'] .= ' و ' . 'الإنجليزية';
                    } else {
                        $data['languages_ar'] .= ' و ' . 'العربية';
                    }
                }

                $data['all'] = $all;

                if ($data['project']->template == 'al_marjea_template') {
                    $html = view('content.certificate-template-marjea', compact('data'))->render();
                } else {
                    $html = view('content.certificate-template', compact('data'))->render();
                }

                $pdf = LaravelMpdf::loadHTML($html, [
                    'title' => 'Certificate',
                    'format' => [203.2, 355.6],
                    'orientation' => 'L'
                ]);

                if ($download && $download != 'false') {
                    return $pdf->download($data['number'] . '.pdf');
                }

                $file = public_path('uploads/') . $data['number'] . '.pdf';

                $pdf->save($file);

                $signatures = Signature::where('project_id', $id)->where('certificate_number', $data['number'])->count();
                if ($signatures == count($data['project']->scholars)) {
                    Signature::where('project_id', $id)->where('certificate_number', $data['number'])->delete();
                }

                if ($send && $send != 'null') {
                    $flag = false;
                    if (count($data['project']->scholars) > 0) {
                        $title = $data['project']->product . ' - ' . $data['project']->company->name;
                        foreach ($data['project']->scholars as $scholar) {
                            if (!empty($scholar->email) && (empty($scholar->picture) || $all)) {
                                $link = env('APP_URL_SITE') . '/signature-request/' . $id . '/' . $data['number'] . '/' . $scholar->id;
                                Mail::to($scholar->email)->send(new SendCertificateMail($link, $title, $file));
                                $flag = true;
                            }
                        }
                    }

                    if ($flag) {
                        $project->date_completed = DB::raw("AES_ENCRYPT('" . Carbon::now()->format('Y-m-d') . "', 's17')");
                        $project->update();
                        return redirect('admin/projects')->with(['message' => 'Certificate sent']);
                    } else {
                        return redirect('admin/projects')->with(['error' => 'Certificate not sent. Check Scholar(s) email']);
                    }
                }
            }
        }
    }

    public function helloSignCallback(Request $request)
    {
        if (!empty($request) && isset($request['json'])) {
            $data = json_decode($request['json'], true);
            if ($data['event']['event_type'] == 'signature_request_signed') {
                $certificate_number = $data['signature_request']['metadata']['certificate_number'];
                $signature_request_id = $data['signature_request']['signature_request_id'];
                $certificate = ProjectCertificate::where('certificate_number', $certificate_number)->first();
                if ($certificate) {
                    $certificate->certificate_1 = $signature_request_id;
                    $certificate->update();
                } else {
                    ProjectCertificate::create(
                        [
                            'certificate_number' => $certificate_number,
                            'certificate_1' => $signature_request_id,
                            'created_by' => 2
                        ]
                    );
                }
                sleep(5);
                $client = new Client(env('HELLOSIGN_API_KEY'));
                $client->getFiles($signature_request_id, $certificate_number . '.pdf', 'pdf');
                $credentials = new UserCredentials(env('SP_USERNAME'), env('SP_PASSWORD'));
                $ctx = (new ClientContext(env('SP_URL')))->withCredentials($credentials);
                $filePath = public_path($certificate_number . '.pdf');
                $fileUri = env('SP_URI') . $certificate_number . '.pdf';
                $fileCreationInformation = new FileCreationInformation();
                $fileCreationInformation->Content = file_get_contents($filePath);
                $fileCreationInformation->Url = basename($filePath);
                $ctx->getWeb()
                    ->getFolderByServerRelativeUrl(dirname($fileUri))
                    ->getFiles()
                    ->add($fileCreationInformation)
                    ->executeQuery();
                unlink($filePath);
            }
        }
        return response()->json('Hello API Event Received.');
    }

    public function projectHistory($id)
    {
        if (Auth()->user()->usertype != 'Super Admin') {
            abort(403);
        }

        $breadcrumbs = [
            ['link' => "admin/projects", 'name' => "Certification"], ['name' => 'Project History']
        ];

        return view('content.project-history', compact('breadcrumbs', 'id'));
    }

    public function mmReport()
    {
        $breadcrumbs = [
            ['name' => 'MM Reports']
        ];

        return view('content.mm-report', compact('breadcrumbs'));
    }

    public function signatureRequest($project_id, $certificate_number, $scholar_id)
    {
        if (!empty($project_id) && !empty($certificate_number) && !empty($scholar_id)) {
            $scholar = Scholar::where('id', $scholar_id)->select('signature')->first();
            return view('content.signature-request', compact('project_id', 'certificate_number', 'scholar_id', 'scholar'));
        }
    }

    public function uploadSignature(Request $request)
    {
        if ((isset($request->signed) || isset($request->old_signature)) && !empty($request->project_id) && !empty($request->certificate_number) && !empty($request->scholar_id)) {
            if (isset($request->signed)) {
                $image_parts = explode(";base64,", $request->signed);
                $name = uniqid() . '.' . explode("image/", $image_parts[0])[1];
                $file = public_path('uploads/') . $name;
                file_put_contents($file, base64_decode($image_parts[1]));
            }
            $signature = Signature::where('project_id', $request->project_id)->where('certificate_number', $request->certificate_number)
                ->where('scholar_id', $request->scholar_id)->exists();
            if ($signature) {
                Signature::where('project_id', $request->project_id)->where('certificate_number', $request->certificate_number)
                    ->where('scholar_id', $request->scholar_id)->delete();
            }
            if (!isset($file)) {
                $file = explode('/', $request->old_signature);
                $file = public_path('uploads/') . $file[2];
            }
            Signature::create([
                'project_id' => $request->project_id,
                'certificate_number' => $request->certificate_number,
                'scholar_id' => $request->scholar_id,
                'file' => $file
            ]);
            $scholar = Scholar::where('id', $request->scholar_id)->first();
            if (isset($request->signed)) {
                $scholar->signature = '/uploads/' . $name;
                $scholar->update();
            }

            $this->sendCertificate($request->project_id, $request->certificate_number);

            $project = Project::selectRaw("project_id, AES_DECRYPT(`certificate_number`, 's17') certificate_number,
            AES_DECRYPT(`company_client`, 's17') company_client, AES_DECRYPT(`product`, 's17') product")
                ->where('project_id', $request->project_id)->first();
            $title = $project->product . ' - ' . $project->company->name;
            $link = env('APP_URL_SITE') . '/uploads/' . $request->certificate_number . '.pdf';
            $file = public_path('uploads/') . $request->certificate_number . '.pdf';
            Mail::to($scholar->email)->send(new SuccessCertificateMail($link, $title, $file));

            return back()->with('success', 'You have successfully signed the certificate');
        } else {
            return back()->with('error', 'Signature Request Failed');
        }
    }
}
