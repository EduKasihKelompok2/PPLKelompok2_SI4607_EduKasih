<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UploadSoalTest extends DuskTestCase
{
    /**
     * A Dusk test for uploading a soal (question bank).
     */
    public function testUploadBankSoal(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    //->type('email', 'admin@gmail.com')
                    //->type('password', 'admin')
                    //->press('Login')
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
                    ->attach('file', storage_path('app/public/test-files/soal_test.pdf'))
                    ->press('Upload')
                    ->waitForText('SOAL KELAS 12 - FISIKA - TEST', 10)
                    ->assertSee('SOAL KELAS 12 - FISIKA - TEST')
                    ->screenshot("UploadSoalSuccess");
        });
    }
}
