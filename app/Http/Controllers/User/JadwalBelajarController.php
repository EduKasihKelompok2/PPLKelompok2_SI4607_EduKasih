<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\JadwalBelajar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class JadwalBelajarController extends Controller
{
    protected $activity;

    public function __construct()
    {
        $this->activity = new Activity();
    }

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

        // Get current week dates
        $currentWeekDates = $this->getCurrentWeekDates();

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

        $this->activity->saveActivity('Mengakses halaman jadwal belajar');

        return view('user.jadwal-belajar', [
            'groupedJadwals' => $groupedJadwals,
            'datas' => $allJadwals,
            'currentWeekDates' => $currentWeekDates
        ]);
    }

    /**
     * Get current week dates mapped to Indonesian day names
     */
    private function getCurrentWeekDates()
    {
        $dates = [];
        $dayMapping = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        // Get start of current week (Monday)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);

        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startOfWeek->copy()->addDays($i);
            $dayNumber = $currentDate->dayOfWeek == 0 ? 7 : $currentDate->dayOfWeek; // Convert Sunday from 0 to 7
            $dayName = $dayMapping[$dayNumber];

            $dates[$dayName] = [
                'date' => $currentDate->format('Y-m-d'),
                'formatted_date' => $currentDate->format('d M Y'),
                'day_number' => $dayNumber
            ];
        }

        return $dates;
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

            // Check if there's already a schedule with the same day and time for this user
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

            $this->activity->saveActivity('Menambahkan jadwal belajar: ' . $request->nama_mapel);

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

            // Check if there's already another schedule with the same day and time
            $existingJadwal = JadwalBelajar::where('user_id', auth()->user()->id)
                ->where('hari', $request->hari)
                ->where('jam', $request->jam)
                ->where('id', '!=', $id) // Exclude the current jadwal from the check
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

            $this->activity->saveActivity('Memperbarui jadwal belajar: ' . $request->nama_mapel);

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

            $this->activity->saveActivity('Menghapus jadwal belajar: ' . $jadwal->nama_mapel);

            return redirect()->back()->with('success', 'Jadwal Belajar Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
