<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDocument extends Model
{
    use HasFactory;

    protected $table = 'projects_documents';

    protected $fillable = ['project_id', 'document_id', 'type', 'created_at'];
}
