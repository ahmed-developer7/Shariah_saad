<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectScholar extends Model
{
    use HasFactory;

    protected $table = 'project_scholar';

    protected $fillable = ['project_id', 'scholar_id'];

    public $timestamps = false;
}
