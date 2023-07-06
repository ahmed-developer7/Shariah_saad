<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';

    protected $fillable = ['name', 'status', 'created_by', 'updated_by'];

    public $timestamps = true;

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
