<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class MencariDiDaftarBantuan_PositiveTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_can_search_help_with_valid_keyword()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $browser->loginAs($user)
                    ->visit('/daftar-bantuan')
                    ->type('#searchInput', 'Bank')
                    ->assertSee('Bank Indonesia');
        });
}
}