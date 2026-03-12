<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return response()->json(
            Transaction::with(['visit', 'patientProfile.user'])
                ->orderByDesc('transaction_id')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visit_id' => ['required', 'integer', 'exists:visits,visit_id', 'unique:transactions,visit_id'],
            'patient_profile_id' => ['required', 'integer', 'exists:patient_profiles,patient_profile_id'],
            'amount' => ['required', 'numeric'],
            'payment_mode' => ['required', 'string', 'max:20'],
            'payment_status' => ['required', 'string', 'max:20'],
            'reference_number' => ['nullable', 'string', 'max:50'],
            'receipt_path' => ['nullable', 'string', 'max:255'],
        ]);

        $transaction = Transaction::create($validated);

        return response()->json($transaction->load(['visit', 'patientProfile.user']), 201);
    }

    public function show(Transaction $transaction)
    {
        return response()->json($transaction->load(['visit', 'patientProfile.user']));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'amount' => ['sometimes', 'numeric'],
            'payment_mode' => ['sometimes', 'string', 'max:20'],
            'payment_status' => ['sometimes', 'string', 'max:20'],
            'reference_number' => ['sometimes', 'nullable', 'string', 'max:50'],
            'receipt_path' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);

        $transaction->update($validated);

        return response()->json($transaction->load(['visit', 'patientProfile.user']));
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json(['deleted' => true]);
    }
}
