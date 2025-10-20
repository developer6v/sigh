<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Lista consultas (médico vê as dele; paciente vê as dele)
    public function index()
    {
        $user = Auth::user();
        $query = Appointment::with(['patient','doctor'])->orderBy('scheduled_at','desc');

        if ($user->isMedico())  $query->where('doctor_id',  $user->id);
        if ($user->isPaciente())$query->where('patient_id', $user->id);

        $appointments = $query->paginate(10);
        return view('appointments.index', compact('appointments','user'));
    }

    // Form para novo agendamento (paciente escolhe médico e data/hora)
    public function create()
    {
        $doctors = User::where('role','gestor')->orderBy('name')->get();
        return view('appointments.create', compact('doctors'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id'    => ['required','exists:users,id'],
            'scheduled_at' => ['required','date','after:now'],
            'notes'        => ['nullable','string','max:2000'],
        ]);

        Appointment::create([
            'patient_id'   => Auth::id(),
            'doctor_id'    => $data['doctor_id'],
            'scheduled_at' => $data['scheduled_at'],
            'notes'        => $data['notes'] ?? null,
        ]);

        // ✅ Retorna à lista com mensagem de sucesso
        return redirect()
            ->route('appointments.index')
            ->with('success', '✅ Consulta agendada com sucesso!');
    }


    // Médico conclui/cancela
    public function update(Request $request, Appointment $appointment)
    {
        $user = Auth::user();
        abort_unless($user->isMedico() && $appointment->doctor_id === $user->id, 403);

        $data = $request->validate([
            'status' => ['required','in:scheduled,done,canceled'],
            'notes'  => ['nullable','string','max:2000'],
        ]);

        $appointment->update($data);
        return back()->with('status','Consulta atualizada.');
    }
}
