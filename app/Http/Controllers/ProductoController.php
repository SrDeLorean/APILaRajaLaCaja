<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\Producto;
use App\Models\ProductoBrindi;
use App\Models\ProductoCategoria;
use App\Models\ProductoPasatiempo;
use App\Models\ProductoPreferencia;
use App\Models\ProductoMascota;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $productos =  Producto::all();
            foreach($productos as $producto){
                $categorias = ProductoCategoria::where('producto', $producto->id)->get();
                foreach($categorias as $categoria){
                    $categoria->getCategoria->nombre;
                }
                $producto->categorias = $categorias;

                $brindis = ProductoBrindi::where('producto', $producto->id)->get();
                foreach($brindis as $brindi){
                    $brindi->getBrindi->nombre;
                }
                $producto->brindis = $brindis;

                $pasatiempos = ProductoPasatiempo::where('producto', $producto->id)->get();
                foreach($pasatiempos as $pasatiempo){
                    $pasatiempo->getPasatiempo->nombre;
                }
                $producto->pasatiempos = $pasatiempos;

                $preferencias = ProductoPreferencia::where('producto', $producto->id)->get();
                foreach($preferencias as $preferencia){
                    $preferencia->getPreferencia->nombre;
                }
                $producto->preferencias = $preferencias;
            }
            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['productos'=>$productos]
            ], 200);
        //----- Mecanismos anticaidas y reporte de errores -----
        }catch(\Illuminate\Database\QueryException $ex){ 
            return response()->json([
                'success' => false,
                'message' => 'Error al solicitar peticion a la base de datos',
                'data' => ['error'=>$ex]
            ], 409);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entradas = $request->only('nombre', 'cantidad', 'precioCompra', 'precioVenta', 'foto', 'categorias', 'pasatiempos', 'brindis', 'preferencias', 'mascotas');
        $validator = Validator::make($entradas, [
            'nombre' => ['required', 'string'],
            'cantidad' => [' required', 'numeric'],
            'precioCompra' => ['required', 'numeric'],
            'precioVenta' => [' required', 'numeric'],
            'foto' => ['nullable', 'string'],
            'categorias' => ['nullable'],
            'pasatiempos' => ['nullable'],
            'brindis' => ['nullable'],
            'preferencias' => ['nullable'],
            'mascotas' => ['nullable']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error en datos ingresados',
                'data' => ['error'=>$validator->errors()]
            ], 422);
        }
        $entradas = $this->rellenarDatosFaltantes(null, $entradas);
        try{
            $producto = new Producto();
            $producto->nombre=$entradas['nombre'];
            $producto->cantidad=$entradas['cantidad'];
            $producto->precioCompra=$entradas['precioCompra'];
            $producto->precioVenta=$entradas['precioVenta'];
            $producto->foto=$entradas['foto'];
            $producto->save();
            foreach($entradas['categorias'] as $categoria){
                $productoCategoria = new ProductoCategoria();
                $productoCategoria->producto = $producto->id;
                $productoCategoria->categoria = $categoria;
                $productoCategoria->save();
            }
            foreach($entradas['pasatiempos'] as $pasatiempo){
                $productoPasatiempo = new ProductoPasatiempo();
                $productoPasatiempo->producto = $producto->id;
                $productoPasatiempo->pasatiempo = $pasatiempo;
                $productoPasatiempo->save();
            }
            foreach($entradas['brindis'] as $brindi){
                $productoBrindi = new ProductoBrindi();
                $productoBrindi->producto = $producto->id;
                $productoBrindi->brindi = $brindi;
                $productoBrindi->save();
            }

            foreach($entradas['preferencias'] as $preferencia){
                $productoPreferencia = new ProductoPreferencia();
                $productoPreferencia->producto = $producto->id;
                $productoPreferencia->preferencia = $preferencia;
                $productoPreferencia->save();
            }
            foreach($entradas['mascotas'] as $mascota){
                $productoMascota = new ProductoMascota();
                $productoMascota->producto = $producto->id;
                $productoMascota->mascota = $mascota;
                $productoMascota->save();
            }



            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['producto'=>$producto]
            ], 200);
        //----- Mecanismos anticaidas y reporte de errores -----
        }catch(\Illuminate\Database\QueryException $ex){ 
            return response()->json([
                'success' => false,
                'message' => "Error en la base de datos",
                'data' => ['data'=>$ex]
            ], 409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $entradas = $request->only('nombre', 'cantidad', 'precioCompra', 'precioVenta', 'foto');
        $validator = Validator::make($entradas, [
            'nombre' => ['nullable', 'string'],
            'cantidad' => [' nullable', 'numeric'],
            'precioCompra' => ['nullable', 'numeric'],
            'precioVenta' => [' nullable', 'numeric'],
            'foto' => ['nullable', 'string']
        ]);
        //respuesta cuando falla
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error en datos ingresados',
                'data' => ['error'=>$validator->errors()]
            ], 422);
        }
        try{
            $producto = Producto::find($id);
            $entradas = $this->rellenarDatosFaltantes($producto, $entradas);
            if($producto==null){
                return response()->json([
                    'success' => false,
                    'message' => 'El producto con el id '.$id.' no existe',
                    'data' => null
                ], 409);
            }
            $producto->nombre=$entradas['nombre'];
            $producto->cantidad=$entradas['cantidad'];
            $producto->precioCompra=$entradas['precioCompra'];
            $producto->precioVenta=$entradas['precioVenta'];
            $producto->foto=$entradas['foto'];
            $producto->save();
            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['producto'=>$producto]
            ], 200);
        //----- Mecanismos anticaidas y reporte de errores -----
        }catch(\Illuminate\Database\QueryException $ex){ 
            return response()->json([
                'success' => false,
                'message' => "Error en la base de datos",
                'data' => ['error'=>$ex]
            ], 409 );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $producto = Producto::find($id);
            if($producto==null){
                return response()->json([
                    'success' => false,
                    'message' => 'El producto con el id '.$id.' no existe',
                    'data' => null
                ], 409 );
            }
            $producto->delete();
            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['producto'=>$producto]
            ], 200);
        //----- Mecanismos anticaidas y reporte de errores -----
        }catch(\Illuminate\Database\QueryException $ex){ 
            return response()->json([
                'success' => false,
                'message' => "Error en la base de datos",
                'data' => ['error'=>$ex]
            ], 409 );
        }
    }

    /**
     * Este metodo se encarga de rellenar los datos faltantes que pueden venir en la peticion https
     * Motivo: solicionar el problema al momento de crear añadir un elemento, este puede no existir
     * ejemplo: $producto->nombre=$entradas['nombre'];
     */
    private function rellenarDatosFaltantes($producto, $entradas){
        if($producto==null){
            if(!array_key_exists ("nombre" , $entradas)){
                $entradas['nombre'] = null;
            }
            if(!array_key_exists ("cantidad" , $entradas)){
                $entradas['cantidad'] = null;
            }
            if(!array_key_exists ("precioCompra" , $entradas)){
                $entradas['precioCompra'] = null;
            }
            if(!array_key_exists ("precioVenta" , $entradas)){
                $entradas['precioVenta'] = null;
            }
            if(!array_key_exists ("foto" , $entradas)){
                $entradas['foto'] = null;
            }
            if(!array_key_exists ("categorias" , $entradas)){
                $entradas['categorias'] = null;
            }
            if(!array_key_exists ("pasatiempos" , $entradas)){
                $entradas['pasatiempos'] = null;
            }
            if(!array_key_exists ("brindis" , $entradas)){
                $entradas['brindis'] = null;
            }
            if(!array_key_exists ("preferencias" , $entradas)){
                $entradas['preferencias'] = null;
            }
            if(!array_key_exists ("mascotas" , $entradas)){
                $entradas['mascotas'] = null;
            }
        }else{
            if(!array_key_exists ("nombre" , $entradas)){
                $entradas['nombre'] = $producto['nombre'];
            }
            if(!array_key_exists ("cantidad" , $entradas)){
                $entradas['cantidad'] = $producto['cantidad'];
            }
            if(!array_key_exists ("precioCompra" , $entradas)){
                $entradas['precioCompra'] = $producto['precioCompra'];
            }
            if(!array_key_exists ("precioVenta" , $entradas)){
                $entradas['precioVenta'] = $producto['precioVenta'];
            }
            if(!array_key_exists ("foto" , $entradas)){
                $entradas['foto'] = $producto['foto'];
            }
        }
        return $entradas;
    }
}
