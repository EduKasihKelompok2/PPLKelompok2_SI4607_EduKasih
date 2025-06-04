<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EditFaqAndri extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */

public function testAdminEditFaqAndri(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/login')
                ->type('email', 'admin@gmail.com')
                ->type('password', 'admin')
                ->press('Login')
                ->assertPathIs('/admin')
                ->clickLink('FAQ')
                ->assertPathIs('/admin/faq')
                ->assertSee('FAQ Management')
                ->assertSee('test')
                ->click('tbody tr:nth-child(2) button[data-bs-target="#editFaqModal"]')
                ->assertSee('Edit FAQ')
                ->whenAvailable('#editFaqModal', function (Browser $modal) {
                    $modal->type('#edit_question', 'test question edit')
                          ->type('#edit_answer', 'test answer edit')
                          ->press('Update FAQ');
                })
                ->screenshot('AdminEditFaqAndri');
        });
    }
}