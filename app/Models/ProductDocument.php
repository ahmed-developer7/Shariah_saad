<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDocument extends Model
{
    use HasFactory;

    protected $table = 'product_documents';

    protected $fillable = ['name', 'name_ar', 'status', 'pages'];

    public function types()
    {
        return $this->belongsToMany(KindOfProduct::class, 'documents_types','document_id', 'type_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'projects_documents', 'project_id', 'document_id');
    }
}
