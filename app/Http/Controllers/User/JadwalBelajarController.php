<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\JadwalBelajar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalBelajarController extends Controller
{
    public function index()
    {
        $dayOrder = [ 
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
            'Minggu' => 7 
        ];

        $allJadwals = JadwalBelajar::where('user_id', auth()->user()->id) 
            ->orderBy('jam', 'asc')
            ->get();

        $groupedJadwals = [];

        foreach ($dayOrder as $day => $order) {
            $daySchedules = $allJadwals->filter(function ($jadwal) use ($day) {
                return $jadwal->hari === $day;
            });

            if ($daySchedules->count() > 0) {
                $groupedJadwals[$day] = $daySchedules;
            }
        }

        return view('user.jadwal-belajar', [
            'groupedJadwals' => $groupedJadwals,
            'datas' => $allJadwals
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_mapel' => 'required',
                'hari' => 'required',
                'jam' => 'required',
                'keterangan' => 'required',
            ]);

           
            $existingJadwal = JadwalBelajar::where('user_id', auth()->user()->id)
                ->where('hari', $request->hari)
                ->where('jam', $request->jam)
                ->first();

            if ($existingJadwal) {
                return redirect()->back()->with('error', 'Sudah ada jadwal pada hari dan jam yang sama. Silakan pilih waktu lain.')
                    ->withInput();
            }

            JadwalBelajar::create([
                'user_id' => auth()->user()->id,
                'nama_mapel' => $request->nama_mapel,
                'hari' => $request->hari,
                'jam' => $request->jam,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->back()->with('success', 'Jadwal Belajar Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_mapel' => 'required',
                'hari' => 'required',
                'jam' => 'required',
                'keterangan' => 'required',
            ]);

            $jadwal = JadwalBelajar::findOrFail($id);

            
            $existingJadwal = JadwalBelajar::where('user_id', auth()->user()->id)
                ->where('hari', $request->hari)
                ->where('jam', $request->jam)
                ->where('id', '!=', $id) 
                ->first();

            if ($existingJadwal) {
                return redirect()->back()->with('error', 'Sudah ada jadwal pada hari dan jam yang sama. Silakan pilih waktu lain.')
                    ->withInput();
            }

            $jadwal->update([
                'nama_mapel' => $request->nama_mapel,
                'hari' => $request->hari,
                'jam' => $request->jam,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->back()->with('success', 'Jadwal Belajar Berhasil Diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $jadwal = JadwalBelajar::findOrFail($id);
            $jadwal->delete();

            return redirect()->back()->with('success', 'Jadwal Belajar Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
