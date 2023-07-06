<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\ProjectScholar;
use Illuminate\Console\Command;

class AddScholars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shariyah:add-customers';

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
        $projects = Project::selectRaw("project_id,
        AES_DECRYPT(`scholar_1`, 's17') scholar_1,
        AES_DECRYPT(`scholar_2`, 's17') scholar_2,
        AES_DECRYPT(`scholar_3`, 's17') scholar_3,
        AES_DECRYPT(`scholar_4`, 's17') scholar_4")->get();

        foreach ($projects as $project) {
            if (!empty($project->scholar_1)) {
                ProjectScholar::create([
                    'project_id' => $project->project_id,
                    'scholar_id' => $project->scholar_1
                ]);
            }
            if (!empty($project->scholar_2)) {
                ProjectScholar::create([
                    'project_id' => $project->project_id,
                    'scholar_id' => $project->scholar_2
                ]);
            }
            if (!empty($project->scholar_3)) {
                ProjectScholar::create([
                    'project_id' => $project->project_id,
                    'scholar_id' => $project->scholar_3
                ]);
            }
            if (!empty($project->scholar_4)) {
                ProjectScholar::create([
                    'project_id' => $project->project_id,
                    'scholar_id' => $project->scholar_4
                ]);
            }
        }
    }
}
