<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class MengeditProfil_PositiveTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group pbi6positif
     */
    public function testMengeditProfil_Positive()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/profile/edit')
                    ->type('name', 'User Baru')
                    ->type('email', 'userbaru@example.com')
                    ->press('Simpan')
                    ->assertSee('Profil berhasil diperbarui')
                    ->assertSee('User Baru')
                    ->assertSee('userbaru@example.com');
        });
    }
}
