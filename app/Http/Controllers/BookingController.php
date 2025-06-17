<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class BookingController extends Controller
{
    public function index()
    {
        try {
            return response()->json(Booking::with('lapangan')->get(), 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'lapangan_id' => 'required|exists:lapangans,id',
                'nama_pemesan' => 'required|string|max:255',
                'no_hp' => 'required|string|max:15',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]);

            $booking = Booking::create([
                'lapangan_id' => $request->lapangan_id,
                'user_id' => Auth::id(),
                'nama_pemesan' => $request->nama_pemesan,
                'no_hp' => $request->no_hp,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);
            return response()->json($booking, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal membuat booking', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $booking = Booking::with('lapangan')->findOrFail($id);
            return response()->json($booking, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'lapangan_id' => 'exists:lapangans,id',
                'nama_pemesan' => 'string|max:255',
                'no_hp' => 'string|max:15',
                'start_time' => 'date',
                'end_time' => 'date|after:start_time',
            ]);

            $booking = Booking::findOrFail($id);
            $booking->update($request->only([
                'lapangan_id',
                'nama_pemesan',
                'no_hp',
                'start_time',
                'end_time'
            ]));

            return response()->json($booking, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui data', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();
            return response()->json(['message' => 'Booking berhasil dihapus'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal menghapus booking', 'message' => $e->getMessage()], 500);
        }
    }
}


