<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa itu Edukasih?',
                'answer' => 'Edukasih adalah sebuah website yang hadir sebagai solusi inovatif dalam meningkatkan keberlanjutan pendidikan bagi siswa yang bersekolah pada sekolah.'
            ],
            [
                'question' => 'Bagaimana cara mendapatkan bantuan Edukasih?',
                'answer' => 'Untuk mendapatkan bantuan Edukasih, Anda perlu mendaftar melalui platform kami dan melengkapi semua persyaratan yang diminta. Tim kami akan meninjau aplikasi Anda dan menghubungi Anda untuk langkah selanjutnya.'
            ],
            [
                'question' => 'Mengapa tidak dapat mendownload video belajar?',
                'answer' => 'Video belajar di platform kami dilindungi hak cipta dan hanya tersedia untuk streaming online. Hal ini untuk melindungi konten intelektual dan memastikan kualitas pembelajaran tetap terjaga. Namun, Anda dapat mengakses video kapan saja selama memiliki koneksi internet.'
            ],
            [
                'question' => 'Cara akses profile kita',
                'answer' => 'Untuk mengakses profil Anda, silakan login ke akun Anda terlebih dahulu. Setelah berhasil login, klik pada ikon profil di pojok kanan atas halaman. Dari sana, Anda dapat melihat dan mengedit informasi profil Anda, termasuk data pribadi dan pengaturan akun.'
            ],
            [
                'question' => 'Apakah Edukasih menyediakan kursus gratis?',
                'answer' => 'Ya, Edukasih menyediakan beberapa kursus gratis untuk pengguna. Anda dapat menjelajahi katalog kami untuk menemukan kursus yang tersedia tanpa biaya.'
            ],
            [
                'question' => 'Apakah Edukasih tersedia di perangkat mobile?',
                'answer' => 'Ya, Edukasih dapat diakses melalui browser di perangkat mobile. Kami juga sedang mengembangkan aplikasi mobile yang akan segera dirilis.'
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
