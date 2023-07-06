<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShariyahCompany extends Model
{
    use HasFactory;

    protected $table = 'shariyah_companies';

    protected $fillable = ['name', 'name_ar'];

    public function company()
    {
        return $this->hasOne(Company::class);
    }
}
