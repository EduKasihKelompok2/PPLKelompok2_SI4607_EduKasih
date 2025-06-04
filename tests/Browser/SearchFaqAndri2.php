<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SearchFaqAndri2 extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */

public function testAdminSearchFaqAndri(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/login')
                ->type('email', 'admin@gmail.com')
                ->type('password', 'admin')
                ->press('Login')
                ->assertPathIs('/admin')
                ->clickLink('FAQ')
                ->assertPathIs('/admin/faq')
                ->assertSee('FAQ Management')
                ->type('input[placeholder="Search FAQs..."]', 'Profileee')
                ->assertDontSee('Cara akses Profile')
                ->screenshot('AdminSearchFaqTidakReleanAndri');
        });
    }
}