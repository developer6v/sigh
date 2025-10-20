<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends Controller
{
    // Form médico lança diagnóstico
    public function create(Appointment $appointment)
    {
        $user = Auth::user();
        abort_unless($user->isMedico() && $appointment->doctor_id === $user->id, 403);

        return view('diagnoses.create', compact('appointment'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $user = Auth::user();
        abort_unless($user->isMedico() && $appointment->doctor_id === $user->id, 403);

        $data = $request->validate([
            'icd_code'    => ['nullable','string','max:50'],
            'description' => ['required','string','max:5000'],
        ]);

        Diagnosis::create([
            'appointment_id' => $appointment->id,
            'icd_code'       => $data['icd_code'] ?? null,
            'description'    => $data['description'],
        ]);

        // marque consulta como done, opcional
        $appointment->update(['status' => 'done']);

        return redirect()->route('appointments.index')->with('status','Diagnóstico registrado.');
    }
}
