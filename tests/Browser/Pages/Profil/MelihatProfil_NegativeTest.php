<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class MelihatProfil_NegativeTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group pbi5negatif
     */
    public function testMelihatProfil_Negative()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/profile')
                    ->assertPathIsNot('/profile')
                    ->assertGuest();
        });
    }
}