<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CRUDDaftarBantuan_PositiveTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('#email', 'admin@gmail.com')
                    ->type('#password', 'admin')
                    ->click('@login-button')
                    ->assertPathIs('/admin')
                    ->visit('/daftar-bantuan')
                    ->click('button[data-bs-target="#scholarshipFormModal"]')
                    ->type('#name', 'Beasiswa Bank Indonesia')
                    ->type('#registration_start', '01/07/2025')
                    ->type('#registration_end', '01/07/2025')
                    ->type('description', 'Ini deskripsi')
                    ->press('Simpan')
                    ->assertSee('Beasiswa Telkom');
        });
    }
}
