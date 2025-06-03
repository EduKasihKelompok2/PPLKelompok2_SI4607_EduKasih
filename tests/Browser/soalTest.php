<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Storage;

class soalTest extends DuskTestCase
{
    public function testExample(): void
    {
        // Path file asli
        $filePath = storage_path('app/public/test-files/soal_test.pdf');

        // Cek jika file tidak ditemukan
        if (!file_exists($filePath)) {
            $this->fail("File tidak ditemukan di: $filePath");
        }

        $this->browse(function (Browser $browser) use ($filePath) {
            $browser->visit('/')
                ->assertPathIs('/login')
                ->type('email', 'admin@gmail.com')
                ->type('password', 'admin')
                ->press('Login')
                ->assertPathIs('/admin')
                ->clickLink('Bank Soal')
                ->assertPathIs('/admin/bank-soal')
                ->press('Tambah Soal')
                ->waitFor('#addBankSoalModal')
                ->type('title', 'SOAL KELAS 12 - FISIKA - TEST')
                ->select('class', 'Kelas 12')
                ->select('subject', 'Fisika')
                ->type('upload_date', now()->format('Y-m-d'))
                ->type('question_count', '10')
                ->type('description', 'Kumpulan soal fisika untuk test upload')
                ->screenshot('BeforeAttach')
                ->attach('file', $filePath) // Pastikan "file" sesuai nama input
                ->screenshot('AfterAttach')
                ->press('Upload')
                ->pause(5000)
                ->screenshot('AfterUpload')
                ->assertSee('SOAL KELAS 12 - FISIKA - TEST');
        });

        // VERIFIKASI FILE TERUPLOAD — Harusnya hanya jika kamu pakai storeAs
        Storage::disk('public')->assertExists('bank-soal/soal_test.pdf');

    }
}
