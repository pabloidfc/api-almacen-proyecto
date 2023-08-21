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
    public function test_example()
    {
        $response = $this -> get('/');
        $response -> assertStatus(200);
    }

    public function test_ListarUnoQueExista() {
        $estructura = [
            "id",
            "peso",
            "estado",
            "fecha_entrega",
            "almacen_destino",
            "created_at",
            "updated_at",
            "deleted_at",
        ];
        
        $res = $this -> get('/api/producto/500000');
        $res -> assertStatus(200);
        $res -> assertJsonCount(8);
        $res -> assertJsonStructure($estructura);
    }

    public function test_ListarUnoQueNoExista() {
        $res = $this -> get('/api/producto/500001');
        $res -> assertStatus(404);
    }
}
