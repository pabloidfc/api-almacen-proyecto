<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AlmacenTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Listar() {
        $res = $this -> get('/api/almacen');
        $res -> assertStatus(200);
    }

    public function test_ListarUnoQueExista() {
        $estructura = [
            "id",
            "nombre",
            "tipo",
            "created_at",
            "updated_at",
            "deleted_at"
        ];
        
        $res = $this -> get('/api/almacen/1');
        $res -> assertStatus(200);
        $res -> assertJsonCount(6);
        $res -> assertJsonStructure($estructura);
    }

    public function test_ListarUnoQueNoExista() {
        $res = $this -> get('/api/almacen/f');
        $res -> assertStatus(404);
    }
}
