<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholar extends Model
{
    use HasFactory;

    protected $table = 'scholars';

    protected $fillable = ['first_name', 'last_name', 'picture', 'status', 'created_by',
        'updated_by', 'email', 'first_name_ar', 'last_name_ar', 'signature'];

    public $timestamps = true;

    /**
     * The attributes that should always be attached
     *
     * @var array
     */
    protected $appends = [
        'name'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function projectsScholars()
    {
        return $this->belongsToMany(Project::class, 'project_scholar');
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
