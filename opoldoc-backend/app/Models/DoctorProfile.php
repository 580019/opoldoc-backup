<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorProfile extends Model
{
    protected $table = 'doctor_profiles';

    protected $primaryKey = 'doctor_profile_id';

    protected $fillable = [
        'user_id',
        'license_no',
        'specialization',
        'verified_status',
    ];

    protected function casts(): array
    {
        return [
            'verified_status' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_profile_id', 'doctor_profile_id');
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'doctor_profile_id', 'doctor_profile_id');
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class, 'doctor_profile_id', 'doctor_profile_id');
    }
}
