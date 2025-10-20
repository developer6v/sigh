<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Somente médico
    public function consultationsByPatient(Request $request)
    {
       abort_unless(Auth::user()->role === 'gestor', 403);
        $patientId = $request->input('patient_id');

        $patients = User::where('role','cliente')->orderBy('name')->get();

        $appointments = collect();
        if ($patientId) {
            $appointments = Appointment::with(['doctor','diagnosis'])
                ->where('patient_id', $patientId)
                ->orderBy('scheduled_at','desc')
                ->get();
        }

        return view('reports.consultations_by_patient', compact('patients','appointments','patientId'));
    }
}
