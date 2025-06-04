<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ActivityTestAndri3 extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */
    public function testSearchActivityAndri(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/login')
                ->type('email', 'andrit@gmail.com')
                ->type('password', 'andrit')
                ->press('Login')
                ->assertPathIs('/')
                ->clickLink('Riwayat Aktivitas');

            // Isi pencarian dan trigger JS event pencarian
            // $browser->script("
            //     var input = document.getElementById('activitySearch');
            //     input.value = 'Profile';
            //     input.dispatchEvent(new Event('keyup'));
            // ");
            $browser->script("
                var input = document.getElementById('activitySearch');
                input.value = 'XyzNonExistent999';
                input.dispatchEvent(new Event('keyup'));
            ");
            $browser->click('@search-button')
                ->assertSee('Belum ada aktivitas yang tercatat')
                ->screenshot("MencariRiwayatAktivitasBelumTercatatAndri");
        });
    }
}