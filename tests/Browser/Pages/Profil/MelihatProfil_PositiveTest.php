<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class MelihatProfil_PositiveTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group pbi5positif
     */
    public function testMelihatProfil_Positive()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/profile')
                    ->assertSee($user->name)
                    ->assertSee($user->email);
        });
    }
}
