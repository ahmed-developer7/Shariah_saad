<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $table = 'observations';

    protected $fillable = ['year', 'function', 'description', 'observation_details', 'risk', 'recommendation',
        'management_response', 'date_of_audit', 'status', 'company_id', 'project_id', 'reason'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function history()
    {
        return $this->hasMany(ObservationHistory::class);
    }
}
