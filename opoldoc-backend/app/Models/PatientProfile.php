<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PatientProfile extends Model
{
    protected $table = 'patient_profiles';

    protected $primaryKey = 'patient_profile_id';

    protected $fillable = [
        'user_id',
        'birth_date',
        'gender',
        'address',
        'uploaded_id_path',
        'emergency_contact',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_profile_id', 'patient_profile_id');
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'patient_profile_id', 'patient_profile_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'patient_profile_id', 'patient_profile_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(PatientFile::class, 'patient_profile_id', 'patient_profile_id');
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(PatientStatus::class, 'patient_profile_id', 'patient_profile_id');
    }
}
