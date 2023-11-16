<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    const DEPARTAMENTOS_URUGUAY = [
        "Artigas",
        "Canelones",
        "Cerro Largo",
        "Colonia",
        "Durazno",
        "Flores",
        "Florida",
        "Lavalleja",
        "Maldonado",
        "Montevideo",
        "Paysandú",
        "Río Negro",
        "Rivera",
        "Rocha",
        "Salto",
        "San José",
        "Soriano",
        "Tacuarembó",
        "Treinta y Tres"
    ];

    public function Crear(Request $req) {
        $validaciones = Validator::make($req->all(), [
            "almacen_id"        => "required|integer|exists:almacen,id",
            "peso"              => "required|numeric|min:1",
            "departamento"      => "required|in:" . implode(',', self::DEPARTAMENTOS_URUGUAY),
            "direccion_entrega" => "required|string",
            "fecha_entrega"     => "required|date|fecha_mayor_actual|fecha_menor_actual_mas_dos_dias"
        ]);

        if($validaciones->fails()) 
            return response($validaciones->errors(), 400);

        $producto = new Producto;
        $producto->peso              = $req->input("peso");
        $producto->departamento      = $req->input("departamento");
        $producto->direccion_entrega = $req->input("direccion_entrega");  
        $producto->fecha_entrega     = $req->input("fecha_entrega");
        $producto->Almacen()->associate($req->input("almacen_id"));
        $producto->save();
        return $producto;
    }

    public function Listar() {
        $productos = Producto::paginate(12);
        return $productos;
    }
    
    public function ListarLootear() {
        $productos = Producto::whereIn("estado", ["En espera", "Almacenado"])
        ->paginate(12);

        return $productos;
    }

    public function ListarUno($idProducto) {
        $producto = Producto::find($idProducto);
        if (!$producto) return response(["msg" => "Not found!"], 404);
        $producto->Almacen;
        return $producto;
    }

    public function ListarPorEstado(Request $req) {
        $estadoProducto = $req->input("estado");
        $validacion = Validator::make($req->all(), [
            "estado" => "required|in:En espera,Almacenado,Loteado,En ruta,Desloteado,En viaje,Entregado"
        ]);
        if($validacion->fails()) return response($validacion->errors(), 400);

        $producto = Producto::where("estado", "=", $estadoProducto)->get();

        return $producto;
    }

    public function ListarProductoLote($idProducto) {
        $producto = Producto::find($idProducto);
        if (!$producto) return response(["msg" => "Not found!"], 404);
        $producto->Lote;
        return $producto;
    }

    public function ListarProductoAlmacen($idProducto) {
        $producto = Producto::find($idProducto);
        if (!$producto) return response(["msg" => "Not found!"], 404);
        $producto->Almacen;
        return $producto;
    }

    public function Modificar(Request $req, $idProducto) {
        $producto = Producto::find($idProducto);
        if (!$producto) return response(["msg" => "Not found!"], 404);

        $validacion = Validator::make($req->all(), [
            "almacen_id"        => "nullable|integer|exists:almacen,id",
            "estado"            => "nullable|in:En espera,Almacenado,Loteado,En ruta,Desloteado,En viaje,Entregado",
            "peso"              => "nullable|numeric|min:1",
            "departamento"      => "nullable|in:" . implode(',', self::DEPARTAMENTOS_URUGUAY),
            "direccion_entrega" => "nullable|string"
        ]);

        if($validacion->fails()) return response($validacion->errors(), 400); 

        if ($req->input("peso"))              $this->modificarPeso($producto, $req->input("peso"));
        if ($req->input("estado"))            $this->modificarEstado($producto, $req->input("estado"));
        if ($req->input("almacen_id"))        $this->modificarAlmacen($producto, $req->input("almacen_id"));
        if ($req->input("departamento"))      $this->modificarDepartamento($producto, $req->input("departamento"));
        if ($req->input("direccion_entrega")) $this->modificarDireccion($producto, $req->input("direccion_entrega"));

        $producto -> save();
        return $producto;
    }

    private function modificarPeso($producto, $peso) {
        if ($producto->lote_id != NULL) return response(["msg" => "No se puede modificar el peso de un producto asociado a un lote"], 400);
        $producto->peso = $peso;
    }

    private function modificarAlmacen($producto, $idAlmacen) {
        $producto->Almacen()->associate($idAlmacen);
    }

    private function modificarEstado($producto, $estado) {
        $producto->estado = $estado;
    }
    
    private function modificarDepartamento($producto, $departamento) {
        $producto->departamento = $departamento;
    }

    private function modificarDireccion($producto, $direccion) {
        $producto->direccion_entrega = $direccion;
    }
    
    public function Eliminar($idProducto) {
        $producto = Producto::find($idProducto);
        if (!$producto) return response(["msg" => "Not found!"], 404);
        $producto -> delete();
        return response(["msg" => "Eliminado!"], 200);
    }
}