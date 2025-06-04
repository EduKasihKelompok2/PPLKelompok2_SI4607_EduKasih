<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class InputFaqBaruAndri extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */

public function testAdminInputFaqAndri(): void
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
                ->click('button[data-bs-target="#addFaqModal"]')
                ->type('question', 'Cara akses Profile')
                ->type('answer', 'Untuk mengakses profil Anda, silakan login ke akun Anda terlebih dahulu. Setelah berhasil login, klik pada ikon profil di pojok kanan atas halaman. Dari sana, Anda dapat melihat dan mengedit informasi profil Anda, termasuk data pribadi dan pengaturan akun.')
                ->press('Add FAQ')
                ->screenshot('AdminInputFaqAndri');
        });
    }
}