<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class MelihatDaftarBantuan_PositiveTest extends DuskTestCase
{
    public function test_can_view_help_list_when_logged_in()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $browser->loginAs($user)
                    ->visit('/daftar-bantuan')
                    ->assertSee('Daftar Bantuan');
        });
    }
}

