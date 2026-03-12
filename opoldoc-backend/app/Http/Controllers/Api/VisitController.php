<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index()
    {
        return response()->json(
            Visit::with(['appointment', 'patientProfile.user', 'doctorProfile.user', 'prescription', 'transaction'])
                ->orderByDesc('visit_date')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => ['nullable', 'integer', 'exists:appointments,appointment_id'],
            'patient_profile_id' => ['required', 'integer', 'exists:patient_profiles,patient_profile_id'],
            'doctor_profile_id' => ['required', 'integer', 'exists:doctor_profiles,doctor_profile_id'],
            'visit_date' => ['required', 'date'],
            'reason_for_visit' => ['nullable', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'treatment_notes' => ['nullable', 'string'],
        ]);

        $visit = Visit::create($validated);

        return response()->json($visit->load(['appointment', 'patientProfile.user', 'doctorProfile.user']), 201);
    }

    public function show(Visit $visit)
    {
        return response()->json($visit->load(['appointment', 'patientProfile.user', 'doctorProfile.user', 'prescription.items', 'transaction']));
    }

    public function update(Request $request, Visit $visit)
    {
        $validated = $request->validate([
            'appointment_id' => ['sometimes', 'nullable', 'integer', 'exists:appointments,appointment_id'],
            'patient_profile_id' => ['sometimes', 'integer', 'exists:patient_profiles,patient_profile_id'],
            'doctor_profile_id' => ['sometimes', 'integer', 'exists:doctor_profiles,doctor_profile_id'],
            'visit_date' => ['sometimes', 'date'],
            'reason_for_visit' => ['sometimes', 'nullable', 'string'],
            'diagnosis' => ['sometimes', 'nullable', 'string'],
            'treatment_notes' => ['sometimes', 'nullable', 'string'],
        ]);

        $visit->update($validated);

        return response()->json($visit->load(['appointment', 'patientProfile.user', 'doctorProfile.user']));
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();

        return response()->json(['deleted' => true]);
    }
}
