<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class MencariDiDaftarBantuan_NegativeTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
         $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $browser->loginAs($user)
                    ->visit('/daftar-bantuan')
                    ->type('#searchInput', 'aaaaaa')
                    ->assertSee('Tidak ada hasil yang ditemukan');
        });
    }
}
