<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/')
                ->assertPathIs('/login')
                ->type('email', 'eishasalsabila5@gmail.com')
                ->type('password', '12345')
                ->press('Login')
                ->assertPathIs('/')
                ->screenshot("Login");
        });
    }
}