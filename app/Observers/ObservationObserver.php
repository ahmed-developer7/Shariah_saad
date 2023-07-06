<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\Observation;
use App\Models\ObservationHistory;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ObservationObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Observation "created" event.
     *
     * @param \App\Models\Observation $observation
     * @return void
     */
    public function created(Observation $observation)
    {
        //
    }

    /**
     * Handle the Observation "updated" event.
     *
     * @param \App\Models\Observation $observation
     * @return void
     */
    public function updated(Observation $observation)
    {
        if ($observation->wasChanged()) {
            $original = $observation->getOriginal();
            foreach ($observation->getChanges() as $key => $value) {
                if ($key) {
                    if ($key != 'updated_at' && $key != 'status') {
                        $field = $original_value = $changed_value = null;
                        if ($key == 'project_id') {
                            $field = 'Product';
                            if (!empty($original[$key])) {
                                $original_value = Project::selectRaw("AES_DECRYPT(`product`, 's17') product")
                                    ->where('project_id', $original[$key])->first()->product;
                            }
                            if (!empty($value)) {
                                $changed_value = Project::selectRaw("AES_DECRYPT(`product`, 's17') product")
                                    ->where('project_id', $value)->first()->product;
                            }
                        } elseif ($key == 'observation_details') {
                            $field = 'Observation Details';
                        } elseif ($key == 'management_response') {
                            $field = 'Management Response';
                        } elseif ($key == 'date_of_audit') {
                            $field = 'Date of Audit';
                        }
                        ObservationHistory::create([
                            'field' => $field ?? ucfirst($key),
                            'original_value' => $original_value ?? $original[$key],
                            'changed_value' => $changed_value ?? $value,
                            'observation_id' => $observation->id
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Handle the Observation "deleted" event.
     *
     * @param \App\Models\Observation $observation
     * @return void
     */
    public function deleted(Observation $observation)
    {
        //
    }

    /**
     * Handle the Observation "restored" event.
     *
     * @param \App\Models\Observation $observation
     * @return void
     */
    public function restored(Observation $observation)
    {
        //
    }

    /**
     * Handle the Observation "force deleted" event.
     *
     * @param \App\Models\Observation $observation
     * @return void
     */
    public function forceDeleted(Observation $observation)
    {
        //
    }
}
