<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\Assert;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class PermissionUserTest extends TestCase
{

    public function testShouldBeAbleToGivePermissionToAnUser()
    {
        $user = User::factory()->createOne();

        $user->givePermissionTo('Modulo-Users');

        $this->assertTrue($user->hasPermissionTo('Modulo-Users'));
        $this->assertDatabaseHas('permissions', [
            'permission' => 'Modulo-Users',
        ]);

    }

    public function testShouldBeAbleToAuthorizeAccessToARouteBasedOnThePermission()
    {

        Route::get('permission-route-testing', function() {
            return 'test';
        })->middleware('permission:Modulo-Users');

        /** @var User $user */

        $user = User::factory()->createOne();

        $this->actingAs($user)->get('permission-route-testing')
        ->assertForbidden();

        $user->givePermissionTo('Modulo-Users');

        $this->actingAs($user)->get('permission-route-testing')
        ->assertSuccessful();

    }

    public function testandoValores() 
    {

        /** @var User $user */

        $user = User::factory()->createOne();

        $user->givePermissionTo('Modulo-Users');

        $user->givePermissionTo('Modulo2-Users');

        $user->givePermissionTo('Modulo3-Users');

        assertTrue($user->hasPermissionTo('Modulo-Users'));
        assertTrue($user->hasPermissionTo('Modulo2-Users'));
        assertTrue($user->hasPermissionTo('Modulo3-Users'));

    }
}
