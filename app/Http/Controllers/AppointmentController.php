<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'whatsapp'    => 'required|string|max:25',
            'institution' => 'required|string|max:255',
            'demo_date'   => 'required|date|after_or_equal:today',
            'demo_time'   => 'required|string',
            'notes'       => 'nullable|string|max:1000',
        ]);

        Appointment::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'whatsapp'    => $request->whatsapp,
            'institution' => $request->institution,
            'demo_date'   => $request->demo_date,
            'demo_time'   => $request->demo_time,
            'notes'       => $request->notes,
            'status'      => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan demo berhasil dikirim! Tim kami akan menghubungi Anda.'
        ]);
    }

    /**
     * Display a listing of appointments in the admin dashboard.
     */
    public function index()
    {
        $appointments = Appointment::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Update the status of the specified appointment.
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|string|in:pending,done,cancelled',
        ]);

        $appointment->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status appointment berhasil diperbarui!');
    }

    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->back()->with('success', 'Appointment berhasil dihapus!');
    }
}
