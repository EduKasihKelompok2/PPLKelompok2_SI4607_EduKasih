<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteFaqAndri extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */

public function testAdminDeleteFaqAndri(): void
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
                ->assertSee('test question edit')
                ->click('tbody tr:nth-child(2) button[data-bs-target="#deleteFaqModal"]')
                ->assertSee('Are you sure you want to delete this FAQ? This action cannot be undone.')
                ->press('Delete FAQ')
                ->screenshot('AdminDeleteFaqAndri');
        });
    }
}