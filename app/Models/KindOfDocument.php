<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KindOfDocument extends Model
{
    use HasFactory;

    protected $table = 'kind_of_documents';

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
