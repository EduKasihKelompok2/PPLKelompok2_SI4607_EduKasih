<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->assertSee('Login')
            ->clickLink('login')
            ->type('email', 'akbar@gmail.com')
            ->type('password', 'bocilepep') 
            ->press('Login') 
            ->assertPathIs('/dashboard') 
            ->assertSee('Login');
        });
    }
}
