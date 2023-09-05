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
        
        $res = $this -> get('/api/producto/500001');
        $res -> assertStatus(200);
        $res -> assertJsonCount(10);
        $res -> assertJsonStructure($estructura);
    }

    public function test_ListarUnoQueNoExista() {
        $res = $this -> get('/api/producto/500000');
        $res -> assertStatus(404);
    }

    public function test_EliminarUnoQueNoExista() {
        $res = $this -> delete('/api/producto/500000');
        $res -> assertStatus(404);
    }
}
