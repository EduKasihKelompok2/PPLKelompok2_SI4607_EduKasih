<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteActivityAndri extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group register
     */

     public function testDeleteFaqAndri(): void
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertPathIs('/login')
            ->type('email', 'andrit@gmail.com')
            ->type('password', 'andrit')
            ->press('Login')
            ->assertPathIs('/')
            ->clickLink('Riwayat Aktivitas')
            ->assertPathIs('/activity');

        // Script untuk cari waktu 21.25 dan klik tombol dropdown > hapus
        $browser->script('
            const activityItems = document.querySelectorAll(".activity-item");
            for(let item of activityItems) {
                const timeElement = item.querySelector(".activity-time span");
                if(timeElement && timeElement.textContent.trim() === "21.25") {
                    const dropdownButton = item.querySelector("button[data-bs-toggle=\'dropdown\']");
                    dropdownButton?.click();

                    const deleteButton = item.querySelector(".dropdown-menu .dropdown-item");
                    deleteButton?.click();

                    break;
                }
            }
        ');

        $browser->assertSee('Hapus Aktivitas')
            ->assertSee('Apakah Anda yakin ingin menghapus aktivitas ini? Tindakan ini tidak dapat dibatalkan.')
            ->click('.modal.show .btn-danger')
            ->screenshot('DeleteActivityAndri');
    });
}
}