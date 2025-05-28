<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/')
                ->Clicklink('Register here')
                ->assertPathIs('/register')
                ->type('name', 'susii')
                ->type('dob', '27/07/2003')
                ->select('gender', 'female')
                ->type('institution', 'telkom')
                ->type('email', '')
                ->type('password', '12345')
                ->type('password_confirmation', '12345')
                ->press('Sign Up')
                ->assertPathIs('/')
                ->screenshot("Register");
        });
    }
}