<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Encaixe;
use App\Models\Encaixe_movimento;
use App\Models\Encaixe_movimento_consumo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = User::factory()->create([
            'name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@123.com',
            'password' => '123',
        ]);

        $user->givePermissionTo('users');

        $encaixe =  Encaixe::factory()->create();
        
        $encaixeMovimento = Encaixe_movimento::factory()->create([
            'encaixe_id' => $encaixe->id,
        ]);

        Encaixe_movimento_consumo::factory()->create([
            'encaixe_movimento_id' => $encaixeMovimento->id,
        ]);

    }
}
