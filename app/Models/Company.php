<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = ['name', 'name_ar', 'short_name', 'description', 'picture', 'status', 'created_by',
        'updated_by', 'shariyah_company_id'];

    public $timestamps = true;

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function observations()
    {
        return $this->hasMany(Observation::class);
    }

    public function shariyahCompany()
    {
        return $this->belongsTo(ShariyahCompany::class);
    }
}
