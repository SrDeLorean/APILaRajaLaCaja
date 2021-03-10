<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Models\DetalleTicket;

class DetalleTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entradas = $request->only('ticket', 'producto', 'cantidad', 'precio', 'total');
        $validator = Validator::make($entradas, [
            'ticket' => ['numeric'],
            'producto' => ['numeric'],
            'cantidad' => ['numeric'],
            'precio' => ['numeric'],
            'total' => ['numeric']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error en datos ingresados',
                'data' => ['error'=>$validator->errors()]
            ], 422);
        }
        try{
            $detalleTicket = new DetalleTicket;
            $entradas = $this->rellenarDatosFaltantes(null, $entradas);
            $detalleTicket->ticket=$entradas['ticket'];
            $detalleTicket->producto=$entradas['producto'];
            $detalleTicket->cantidad=$entradas['cantidad'];
            $detalleTicket->precio=$entradas['precio'];
            $detalleTicket->total=$entradas['total'];
            $detalleTicket->save();
            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['detalleTicket'=>$detalleTicket]
            ], 200);
        //----- Mecanismos anticaidas y reporte de errores -----
        }catch(\Illuminate\Database\QueryException $ex){ 
            return response()->json([
                'success' => false,
                'message' => "Error en la base de datos",
                'data' => ['error'=>$ex]
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
        $entradas = $request->only('ticket', 'producto', 'cantidad', 'precio', 'total');
        $validator = Validator::make($entradas, [
            'ticket' => ['nullable', 'numeric'],
            'producto' => [' nullable', 'numeric'],
            'cantidad' => ['nullable', 'numeric'],
            'precio' => [' nullable', 'numeric'],
            'total' => [' nullable', 'numeric']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error en datos ingresados',
                'data' => ['error'=>$validator->errors()]
            ], 422);
        }
        try{
            $detalleTicket = DetalleTicket::find($id);
            if($detalleTicket==null){
                return response()->json([
                    'success' => false,
                    'message' => 'El detalleTicket con el id '.$id.' no existe',
                    'data' => null
                ], 409 );
            }
            $entradas = $this->rellenarDatosFaltantes($detalleTicket, $entradas);
            $detalleTicket->ticket=$entradas['ticket'];
            $detalleTicket->producto=$entradas['producto'];
            $detalleTicket->cantidad=$entradas['cantidad'];
            $detalleTicket->precio=$entradas['precio'];
            $detalleTicket->total=$entradas['total'];
            $detalleTicket->save();
            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['detalleTicket'=>$detalleTicket]
            ], 200);
        //----- Mecanismos anticaidas y reporte de errores -----
        }catch(\Illuminate\Database\QueryException $ex){ 
            return response()->json([
                'success' => false,
                'message' => "Error en la base de datos",
                'data' => ['error'=>$ex]
            ], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try{
            $detalleTicket = DetalleTicket::find($id);
            if($detalleTicket==null){
                return response()->json([
                    'success' => false,
                    'message' => 'El detalleTicket con el id '.$id.' no existe',
                    'data' => null
                ], 409 );
            }
            $detalleTicket->delete();
            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['detalleTicket'=>$detalleTicket]
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
     */
    private function rellenarDatosFaltantes($array, $entradas){
        if($array==null){
            if(!array_key_exists ("ticket" , $entradas)){
                $entradas['ticket'] = null;
            }
            if(!array_key_exists ("producto" , $entradas)){
                $entradas['producto'] = null;
            }
            if(!array_key_exists ("cantidad" , $entradas)){
                $entradas['cantidad'] = null;
            }
            if(!array_key_exists ("precio" , $entradas)){
                $entradas['precio'] = null;
            }
            if(!array_key_exists ("total" , $entradas)){
                $entradas['total'] = null;
            }
        }else{
            if(!array_key_exists ("ticket" , $entradas)){
                $entradas['ticket'] = $array['ticket'];
            }
            if(!array_key_exists ("producto" , $entradas)){
                $entradas['producto'] = $array['producto'];
            }
            if(!array_key_exists ("cantidad" , $entradas)){
                $entradas['cantidad'] = $array['cantidad'];
            }
            if(!array_key_exists ("precio" , $entradas)){
                $entradas['precio'] = $array['precio'];
            }
            if(!array_key_exists ("total" , $entradas)){
                $entradas['total'] = $array['total'];
            }
        }
        return $entradas;
    }
}
