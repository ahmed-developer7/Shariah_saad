<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = ['sector_id', 'product_classification_id', 'company_client', 'client_code', 'certificate_number',
        'status', 'certificate_status', 'remarks_1', 'last_update', 'date_received', 'date_completed', 'kind_of_product',
        'product', 'fund_size', 'fund_currency', 'no_of_documents', 'pages', 'hours_for_review',
        'no_of_days', 'no_of_touchpoints', 'estimated_calls', 'call_timing', 'language_1', 'language_2',
        'employee_1', 'employee_2', 'x_xs','y_xs', 'currency_table', 'updated_by', 'employee_3', 'employee_4',
        'date_and_time', 'year', 'product_ar', 'hours_for_review_by_sam', 'template', 'guideline_id'];

    public $timestamps = false;

    protected $primaryKey = 'project_id';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_client');
    }

    public function scholar1()
    {
        return $this->belongsTo(Scholar::class, 'scholar_1');
    }

    public function scholar2()
    {
        return $this->belongsTo(Scholar::class, 'scholar_2');
    }

    public function scholar3()
    {
        return $this->belongsTo(Scholar::class, 'scholar_3');
    }

    public function scholar4()
    {
        return $this->belongsTo(Scholar::class, 'scholar_4');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function productClassification()
    {
        return $this->belongsTo(ProductClassification::class, 'product_classification_id');
    }

    public function kindOfDocument()
    {
        return $this->belongsTo(KindOfDocument::class, 'kind_of_doc');
    }

    public function kindOfProd()
    {
        return $this->belongsTo(KindOfProduct::class, 'kind_of_product');
    }

    public function language1()
    {
        return $this->belongsTo(Language::class, 'language_1');
    }

    public function language2()
    {
        return $this->belongsTo(Language::class, 'language_2');
    }

    public function employee1()
    {
        return $this->belongsTo(Employee::class, 'employee_1');
    }

    public function employee2()
    {
        return $this->belongsTo(Employee::class, 'employee_2');
    }

    public function scholars()
    {
        return $this->belongsToMany(Scholar::class, 'project_scholar', 'project_id');
    }

    public function documents()
    {
        return $this->belongsToMany(ProductDocument::class, 'projects_documents', 'project_id', 'document_id')->withPivot('created_at');
    }

    public function history()
    {
        return $this->hasMany(ProjectHistory::class, 'project_id');
    }

    public function observations()
    {
        return $this->hasMany(Observation::class);
    }

    public function guideline()
    {
        return $this->belongsTo('App\Models\Guideline');
    }
}
