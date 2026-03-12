<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;

class PrescriptionItemController extends Controller
{
    public function index()
    {
        return response()->json(
            PrescriptionItem::with('prescription')
                ->orderBy('item_id')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prescription_id' => ['required', 'integer', 'exists:prescriptions,prescription_id'],
            'medicine_name' => ['required', 'string', 'max:100'],
            'dosage' => ['required', 'string', 'max:50'],
            'frequency' => ['required', 'string', 'max:50'],
            'duration' => ['required', 'string', 'max:50'],
        ]);

        $item = PrescriptionItem::create($validated);

        return response()->json($item->load('prescription'), 201);
    }

    public function show(PrescriptionItem $prescriptionItem)
    {
        return response()->json($prescriptionItem->load('prescription'));
    }

    public function update(Request $request, PrescriptionItem $prescriptionItem)
    {
        $validated = $request->validate([
            'medicine_name' => ['sometimes', 'string', 'max:100'],
            'dosage' => ['sometimes', 'string', 'max:50'],
            'frequency' => ['sometimes', 'string', 'max:50'],
            'duration' => ['sometimes', 'string', 'max:50'],
        ]);

        $prescriptionItem->update($validated);

        return response()->json($prescriptionItem->load('prescription'));
    }

    public function destroy(PrescriptionItem $prescriptionItem)
    {
        $prescriptionItem->delete();

        return response()->json(['deleted' => true]);
    }
}
