<?php

namespace Database\Seeders;

use App\Models\BankSoal;
use Carbon\Carbon;
use FPDF;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BankSoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make sure the storage directory for bank-soal exists
        if (!File::isDirectory(storage_path('app/public/bank-soal'))) {
            File::makeDirectory(storage_path('app/public/bank-soal'), 0755, true);
        }
        // Create dummy bank soal data
        $bankSoals = [
            // Original subjects
            [
                'title' => 'SOAL KELAS 12 - FISIKA - 1',
                'class' => 'Kelas 12',
                'subject' => 'Fisika',
                'description' => 'Kumpulan soal Fisika untuk persiapan ujian akhir semester dan ujian nasional.',
                'question_count' => 45,
                'file_path' => 'bank-soal/sample-dummy-1.pdf',
                'upload_date' => Carbon::now()->subDays(14),
            ],
            [
                'title' => 'SOAL KELAS 12 - KIMIA - 1',
                'class' => 'Kelas 12',
                'subject' => 'Kimia',
                'description' => 'Soal-soal latihan Kimia untuk mempersiapkan ujian semester dan ujian kelulusan.',
                'question_count' => 40,
                'file_path' => 'bank-soal/sample-dummy-2.pdf',
                'upload_date' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'SOAL KELAS 11 - MATEMATIKA - 1',
                'class' => 'Kelas 11',
                'subject' => 'Matematika',
                'description' => 'Kumpulan soal latihan Matematika untuk siswa kelas 11 SMA/MA.',
                'question_count' => 50,
                'file_path' => 'bank-soal/sample-dummy-3.pdf',
                'upload_date' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'SOAL KELAS 11 - BIOLOGI - 1',
                'class' => 'Kelas 11',
                'subject' => 'Biologi',
                'description' => 'Kumpulan soal Biologi untuk penguatan pemahaman materi kelas 11.',
                'question_count' => 35,
                'file_path' => 'bank-soal/sample-dummy-4.pdf',
                'upload_date' => Carbon::now()->subDays(5),
            ],

            // Additional subjects for university entrance exams
            [
                'title' => 'SOAL KELAS 12 - BAHASA INGGRIS - 1',
                'class' => 'Kelas 12',
                'subject' => 'Bahasa Inggris',
                'description' => 'Kumpulan soal Bahasa Inggris untuk persiapan UTBK dan ujian masuk universitas.',
                'question_count' => 45,
                'file_path' => 'bank-soal/sample-dummy-5.pdf',
                'upload_date' => Carbon::now()->subDays(12),
            ],
            [
                'title' => 'SOAL KELAS 12 - BAHASA INDONESIA - 1',
                'class' => 'Kelas 12',
                'subject' => 'Bahasa Indonesia',
                'description' => 'Latihan soal Bahasa Indonesia untuk persiapan SBMPTN dan ujian masuk PTN.',
                'question_count' => 40,
                'file_path' => 'bank-soal/sample-dummy-6.pdf',
                'upload_date' => Carbon::now()->subDays(9),
            ],
            [
                'title' => 'SOAL KELAS 12 - SEJARAH - 1',
                'class' => 'Kelas 12',
                'subject' => 'Sejarah',
                'description' => 'Kumpulan soal Sejarah untuk persiapan UTBK dan ujian masuk jurusan humaniora.',
                'question_count' => 35,
                'file_path' => 'bank-soal/sample-dummy-7.pdf',
                'upload_date' => Carbon::now()->subDays(8),
            ],
            [
                'title' => 'SOAL KELAS 12 - GEOGRAFI - 1',
                'class' => 'Kelas 12',
                'subject' => 'Geografi',
                'description' => 'Latihan soal Geografi untuk persiapan UTBK jurusan geografi dan lingkungan.',
                'question_count' => 30,
                'file_path' => 'bank-soal/sample-dummy-8.pdf',
                'upload_date' => Carbon::now()->subDays(6),
            ],
            [
                'title' => 'SOAL KELAS 12 - EKONOMI - 1',
                'class' => 'Kelas 12',
                'subject' => 'Ekonomi',
                'description' => 'Kumpulan soal Ekonomi untuk persiapan ujian masuk fakultas ekonomi dan bisnis.',
                'question_count' => 40,
                'file_path' => 'bank-soal/sample-dummy-9.pdf',
                'upload_date' => Carbon::now()->subDays(4),
            ],
            [
                'title' => 'SOAL KELAS 12 - SOSIOLOGI - 1',
                'class' => 'Kelas 12',
                'subject' => 'Sosiologi',
                'description' => 'Latihan soal Sosiologi untuk persiapan ujian masuk jurusan ilmu sosial.',
                'question_count' => 35,
                'file_path' => 'bank-soal/sample-dummy-10.pdf',
                'upload_date' => Carbon::now()->subDays(3),
            ],

            // Keep some of the original items
            [
                'title' => 'SOAL KELAS 10 - FISIKA - 1',
                'class' => 'Kelas 10',
                'subject' => 'Fisika',
                'description' => 'Soal-soal dasar Fisika untuk siswa kelas 10 SMA/MA.',
                'question_count' => 30,
                'file_path' => 'bank-soal/sample-dummy-11.pdf',
                'upload_date' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'SOAL KELAS 10 - KIMIA - 1',
                'class' => 'Kelas 10',
                'subject' => 'Kimia',
                'description' => 'Latihan soal Kimia dasar untuk siswa kelas 10.',
                'question_count' => 30,
                'file_path' => 'bank-soal/sample-dummy-12.pdf',
                'upload_date' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'SOAL KELAS 12 - MATEMATIKA - 1',
                'class' => 'Kelas 12',
                'subject' => 'Matematika',
                'description' => 'Soal-soal latihan Matematika persiapan ujian akhir.',
                'question_count' => 50,
                'file_path' => 'bank-soal/sample-dummy-13.pdf',
                'upload_date' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'SOAL KELAS 10 - BIOLOGI - 1',
                'class' => 'Kelas 10',
                'subject' => 'Biologi',
                'description' => 'Soal-soal pengenalan Biologi untuk siswa kelas 10.',
                'question_count' => 25,
                'file_path' => 'bank-soal/sample-dummy-14.pdf',
                'upload_date' => Carbon::now(),
            ],
        ];

        foreach ($bankSoals as &$bankSoal) {
            $pdfPath = storage_path('app/public/' . $bankSoal['file_path']);
            if (!File::exists($pdfPath)) {
                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(40, 10, $bankSoal['title']);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 12);
                $pdf->MultiCell(0, 10, $bankSoal['description']);
                $pdf->Output($pdfPath, 'F');
            }
        }

        // Insert the data into the database
        foreach ($bankSoals as $bankSoal) {
            BankSoal::create($bankSoal);
        }
    }
}
