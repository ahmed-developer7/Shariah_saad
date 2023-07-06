<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guideline extends Model
{
    use HasFactory;

    protected $table = 'guidelines';

    protected $fillable = ['name', 'heading', 'link'];

    public function project()
    {
        return $this->hasOne('App\Models\Project');
    }
}
