<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCertificate extends Model
{
    use HasFactory;

    protected $table = 'project_certificate';

    protected $primaryKey = 'project_certificate_id';

    public $timestamps = false;

    protected $fillable = ['certificate_number', 'certificate_1', 'certificate_2', 'created_by'];

    static public function getCertificateByClientName($certificate_number)
    {
        if ($certificate_number) {
            return self::where('certificate_number', $certificate_number)->select('project_certificate_id', 'certificate_1', 'certificate_2')->first();
        }

        return null;
    }

    static public function deleteCertificateById($id)
    {
        $certificateData = self::where('project_certificate_id', $id);
        $certificate = $certificateData->select('certificate_1')->first()->certificate_1;
        $certificateData->update(['certificate_1' => 'n/a']);
        $path = public_path("uploads/" . $certificate);
        if (is_file($path)) {
            unlink($path);
        }
    }

    static public function deleteTerminationById($id)
    {
        $certificateData = self::where('project_certificate_id', $id);
        $certificate = $certificateData->select('certificate_2')->first()->certificate_2;
        $certificateData->update(['certificate_2' => null]);
        $path = public_path("uploads/" . $certificate);
        if (is_file($path)) {
            unlink($path);
        }
    }
}
