<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        return response()->json(
            Prescription::with(['visit', 'doctorProfile.user', 'items'])
                ->orderByDesc('prescribed_date')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visit_id' => ['required', 'integer', 'exists:visits,visit_id', 'unique:prescriptions,visit_id'],
            'doctor_profile_id' => ['required', 'integer', 'exists:doctor_profiles,doctor_profile_id'],
            'prescribed_date' => ['required', 'date'],
            'signature_path' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $prescription = Prescription::create($validated);

        return response()->json($prescription->load(['visit', 'doctorProfile.user', 'items']), 201);
    }

    public function show(Prescription $prescription)
    {
        return response()->json($prescription->load(['visit', 'doctorProfile.user', 'items']));
    }

    public function update(Request $request, Prescription $prescription)
    {
        $validated = $request->validate([
            'doctor_profile_id' => ['sometimes', 'integer', 'exists:doctor_profiles,doctor_profile_id'],
            'prescribed_date' => ['sometimes', 'date'],
            'signature_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'notes' => ['sometimes', 'nullable', 'string'],
        ]);

        $prescription->update($validated);

        return response()->json($prescription->load(['visit', 'doctorProfile.user', 'items']));
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return response()->json(['deleted' => true]);
    }
}
