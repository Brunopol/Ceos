<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Encaixe;
use App\Models\Encaixe_movimento;
use App\Models\Encaixe_movimento_consumo;
use App\Models\oldEncaixe;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
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

        //$user = User::factory()->create([
        //  'name' => 'admin',
        //    'last_name' => 'admin',
        //   'email' => 'admin@123.com',
        //    'password' => '123',
        //]);
        
        //$user->givePermissionTo('users');
	//$user->givePermissionTo('encaixe');
//
       // $encaixe =  Encaixe::factory()->create();
        
        //$encaixeMovimento = Encaixe_movimento::factory()->create([
        //    'encaixe_id' => $encaixe->id,
        //]);
//
       // Encaixe_movimento_consumo::factory()->create([
       //     'encaixe_movimento_id' => $encaixeMovimento->id,
       // ]);



    
    $oldEncaixe = oldEncaixe::all();

    foreach ($oldEncaixe as $oldcaixe) {

        if ($oldcaixe->corte_id_ref == 0) {

            $newEncaixe = new Encaixe([
                'referencia' => $oldcaixe->ref,
                'created_at' => $oldcaixe->data_registro ? $oldcaixe->data_registro : Carbon::now(),

            ]);

            $newEncaixe->save();

            $movimentos = $newEncaixe->movimentos()->create([
                'nome' => $oldcaixe->nome_movimento,
                'largura' => $oldcaixe->largura,
                'tecido' => $oldcaixe->tecido,
                'quantidade' => $oldcaixe->qtd_pecas,
                'parImper' => $oldcaixe->parimpar,
                'notas' => $oldcaixe->notas,
                'created_at' => $oldcaixe->data_registro,
            ]);

            $movimentos->save();

            $movimentos->consumos()->create([
                'nome' => 'Consumo',
                'valor' => $oldcaixe->consumo,
                'created_at' => $oldcaixe->data_registro,
            ]);

            $movimentos->save();
            $newEncaixe->save();

        }

    }

    foreach ($oldEncaixe as $oldcaixe2) {


        if ($oldcaixe2->corte_id_ref != 0 && $oldcaixe2->ref != "") {

            try {

                $searchTerm = str_replace(' ', '', $oldcaixe2->ref);
                $encaixePai = Encaixe::whereRaw("REPLACE(referencia, ' ', '') = ?", [$searchTerm])->first();

                if ($encaixePai != null) {
                    $movimentos = $encaixePai->movimentos()->create([

                        'nome' => $oldcaixe2->nome_movimento,
                        'largura' => $oldcaixe2->largura,
                        'tecido' => $oldcaixe2->tecido,
                        'quantidade' => $oldcaixe2->qtd_pecas,
                        'parImper' => $oldcaixe2->parimpar,
                        'notas' => $oldcaixe2->notas,
                        'created_at' => $oldcaixe2->data_registro,
    
                    ]);
    
                    $movimentos->save();
    
                    $movimentos->consumos()->create([
                        'nome' => 'Consumo',
                        'valor' => $oldcaixe2->consumo,
                        'created_at' => $oldcaixe2->data_registro,
                    ]);
    
                    $movimentos->save();
                } else {

                    $newEncaixe = new Encaixe([
                        'referencia' => $oldcaixe2->ref,
                        'created_at' => $oldcaixe2->data_registro ? $oldcaixe2->data_registro : Carbon::now(),
        
                    ]);
        
                    $newEncaixe->save();
        
                    $movimentos = $newEncaixe->movimentos()->create([
                        'nome' => $oldcaixe2->nome_movimento,
                        'largura' => $oldcaixe2->largura,
                        'tecido' => $oldcaixe2->tecido,
                        'quantidade' => $oldcaixe2->qtd_pecas,
                        'parImper' => $oldcaixe2->parimpar,
                        'notas' => $oldcaixe2->notas,
                        'created_at' => $oldcaixe2->data_registro,
                    ]);
        
                    $movimentos->save();
        
                    $movimentos->consumos()->create([
                        'nome' => 'Consumo',
                        'valor' => $oldcaixe2->consumo,
                        'created_at' => $oldcaixe2->data_registro,
                    ]);
        
                    $movimentos->save();
                    $newEncaixe->save();
        
                }


            } catch (\Throwable $th) {
                throw $th;
                dump("error on : $oldcaixe2->corte_id_ref");
                //dump("error on NewEncaixe: $encaixePai->id, adding the movimento: $oldcaixe2->id, corte_id = $oldcaixe2->corte_id_ref");
            }

            

        }

        
        

    }


   }




}
