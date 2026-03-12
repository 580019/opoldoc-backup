<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientStatus;
use Illuminate\Http\Request;

class PatientStatusController extends Controller
{
    public function index(Request $request)
    {
        $query = PatientStatus::with('patientProfile.user')->orderByDesc('patient_status_id');

        if ($request->filled('patient_profile_id')) {
            $query->where('patient_profile_id', $request->integer('patient_profile_id'));
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_profile_id' => ['required', 'integer', 'exists:patient_profiles,patient_profile_id'],
            'status_type' => ['required', 'string', 'max:50'],
            'verified' => ['sometimes', 'boolean'],
            'verified_at' => ['sometimes', 'nullable', 'date'],
        ]);

        $exists = PatientStatus::where('patient_profile_id', $validated['patient_profile_id'])
            ->where('status_type', $validated['status_type'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Status already exists for this patient'], 422);
        }

        $status = PatientStatus::create([
            'patient_profile_id' => $validated['patient_profile_id'],
            'status_type' => $validated['status_type'],
            'verified' => $validated['verified'] ?? false,
            'verified_at' => $validated['verified_at'] ?? null,
        ]);

        return response()->json($status->load('patientProfile.user'), 201);
    }

    public function show(PatientStatus $patientStatus)
    {
        return response()->json($patientStatus->load('patientProfile.user'));
    }

    public function update(Request $request, PatientStatus $patientStatus)
    {
        $validated = $request->validate([
            'status_type' => ['sometimes', 'string', 'max:50'],
            'verified' => ['sometimes', 'boolean'],
            'verified_at' => ['sometimes', 'nullable', 'date'],
        ]);

        if (array_key_exists('status_type', $validated)) {
            $exists = PatientStatus::where('patient_profile_id', $patientStatus->patient_profile_id)
                ->where('status_type', $validated['status_type'])
                ->where('patient_status_id', '!=', $patientStatus->patient_status_id)
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'Status already exists for this patient'], 422);
            }
        }

        $patientStatus->update($validated);

        return response()->json($patientStatus->load('patientProfile.user'));
    }

    public function destroy(PatientStatus $patientStatus)
    {
        $patientStatus->delete();

        return response()->json(['deleted' => true]);
    }
}
