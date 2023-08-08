<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PermissionUserTest extends TestCase
{

    public function testShouldBeAbleToGivePermissionToAnUser()
    {
        $user = User::factory()->create();

        $user->givePermissionTo('Modulo-Users');

        $this->assertTrue($user->hasPermissionTo('Modulo-Users'));
        $this->assertDatabaseHas('permissions', [
            'permission' => 'Modulo-Users',
        ]);

    }
}
