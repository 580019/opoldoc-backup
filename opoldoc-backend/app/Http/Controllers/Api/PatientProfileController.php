<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientProfile;
use Illuminate\Http\Request;

class PatientProfileController extends Controller
{
    public function index()
    {
        return response()->json(
            PatientProfile::with(['user', 'statuses'])
                ->orderBy('patient_profile_id')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,user_id', 'unique:patient_profiles,user_id'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string'],
            'uploaded_id_path' => ['nullable', 'string', 'max:255'],
            'emergency_contact' => ['nullable', 'string', 'max:100'],
        ]);

        $profile = PatientProfile::create($validated);

        return response()->json($profile->load(['user', 'statuses']), 201);
    }

    public function show(PatientProfile $patientProfile)
    {
        return response()->json($patientProfile->load(['user', 'statuses']));
    }

    public function update(Request $request, PatientProfile $patientProfile)
    {
        $validated = $request->validate([
            'birth_date' => ['sometimes', 'nullable', 'date'],
            'gender' => ['sometimes', 'nullable', 'string', 'max:10'],
            'address' => ['sometimes', 'nullable', 'string'],
            'uploaded_id_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'emergency_contact' => ['sometimes', 'nullable', 'string', 'max:100'],
        ]);

        $patientProfile->update($validated);

        return response()->json($patientProfile->load(['user', 'statuses']));
    }

    public function destroy(PatientProfile $patientProfile)
    {
        $patientProfile->delete();

        return response()->json(['deleted' => true]);
    }
}
