<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MelihatDaftarBantuan_NegativeTest extends DuskTestCase
{
    public function test_cannot_view_help_list_when_not_logged_in()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/daftar-bantuan')
                    ->assertPathIs('/login');
        });
    }
}
