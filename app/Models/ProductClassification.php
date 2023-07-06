<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductClassification extends Model
{
    use HasFactory;

    protected $table = 'product_classification';

    protected $fillable = ['name', 'sector_id', 'status', 'created_by', 'updated_by'];

    public $timestamps = true;

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function types()
    {
        return $this->belongsToMany(KindOfProduct::class, 'type_classification');
    }
}
