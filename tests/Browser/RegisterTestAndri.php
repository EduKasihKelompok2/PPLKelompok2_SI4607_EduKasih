<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTestAndri extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */
    public function testRegisterAndri(): void
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/')
                ->Clicklink('Register here')
                ->assertPathIs('/register')
                ->type('name', 'Andri')
                ->type('dob', '27/08/2003')
                ->select('gender', 'male')
                ->type('institution', 'Telkom')
                ->type('email', 'andrit@gmail.com')
                ->type('password', 'andrit')
                ->type('password_confirmation', 'andrit')
                ->press('Sign Up')
                ->assertPathIs('/')
                ->screenshot("RegisterAndri");
        });
    }
}