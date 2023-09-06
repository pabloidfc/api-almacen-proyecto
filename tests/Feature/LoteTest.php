<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Lote;
use Tests\TestCase;

class LoteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Listar() {
        $res = $this -> get('/api/lote');
        $res -> assertStatus(200);
    }

    public function test_ListarUnoQueExista() {
        $estructura = [
            "id",
            "peso",
            "estado",
            "almacen_destino",
            "created_at",
            "updated_at",
            "deleted_at"
        ];
        
        $res = $this -> get('/api/lote/1');
        $res -> assertStatus(200);
        $res -> assertJsonCount(7);
        $res -> assertJsonStructure($estructura);
    }

    public function test_ListarUnoQueNoExista() {
        $res = $this -> get('/api/lote/f');
        $res -> assertStatus(404);
    }

    public function test_ModificarUnoQueExista() {
        $res = $this -> put('/api/lote/1');
        $res -> assertStatus(200);
    }
    
    public function test_ModificarUnoQueNoExista() {
        $res = $this -> put('/api/lote/f');
        $res -> assertStatus(404);
    }

    public function test_EliminarUnoQueExista() {
        $res = $this -> delete('/api/lote/1');
        $res -> assertStatus(200);
        $res -> assertJsonFragment([
             "msg" => "El Lote ha sido eliminado correctamente!"
        ]);

        $this -> assertDatabaseMissing('lote', [
            'id' => '1',
            'deleted_at' => null
        ]);

        Lote::withTrashed() -> where("id", 1) -> restore();
    }

    public function test_EliminarUnoQueNoExista() {
        $res = $this -> delete('/api/lote/f');
        $res -> assertStatus(404);
    }

    public function test_Crear() {
        $res = $this -> post('/api/lote/', [
            "peso" => 10.22,
            "estado" => "Creado",
            "created_at" => "2023-01-01 12:00:00",
            "updated_at" => "2023-01-01 12:00:00"
        ]);

        $loteCreado = $res -> json();
        $loteId = $loteCreado['id'];

        $res -> assertStatus(201);
        $res -> assertJsonCount(5);
        $this -> assertDatabaseHas('lote', [
            "id" => $loteId
        ]);

        Lote::find($loteId) -> forceDelete();
    }
}
