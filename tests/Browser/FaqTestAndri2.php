<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FaqTestAndri2 extends DuskTestCase
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
            $browser->script('document.getElementById("faqSearchInput").value = "edukasih"');
            
            // Trigger input event untuk live search
            $browser->script('document.getElementById("faqSearchInput").dispatchEvent(new Event("input"))');
            
            // Menunggu proses search selesai
            $browser->pause(2000);
            
            // Mengambil screenshot
            $browser->screenshot("MencariFaqAndri");
        });
    }
}