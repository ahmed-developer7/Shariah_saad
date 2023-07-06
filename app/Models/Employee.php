<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = ['first_name', 'last_name', 'short_name', 'picture', 'description', 'status', 'created_by',
        'updated_by', 'first_name_ar', 'last_name_ar'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
