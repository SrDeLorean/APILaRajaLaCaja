<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Models\DetalleTicket;
use App\Models\Ticket;
use App\Models\Producto;

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
        $entradas = $request->only('ticket', 'producto', 'cantidad', 'precioCompra', 'precioVenta');
        $validator = Validator::make($entradas, [
            'ticket' => ['numeric'],
            'producto' => ['numeric'],
            'cantidad' => ['numeric'],
            'precioCompra' => ['numeric'],
            'precioVenta' => ['numeric']
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
            $detalleTicket->precioCompra=$entradas['precioCompra'];
            $detalleTicket->precioVenta=$entradas['precioVenta'];
            
            $ticket = Ticket::find($entradas['ticket']);
            $ticket->cantidadProducto = $ticket->cantidadProducto + $entradas['cantidad'];
            $ticket->precioCompra = $ticket->precioCompra + $entradas['precioCompra']*$entradas['cantidad'];
            $ticket->precioVenta = $ticket->precioVenta + $entradas['precioVenta']*$entradas['cantidad'];

            $producto = Producto::find($entradas['producto']);
            $producto->cantidad = $producto->cantidad - $entradas['cantidad'];
            $detalleTicket->save();
            $ticket->save();
            $producto->save();
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
        $entradas = $request->only('ticket', 'producto', 'cantidad', 'precioCompra', 'precioVenta');
        $validator = Validator::make($entradas, [
            'ticket' => ['nullable', 'numeric'],
            'producto' => [' nullable', 'numeric'],
            'cantidad' => ['nullable', 'numeric'],
            'precioCompra' => [' nullable', 'numeric'],
            'precioVenta' => [' nullable', 'numeric']
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

            $ticket = Ticket::find($entradas['ticket']);
            $ticket->cantidadProducto = $ticket->cantidadProducto + $entradas['cantidad'] - $detalleTicket->cantidad;
            $ticket->precioCompra = $ticket->precioCompra - ($detalleTicket->precioCompra*$detalleTicket->cantidad) + ($entradas['precioCompra']*$entradas['cantidad']);
            $ticket->precioVenta = $ticket->precioVenta - ($detalleTicket->precioVenta*$detalleTicket->cantida) + $entradas['precioVenta']*$entradas['cantidad'];

            $producto = Producto::find($entradas['producto']);
            $producto->cantidad = $producto->cantidad - $entradas['cantidad'] + $detalleTicket->cantidad;

            $detalleTicket->ticket=$entradas['ticket'];
            $detalleTicket->producto=$entradas['producto'];
            $detalleTicket->cantidad=$entradas['cantidad'];
            $detalleTicket->precioCompra=$entradas['precioCompra'];
            $detalleTicket->precioVenta=$entradas['precioVenta'];
            $detalleTicket->save();
            $ticket->save();
            $producto->save();
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
            $ticket = Ticket::find($detalleTicket->ticket);
            $ticket->cantidadProducto = $ticket->cantidadProducto - $detalleTicket->cantidad;
            $ticket->precioCompra = $ticket->precioCompra - ($detalleTicket->precioCompra*$detalleTicket->cantidad);
            $ticket->precioVenta = $ticket->precioVenta - ($detalleTicket->precioVenta*$detalleTicket->cantidad);

            $producto = Producto::find($detalleTicket->producto);
            $producto->cantidad = $producto->cantidad + $detalleTicket->cantidad;

            if($detalleTicket==null){
                return response()->json([
                    'success' => false,
                    'message' => 'El detalleTicket con el id '.$id.' no existe',
                    'data' => null
                ], 409 );
            }
            $detalleTicket->delete();
            $ticket->save();
            $producto->save();
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
            if(!array_key_exists ("precioCompra" , $entradas)){
                $entradas['precioCompra'] = null;
            }
            if(!array_key_exists ("precioVenta" , $entradas)){
                $entradas['precioVenta'] = null;
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
            if(!array_key_exists ("precioCompra" , $entradas)){
                $entradas['precioCompra'] = $array['precioCompra'];
            }
            if(!array_key_exists ("precioVenta" , $entradas)){
                $entradas['precioVenta'] = $array['precioVenta'];
            }
        }
        return $entradas;
    }
}
