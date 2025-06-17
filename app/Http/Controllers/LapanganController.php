<?php

namespace App\Http\Controllers;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        return Lapangan::all();
    }

    // Fungsi  create
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price_per_hour' => 'required|numeric',
        ]);
        return Lapangan::create($request->all());
    }

    // Fungsi  read
    public function show($id)
    {
        $lapangan = Lapangan::find($id);
        if (!$lapangan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($lapangan);
    }

    // Fungsi Update
    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::find($id);
        if (!$lapangan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required',
            'price_per_hour' => 'sometimes|required|numeric',
        ]);

        $lapangan->update($request->all());
        return response()->json(['message' => 'Berhasil diupdate', 'data' => $lapangan]);
    }

    // Fungsi hapus
    public function destroy($id)
    {
        $lapangan = Lapangan::find($id);
        if (!$lapangan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        $lapangan->delete();
        return response()->json(['message' => 'Lapangan berhasil dihapus']);
    }

}