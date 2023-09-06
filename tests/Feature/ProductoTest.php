<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Producto;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    public function test_Listar() {
        $res = $this -> get('/api/producto');
        $res -> assertStatus(200);
    }

    public function test_ListarUnoQueExista() {
        $estructura = [
            "id",
            "peso",
            "estado",
            "fecha_entrega",
            "direccion_entrega",
            "lote_id",
            "almacen_id",
            "created_at",
            "updated_at",
            "deleted_at"
        ];
        
        $res = $this -> get('/api/producto/1');
        $res -> assertStatus(200);
        $res -> assertJsonCount(10);
        $res -> assertJsonStructure($estructura);
    }

    public function test_ListarUnoQueNoExista() {
        $res = $this -> get('/api/producto/f');
        $res -> assertStatus(404);
    }

    public function test_ModificarUnoQueExista() {
        $res = $this -> put('/api/producto/1');
        $res -> assertStatus(200);
    }
    
    public function test_ModificarUnoQueNoExista() {
        $res = $this -> put('/api/producto/f');
        $res -> assertStatus(404);
    }

    public function test_EliminarUnoQueExista() {
        $res = $this -> delete('/api/producto/1');
        $res -> assertStatus(200);
        $res -> assertJsonFragment([
             "msg" => "El Producto ha sido eliminado correctamente!"
        ]);

        $this -> assertDatabaseMissing('producto', [
            'id' => '1',
            'deleted_at' => null
        ]);

        Producto::withTrashed() -> where("id", 1) -> restore();
    }

    public function test_EliminarUnoQueNoExista() {
        $res = $this -> delete('/api/producto/f');
        $res -> assertStatus(404);
    }

    public function test_Crear() {
        $res = $this -> post('/api/producto/', [
            "peso" => 10.22,
            "estado" => "En espera",
            "fecha_entrega" => "2023-01-01",
            "direccion_entrega" => "Tu casa",
            "created_at" => "2023-01-01 12:00:00",
            "updated_at" => "2023-01-01 12:00:00"
        ]);

        $productoCreado = $res -> json();
        $productoId = $productoCreado['id'];

        $res -> assertStatus(201);
        $res -> assertJsonCount(7);
        $this -> assertDatabaseHas('producto', [
            "id" => $productoId
        ]);

        Producto::find($productoId) -> forceDelete();
    }
}
