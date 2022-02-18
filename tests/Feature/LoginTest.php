<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** test */
    public function it_visit_page_of_login()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSee('Login');
    }
}
