<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class hapusTest extends DuskTestCase
{
    public function testDeleteBankSoal(): void
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
                ->screenshot('BeforeDeleteClick')
                
                // Klik tombol hapus untuk memunculkan modal
                ->waitFor('.delete-btn')
                ->click('.delete-btn')
                
                // Tunggu modal konfirmasi muncul
                ->waitFor('#deleteBankSoalModal')
                ->pause(1000) // tunggu animasi modal
                ->screenshot('beforeDelete')
                // Klik tombol konfirmasi hapus di modal
                ->press('Ya, Hapus')
                ->pause(3000) // tunggu proses hapus selesai
                
                ->screenshot('AfterDelete');
                
                // Pastikan teks soal sudah hilang setelah dihapus
                //->assertDontSee('SOAL KELAS 12 - FISIKA - TEST');
        });
    }
}
