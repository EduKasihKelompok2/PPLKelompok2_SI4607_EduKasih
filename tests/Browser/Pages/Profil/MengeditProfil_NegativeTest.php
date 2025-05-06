<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class MengeditProfil_NegativeTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group pbi6negatif
     */
    public function testMengeditProfil_Negative()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/profile/edit')
                    ->type('email', 'emailinvalid') // Email format salah
                    ->press('Simpan')
                    ->assertSee('Format email tidak valid');
        });
    }
}
