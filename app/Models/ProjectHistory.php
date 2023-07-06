<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectHistory extends Model
{
    use HasFactory;

    protected $table = 'projects_history';

    protected $fillable = ['field', 'original_value', 'changed_value', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
