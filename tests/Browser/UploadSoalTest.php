<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UploadSoalTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $pdfFile = \Illuminate\Http\UploadedFile::fake()->create('soal_test.pdf', 100, 'application/pdf');

        $this->browse(function (Browser $browser) use ($pdfFile) {
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
                    ->attach('file', $pdfFile->getPathname())
                    ->press('Upload')
                    ->assertPathIs('/admin/bank-soal')
                    ->waitForText('SOAL KELAS 12 - FISIKA - TEST',10)
                    ->assertSee('SOAL KELAS 12 - FISIKA - TEST')
                    ->screenshot("UploadSoalSuccess");

            \Storage::disk('public')->assertExists('bank_soal/' . $pdfFile->hashName());
        });
    }
}