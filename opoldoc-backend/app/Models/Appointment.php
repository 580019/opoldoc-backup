<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'patient_profile_id',
        'doctor_profile_id',
        'appointment_date',
        'visit_status',
        'queue_number',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'datetime',
            'queue_number' => 'integer',
        ];
    }

    public function patientProfile(): BelongsTo
    {
        return $this->belongsTo(PatientProfile::class, 'patient_profile_id', 'patient_profile_id');
    }

    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class, 'doctor_profile_id', 'doctor_profile_id');
    }

    public function visit(): HasOne
    {
        return $this->hasOne(Visit::class, 'appointment_id', 'appointment_id');
    }
}
