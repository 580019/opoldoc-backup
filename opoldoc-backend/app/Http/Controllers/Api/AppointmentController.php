<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json(
            Appointment::with(['patientProfile.user', 'doctorProfile.user'])
                ->orderByDesc('appointment_date')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_profile_id' => ['required', 'integer', 'exists:patient_profiles,patient_profile_id'],
            'doctor_profile_id' => ['required', 'integer', 'exists:doctor_profiles,doctor_profile_id'],
            'appointment_date' => ['required', 'date'],
            'visit_status' => ['required', 'string', 'max:20'],
            'queue_number' => ['nullable', 'integer'],
        ]);

        $appointment = Appointment::create($validated);

        return response()->json($appointment->load(['patientProfile.user', 'doctorProfile.user']), 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment->load(['patientProfile.user', 'doctorProfile.user', 'visit']));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_profile_id' => ['sometimes', 'integer', 'exists:patient_profiles,patient_profile_id'],
            'doctor_profile_id' => ['sometimes', 'integer', 'exists:doctor_profiles,doctor_profile_id'],
            'appointment_date' => ['sometimes', 'date'],
            'visit_status' => ['sometimes', 'string', 'max:20'],
            'queue_number' => ['sometimes', 'nullable', 'integer'],
        ]);

        $appointment->update($validated);

        return response()->json($appointment->load(['patientProfile.user', 'doctorProfile.user']));
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(['deleted' => true]);
    }
}
