<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MenyambungkanDataProfil_NegativeTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group pbi4negatif
     */
    public function testMenyambungkanDataProfil_Negative()
    {
        $user = User::factory()->create([
            'name' => 'Nama Salah',
            'email' => 'emailsalah@example.com',
            'password' => bcrypt('password'),
            'dob' => '2000-01-01',
            'institution' => 'Telkom',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/profile')
                    ->assertDontSee('Nama Benar')
                    ->assertDontSee('emailbenar@example.com');
        });
    }
}
