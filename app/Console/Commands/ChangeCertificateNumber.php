<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ChangeCertificateNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shariyah:change-certificate-number';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $project = Project::selectRaw("project_id, AES_DECRYPT(`certificate_number`, 's17') certificate_number")
            ->where('project_id', 18659)->first();

        $data = [
            'certificate_number' => $this->encrypt('IMP-3408-01-01-06-23')
        ];

        $project->update($data);
    }

    function encrypt($data)
    {
        return DB::raw("AES_ENCRYPT('" . $data . "', 's17')");
    }
}
