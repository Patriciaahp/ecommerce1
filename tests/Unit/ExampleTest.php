<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class ExampleTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    /** @test */
    public function example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

    }

}
