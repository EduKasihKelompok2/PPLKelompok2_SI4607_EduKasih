<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfileTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testProfilMenampilkanDataYangBenar()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/register')
            ->type('name', 'Ezra Lexionard')
            ->type('email', 'ezra@example.com')
            ->type('password', 'password123')
            ->type('password_confirmation', 'password123')
            ->press('Register')
            ->assertPathIs('/home')

            ->visit('/profil') // Ganti dengan route profil yang sesuai
            ->assertSee('Ezra Lexionard')
            ->assertSee('ezra@example.com');
    });
}
}
