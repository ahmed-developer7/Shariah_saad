<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;

class ObservationsController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['name' => "Observations"]
        ];
        return view('content.observations', ['breadcrumbs' => $breadcrumbs]);
    }

    public function addObservation()
    {
        $breadcrumbs = [
            ['link' => "admin/observations", 'name' => "Observations"], ['name' => "Add Observation"]
        ];

        $observation = [];

        return view('content.add-observation', ['observation' => $observation, 'breadcrumbs' => $breadcrumbs]);
    }

    public function editObservation($id)
    {
        $breadcrumbs = [
            ['link' => "admin/observations", 'name' => "Observations"], ['name' => "Edit Observation"]
        ];

        $observation = Observation::find($id);
        $observation->load(['company' => function ($query) {
            $query->select('id', 'name');
        }]);
        $observation->load(['project' => function ($query) {
            $query->selectRaw("project_id, AES_DECRYPT(`product`, 's17') product");
        }]);

        return view('content.add-observation', ['observation' => $observation, 'breadcrumbs' => $breadcrumbs]);
    }

    public function observationHistory($id)
    {
        $breadcrumbs = [
            ['link' => "admin/observations", 'name' => "Observations"], ['name' => 'Observation History']
        ];

        return view('content.observation-history', compact('breadcrumbs', 'id'));
    }
}
