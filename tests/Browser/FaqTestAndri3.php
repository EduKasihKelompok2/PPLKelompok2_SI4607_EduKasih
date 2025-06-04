<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FaqTestAndri3 extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */

public function testFaqSearchAndri(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/login')
                ->type('email', 'andrit@gmail.com')
                ->type('password', 'andrit')
                ->press('Login')
                ->assertPathIs('/')
                ->clickLink('FAQ')
                ->assertPathIs('/faq')
                ->assertSee('Frequently Ask Question');
            
            // Mengisi search input dengan JavaScript
            $browser->script('document.getElementById("faqSearchInput").value = "edukajoy"');
            
            // Trigger input event untuk live search
            $browser->script('document.getElementById("faqSearchInput").dispatchEvent(new Event("input"))');
            
            // Menunggu proses search selesai
            $browser->pause(2000);

            $browser->assertSee('Tidak ada hasil yang cocok dengan pencarian Anda');
            
            // Mengambil screenshot
            $browser->screenshot("MencariFaqTidakRelevanAndri");
        });
    }
}