<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MenyambungkanDataProfil_PositiveTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group pbi4positif
     */
    public function testMenyambungkanDataProfil_Positive()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'dob' => '2000-01-01',
            'institution' => 'Telkom',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/profile')
                    ->assertSee('Test User')
                    ->assertSee('testuser@example.com');
        });
    }
}
