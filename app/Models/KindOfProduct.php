<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KindOfProduct extends Model
{
    use HasFactory;

    protected $table = 'kind_of_products';

    protected $fillable = ['name', 'status', 'created_by', 'updated_by'];

    public $timestamps = true;

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function classifications()
    {
        return $this->belongsToMany(ProductClassification::class, 'type_classification','type_id', 'classification_id');
    }

    public function documents()
    {
        return $this->belongsToMany(ProductDocument::class, 'documents_types');
    }
}
