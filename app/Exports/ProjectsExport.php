<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $projectsData = Project::selectRaw("project_id,
                                          AES_DECRYPT(client_code, 's17') client_code,
                                          AES_DECRYPT(`sector_id`, 's17') sector_id,
                                          AES_DECRYPT(`product_classification_id`, 's17') product_classification_id,
                                          AES_DECRYPT(company_client, 's17') company_client,
                                          AES_DECRYPT(`last_update`, 's17') last_update,
                                          AES_DECRYPT(`certificate_number`, 's17') certificate_number,
                                          AES_DECRYPT(`kind_of_product`, 's17') kind_of_product,
                                          AES_DECRYPT(`product`, 's17') product,
                                          AES_DECRYPT(`product_document`, 's17') product_document,
                                          AES_DECRYPT(`date_received`, 's17') date_received,
                                          AES_DECRYPT(`date_completed`, 's17') date_completed,
                                          AES_DECRYPT(`fund_size`, 's17') fund_size,
                                          AES_DECRYPT(`fund_currency`, 's17') fund_currency,
                                          AES_DECRYPT(`no_of_documents`, 's17') no_of_documents,
                                          AES_DECRYPT(`pages`, 's17') pages,
                                          AES_DECRYPT(`hours_for_review`, 's17') hours_for_review,
                                          AES_DECRYPT(`no_of_days`, 's17') no_of_days,
                                          AES_DECRYPT(`no_of_touchpoints`, 's17') no_of_touchpoints,
                                          AES_DECRYPT(`estimated_calls`, 's17') estimated_calls,
                                          AES_DECRYPT(`call_timing`, 's17') call_timing,
                                          AES_DECRYPT(`language_1`, 's17') language_1,
                                          AES_DECRYPT(`language_2`, 's17') language_2,
                                          AES_DECRYPT(`scholar_1`, 's17') scholar_1,
                                          AES_DECRYPT(`scholar_2`, 's17') scholar_2,
                                          AES_DECRYPT(`scholar_3`, 's17') scholar_3,
                                          AES_DECRYPT(`scholar_4`, 's17') scholar_4,
                                          AES_DECRYPT(`employee_1`, 's17') employee_1,
                                          AES_DECRYPT(`employee_2`, 's17') employee_2,
                                          AES_DECRYPT(`status`, 's17') status,
                                          AES_DECRYPT(certificate_status, 's17') certificate_status,
                                          AES_DECRYPT(`certificate_1`, 's17') certificate_1,
                                          AES_DECRYPT(`remarks_1`, 's17') remarks_1,
                                          AES_DECRYPT(`year`, 's17') year");

        if (isset($this->request->company_client)) {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(`company_client`, 's17')"), (int)$this->request->company_client);
        }
        if (isset($this->request->kind_of_product)) {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(kind_of_product, 's17')"), (int)$this->request->kind_of_product);
        }
        if (isset($this->request->product_classification_id)) {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(product_classification_id, 's17')"), (int)$this->request->product_classification_id);
        }
        if (isset($this->request->scholar_id)) {
            $scholar_id = (int)$this->request->scholar_id;
            $projectsData = $projectsData->where(function ($query) use ($scholar_id) {
                $query->where(DB::raw("AES_DECRYPT(scholar_1, 's17')"), $scholar_id)
                    ->orWhere(DB::raw("AES_DECRYPT(scholar_2, 's17')"), $scholar_id)
                    ->orWhere(DB::raw("AES_DECRYPT(scholar_3, 's17')"), $scholar_id)
                    ->orWhere(DB::raw("AES_DECRYPT(scholar_4, 's17')"), $scholar_id);
            });
        }
        if (isset($this->request->sector_id)) {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(sector_id, 's17')"), (int)$this->request->sector_id);
        }
        if (isset($this->request->year) && $this->request->year != 'All years') {
            $projectsData = $projectsData->where(DB::raw("AES_DECRYPT(year, 's17')"), (int)$this->request->year);
        }
        if (isset($this->request->year_range_1) && isset($this->request->year_range_2)) {
            $projectsData = $projectsData->whereBetween(DB::raw("AES_DECRYPT(year, 's17')"), [$this->request->year_range_1, $this->request->year_range_2]);
        }

        $projects = $projectsData->get();

        foreach ($projects as $project) {
            $project->sector_name = !empty($project->sector_id) ? $project->sector->name : '';
            $project->product_classification_name = !empty($project->product_classification_id) ? $project->productClassification->name : '';
            $project->company_name = !empty($project->company_client) ? $project->company->name : '';
            $project->kind_of_product = is_numeric($project->kind_of_product) ? $project->kindOfProd->name : $project->kind_of_product;
            $project->language_1 = !empty($project->language_1) && $project->language1 ? $project->language1->name : '';
            $project->language_2 = !empty($project->language_2) && $project->language2 ? $project->language2->name : '';
            $project->scholar_1 = !empty($project->scholar_1) && $project->scholar1 ? $project->scholar1->first_name . ' ' . $project->scholar1->last_name : '';
            $project->scholar_2 = !empty($project->scholar_2) && $project->scholar2 ? $project->scholar2->first_name . ' ' . $project->scholar2->last_name : '';
            $project->scholar_3 = !empty($project->scholar_3) && $project->scholar3 ? $project->scholar3->first_name . ' ' . $project->scholar3->last_name : '';
            $project->scholar_4 = !empty($project->scholar_4) && $project->scholar4 ? $project->scholar4->first_name . ' ' . $project->scholar4->last_name : '';
            $project->employee_1 = !empty($project->employee_1) && $project->employee1 ? $project->employee1->first_name . ' ' . $project->employee1->last_name : '';
            $project->employee_2 = !empty($project->employee_2) && $project->employee2 ? $project->employee2->first_name . ' ' . $project->employee2->last_name : '';
            $project->certificate_1 = !empty($project->certificate_1) ? 'Yes' : 'No';
        }

        return $projects;
    }

    public function headings(): array
    {
        return ['Project ID', 'Client Code', 'Sector', 'Product Classification', 'Client Name', "Last Shari'a Audit",
            'Certificate Number', 'Kind of Product', 'Product', 'Product Document', 'Date Received', 'Date Completed',
            'Fund Size', 'Fund Currency', 'No of Documents', 'Pages', 'Hours for Review', 'No of Days', 'No of Touch Points',
            'Estimated Calls', 'Call Timing', 'Language 1', 'Language 2', 'Scholar 1', 'Scholar 2', 'Scholar 3', 'Scholar 4',
            'Employee 1', 'Employee 2', 'Status', 'Certificate Status', 'Attachment', 'Remarks'];
    }

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => '0070C0',
                ],
            ],
        ];

        $sheet->getStyle('A1:AG1')->applyFromArray($styleArray);
    }

    public function shouldAutoSize(): bool
    {
        return true;
    }

    public function map($row): array
    {
        return [
            $row->project_id,
            $row->client_code,
            $row->sector_name,
            $row->product_classification_name,
            $row->company_name,
            $row->last_update,
            $row->certificate_number,
            $row->kind_of_product,
            $row->product,
            $row->product_document,
            $row->date_received,
            $row->date_completed,
            $row->fund_size,
            $row->fund_currency,
            $row->no_of_documents,
            $row->pages,
            $row->hours_for_review,
            $row->no_of_days,
            $row->no_of_touchpoints,
            $row->estimated_calls,
            $row->call_timing,
            $row->language_1,
            $row->language_2,
            $row->scholar_1,
            $row->scholar_2,
            $row->scholar_3,
            $row->scholar_4,
            $row->employee_1,
            $row->employee_2,
            $row->status,
            $row->certificate_status,
            $row->certificate_1,
            $row->remarks_1
        ];
    }
}
