<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginFailed()
    {
        $this->browse(function (Browser $browser) {
            //login failed
            $browser->visit('/admin/login')
                ->type('email', 'admin1@user.com')
                ->type('password', '123456')
                ->press('Login')
                ->assertSee('Login');

            //login success
            $browser->visit('/admin/login')
                ->type('email', 'admin@user.com')
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/admin/dashboard')
                ->assertSee('administrativa');
        });
    }
}
