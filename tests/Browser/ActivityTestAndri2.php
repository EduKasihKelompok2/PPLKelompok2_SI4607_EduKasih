<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ActivityTestAndri2 extends DuskTestCase
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
                ->clickLink('Riwayat Aktivitas')
                ->type('#activitySearch', 'FAQ');
            $browser->script('document.getElementById("activitySearch").value = "FAQ"');
                // ->script("document.getElementById('activitySearch').dispatchEvent(new Event('keyup'))");
            $browser->screenshot("MencariRiwayatAktivitasAndri");
        });
    }
}