<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{
    public function index()
    {
        return response()->json(
            DoctorProfile::with('user')
                ->orderBy('doctor_profile_id')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,user_id', 'unique:doctor_profiles,user_id'],
            'license_no' => ['nullable', 'string', 'max:50'],
            'specialization' => ['nullable', 'string', 'max:50'],
            'verified_status' => ['sometimes', 'boolean'],
        ]);

        $profile = DoctorProfile::create($validated);

        return response()->json($profile->load('user'), 201);
    }

    public function show(DoctorProfile $doctorProfile)
    {
        return response()->json($doctorProfile->load('user'));
    }

    public function update(Request $request, DoctorProfile $doctorProfile)
    {
        $validated = $request->validate([
            'license_no' => ['sometimes', 'nullable', 'string', 'max:50'],
            'specialization' => ['sometimes', 'nullable', 'string', 'max:50'],
            'verified_status' => ['sometimes', 'boolean'],
        ]);

        $doctorProfile->update($validated);

        return response()->json($doctorProfile->load('user'));
    }

    public function destroy(DoctorProfile $doctorProfile)
    {
        $doctorProfile->delete();

        return response()->json(['deleted' => true]);
    }
}
