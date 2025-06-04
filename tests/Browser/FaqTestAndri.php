<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FaqTestAndri extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */
    public function testFaqAndri(): void
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
                ->assertSee('Frequently Ask Question')
                ->screenshot("LihatFaqAndri");
        });
    }
}