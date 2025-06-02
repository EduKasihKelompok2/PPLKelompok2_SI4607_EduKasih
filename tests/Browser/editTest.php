<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Storage;

class EditTest extends DuskTestCase
{
    public function testEditBankSoal(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/login')
                ->type('email', 'admin@gmail.com')
                ->type('password', 'admin')
                ->press('Login')
                ->assertPathIs('/admin')
                ->clickLink('Bank Soal')
                ->assertPathIs('/admin/bank-soal')
                ->waitForText('SOAL KELAS 12 - FISIKA - TEST')
                ->screenshot('BeforeEditClick')
                ->click('.edit-btn') // GANTI jika tombol edit punya selector spesifik
                ->waitFor('#editBankSoalModal')
                ->pause(1000) // tunggu animasi modal

                // Edit field
                ->type('#editJudulSoal', 'soal-edit')
                ->select('#editKelas', 'Kelas 12')
                ->select('#editMataPelajaran', 'Fisika')
                ->type('#editTanggal', now()->format('Y-m-d'))
                ->type('#editQuestionCount', '15')
                ->type('#editDeskripsi', 'Deskripsi telah diperbarui untuk test edit')
                ->screenshot('AfterEditInput')

                // Submit form
                ->press('#editBankSoalModal button[type="submit"]')
                ->pause(3000)
                ->screenshot('AfterEditSubmit')
                ->assertSee('DIUBAH');
        });
    }
}
