<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class melihatsekolah extends DuskTestCase
{
    /**
     * A Dusk test example.
      @group 
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Login')
                ->assertPathIs('/login')
                ->type('email', 'akbar@gmail.com')
                ->type('password', 'bocilepep') 
                ->assertSee('dashboard') 
                ->assertPathIs('/dashboard') 
                ->clickLink('Cari Sekolah');
                 
            
        });
    }
}
