<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Visit extends Model
{
    protected $table = 'visits';

    protected $primaryKey = 'visit_id';

    protected $fillable = [
        'appointment_id',
        'patient_profile_id',
        'doctor_profile_id',
        'visit_date',
        'reason_for_visit',
        'diagnosis',
        'treatment_notes',
        'prescription_id',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'datetime',
        ];
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'appointment_id');
    }

    public function patientProfile(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_profile_id', 'patient_profile_id');
    }

    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class, 'doctor_profile_id', 'doctor_profile_id');
    }

    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class, 'visit_id', 'visit_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'visit_id', 'visit_id');
    }
}
