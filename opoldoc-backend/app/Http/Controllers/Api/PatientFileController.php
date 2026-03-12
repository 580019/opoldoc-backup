<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientFile;
use Illuminate\Http\Request;

class PatientFileController extends Controller
{
    public function index()
    {
        return response()->json(
            PatientFile::with('patientProfile.user')
                ->orderByDesc('file_id')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_profile_id' => ['required', 'integer', 'exists:patient_profiles,patient_profile_id'],
            'file_type' => ['required', 'string', 'max:50'],
            'file_path' => ['required', 'string', 'max:255'],
            'uploaded_at' => ['nullable', 'date'],
        ]);

        $file = PatientFile::create($validated);

        return response()->json($file->load('patientProfile.user'), 201);
    }

    public function show(PatientFile $file)
    {
        return response()->json($file->load('patientProfile.user'));
    }

    public function update(Request $request, PatientFile $file)
    {
        $validated = $request->validate([
            'file_type' => ['sometimes', 'string', 'max:50'],
            'file_path' => ['sometimes', 'string', 'max:255'],
            'uploaded_at' => ['sometimes', 'nullable', 'date'],
        ]);

        $file->update($validated);

        return response()->json($file->load('patientProfile.user'));
    }

    public function destroy(PatientFile $file)
    {
        $file->delete();

        return response()->json(['deleted' => true]);
    }
}
