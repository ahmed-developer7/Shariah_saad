<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationHistory extends Model
{
    use HasFactory;

    protected $table = 'observations_history';

    protected $fillable = ['field', 'original_value', 'changed_value', 'observation_id'];

    public function observation()
    {
        return $this->belongsTo(Observation::class);
    }
}
