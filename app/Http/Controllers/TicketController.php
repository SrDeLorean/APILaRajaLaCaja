<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\TipoCaja;
use App\Models\Producto;
use App\Models\DetalleTicket;

use App\Models\Ticket;
use App\Models\TicketBrindi;
use App\Models\TicketCategoria;
use App\Models\TicketPasatiempo;
use App\Models\TicketPreferencia;
use App\Models\TicketMascota;

use App\Models\ProductoBrindi;
use App\Models\ProductoCategoria;
use App\Models\ProductoPasatiempo;
use App\Models\ProductoPreferencia;
use App\Models\ProductoMascota;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets =  Ticket::all();
        foreach($tickets as $ticket){
            $ticket->getTipoCaja->nombre;
            $ticket->getEstado->nombre;
            $categorias = TicketCategoria::where('ticket', $ticket->id)->get();
            foreach($categorias as $categoria){
                $categoria->getCategoria->nombre;
            }
            $ticket->categorias = $categorias;

            $brindis = TicketBrindi::where('ticket', $ticket->id)->get();
            foreach($brindis as $brindi){
                $brindi->getBrindi->nombre;
            }
            $ticket->brindis = $brindis;

            $pasatiempos = TicketPasatiempo::where('ticket', $ticket->id)->get();
            foreach($pasatiempos as $pasatiempo){
                $pasatiempo->getPasatiempo->nombre;
            }
            $ticket->pasatiempos = $pasatiempos;

            $preferencias = TicketPreferencia::where('ticket', $ticket->id)->get();
            foreach($preferencias as $preferencia){
                $preferencia->getPreferencia->nombre;
            }
            $ticket->preferencias = $preferencias;

            $mascotas = TicketMascota::where('ticket', $ticket->id)->get();
            foreach($mascotas as $mascota){
                $mascota->getMascota->nombre;
            }
            $ticket->mascotas = $mascotas;

            $detalleTickets = DetalleTicket::where('ticket', $ticket->id)->get();
            foreach($detalleTickets as $detalleTicket){
                $detalleTicket->getProducto;
            }
            $ticket->detalleTickets = $detalleTickets;
        }
        return response()->json([
            'success' => true,
            'message' => "done",
            'data' => ['tickets'=>$tickets]
        ], 200);
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
        $entradas = $request->only('email', 'receptor', 'emisor', 'nacimiento', 'color', 'excepcion' , 'pyme', 'foto' , 'mensaje' , 'entrega', 'region', 'comuna' , 'direccion' , 'telefono' , 'tipoPersona' , 'motivo' , 'estado', 'tipoCaja', 'categorias', 'pasatiempos', 'brindis', 'preferencias', 'mascotas' );
        $validator = Validator::make($entradas, [
            'email' => ['required', 'string'],
            'receptor' => [' required', 'string'],
            'emisor' => ['required', 'string'],
            'nacimiento' => [' required', 'date'],
            'color' => [' required', 'string'],
            'excepcion' => [' required', 'string'],
            'pyme' => [' required', 'boolean'],
            'foto' => [' nullable', 'string'],
            'mensaje' => [' required', 'string'],
            'entrega' => [' required', 'date'],
            'region' => [' required', 'string'],
            'comuna' => [' required', 'string'],
            'direccion' => [' required', 'string'],
            'telefono' => [' required', 'string'],
            'tipoPersona' => [' required', 'numeric'],
            'motivo' => [' required', 'numeric'],
            'estado' => [' required', 'numeric'],
            'tipoCaja' => ['required', 'numeric'],
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
            $ticket = new Ticket();
            $ticket->email=$entradas['email'];
            $ticket->receptor=$entradas['receptor'];
            $ticket->emisor=$entradas['emisor'];
            $ticket->nacimiento=$entradas['nacimiento'];
            $ticket->color=$entradas['color'];
            $ticket->excepcion=$entradas['excepcion'];
            $ticket->pyme=$entradas['pyme'];
            $ticket->foto=$entradas['foto'];
            $ticket->mensaje=$entradas['mensaje'];
            $ticket->entrega=$entradas['entrega'];
            $ticket->region=$entradas['region'];
            $ticket->comuna=$entradas['comuna'];
            $ticket->direccion=$entradas['direccion'];
            $ticket->telefono=$entradas['telefono'];
            $ticket->motivo=$entradas['motivo'];
            $ticket->estado=$entradas['estado'];
            $ticket->tipoCaja=$entradas['tipoCaja'];
            $ticket->cantidadProducto=0;
            $ticket->valor=0;
            $ticket->tipoPersona=$entradas['tipoPersona'];
            $ticket->save();

            $listaProductos= [];

            foreach($entradas['categorias'] as $categoria){
                $ticketCategoria = new TicketCategoria();
                $ticketCategoria->ticket = $ticket->id;
                $ticketCategoria->categoria = $categoria;
                $ticketCategoria->save();

                $productos = ProductoCategoria::where('categoria', $categoria)->get();
                if(count($productos)!=0){
                    foreach($productos as $producto){
                        if(array_key_exists($producto->producto, $listaProductos)){
                            $listaProductos[$producto->producto]= $listaProductos[$producto->producto]+1;
                        }else{
                            $listaProductos[$producto->producto]= 1;
                        }
                    }
                }
            }
            foreach($entradas['pasatiempos'] as $pasatiempo){
                $ticketPasatiempo = new TicketPasatiempo();
                $ticketPasatiempo->ticket = $ticket->id;
                $ticketPasatiempo->pasatiempo = $pasatiempo;
                $ticketPasatiempo->save();
                
                $productos = ProductoPasatiempo::where('pasatiempo', $pasatiempo)->get();
                if(count($productos)!=0){
                    foreach($productos as $producto){
                        if(array_key_exists($producto->producto, $listaProductos)){
                            $listaProductos[$producto->producto]= $listaProductos[$producto->producto]+1;
                        }else{
                            $listaProductos[$producto->producto]= 1;
                        }
                    }
                }
            }
            foreach($entradas['brindis'] as $brindi){
                $ticketBrindi = new TicketBrindi();
                $ticketBrindi->ticket = $ticket->id;
                $ticketBrindi->brindi = $brindi;
                $ticketBrindi->save();

                $productos = ProductoBrindi::where('brindi', $brindi)->get();
                if(count($productos)!=0){
                    foreach($productos as $producto){
                        if(array_key_exists($producto->producto, $listaProductos)){
                            $listaProductos[$producto->producto]= $listaProductos[$producto->producto]+1;
                        }else{
                            $listaProductos[$producto->producto]= 1;
                        }
                    }
                }
            }
            foreach($entradas['preferencias'] as $preferencia){
                $ticketPreferencia = new TicketPreferencia();
                $ticketPreferencia->ticket = $ticket->id;
                $ticketPreferencia->preferencia = $preferencia;
                $ticketPreferencia->save();

                $productos = ProductoPreferencia::where('preferencia', $preferencia)->get();
                if(count($productos)!=0){
                    foreach($productos as $producto){
                        if(array_key_exists($producto->producto, $listaProductos)){
                            $listaProductos[$producto->producto]= $listaProductos[$producto->producto]+1;
                        }else{
                            $listaProductos[$producto->producto]= 1;
                        }
                    }
                }
            }
            foreach($entradas['mascotas'] as $mascota){
                $ticketMascota = new TicketMascota();
                $ticketMascota->ticket = $ticket->id;
                $ticketMascota->mascota = $mascota;
                $ticketMascota->save();

                $productos = ProductoMascota::where('mascota', $mascota)->get();
                if(count($productos)!=0){
                    foreach($productos as $producto){
                        if(array_key_exists($producto->producto, $listaProductos)){
                            $listaProductos[$producto->producto]= $listaProductos[$producto->producto]+1;
                        }else{
                            $listaProductos[$producto->producto]= 1;
                        }
                    }
                }
            }
            arsort($listaProductos);
            $idProductos = array_keys($listaProductos);
            $caja = TipoCaja::where('id', $entradas['tipoCaja'])->get();
            $total = 0;
            $cantidad = 0;
            $cantidadTotal = 0;
            
            foreach($idProductos as $producto){
                $dato = Producto::where('id', $producto)->get();
                if($dato[0]->precioVenta>5000){
                    $cantidad = 1;
                }else{
                    $cantidad = rand(1, 3);
                }
                if($dato[0]->cantidad<=$cantidad){
                    if($dato[0]->cantidad<1){
                        $cantidad=0;
                    }else{
                        $dato[0]->cantidad=$cantidad;
                    }
                }
                if($cantidad!=0){
                    if($caja[0]->precio>=$total+$dato[0]->precioVenta*$cantidad){
                        $detalleTicket = new DetalleTicket();
                        $detalleTicket->ticket = $ticket->id;
                        $detalleTicket->producto = $dato[0]->id;
                        $detalleTicket->cantidad = $cantidad;
                        $detalleTicket->precio = $dato[0]->precioVenta;
                        $detalleTicket->total = $dato[0]->precioVenta*$cantidad;
                        $total = $total+$detalleTicket->total;
                        $cantidadTotal = $cantidadTotal+ $cantidad;
                        $detalleTicket->save();    
                        $dato[0]->cantidad=$dato[0]->cantidad-$cantidad;
                        $dato[0]->save();
                    }
                }
                
                
            }
            $ticket->valor= $total;
            $ticket->cantidadProducto= $cantidadTotal;
            $ticket->save();
            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['ticket'=>$ticket,
                            '$listaProductos'=>$listaProductos,
                            '$idProductos'=>$idProductos,
                
                ]
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
        $tickets =  Ticket::where('id', $id)->get();
        if(count($tickets)==0){
            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['tickets'=> "fff"]
            ], 200);
        }
        $ticket = $tickets[0];
        $ticket->getTipoCaja->nombre;
        $ticket->getEstado->nombre;
        $categorias = TicketCategoria::where('ticket', $ticket->id)->get();
        foreach($categorias as $categoria){
            $categoria->getCategoria->nombre;
        }
        $ticket->categorias = $categorias;

        $brindis = TicketBrindi::where('ticket', $ticket->id)->get();
        foreach($brindis as $brindi){
            $brindi->getBrindi->nombre;
        }
        $ticket->brindis = $brindis;

        $pasatiempos = TicketPasatiempo::where('ticket', $ticket->id)->get();
        foreach($pasatiempos as $pasatiempo){
            $pasatiempo->getPasatiempo->nombre;
        }
        $ticket->pasatiempos = $pasatiempos;

        $preferencias = TicketPreferencia::where('ticket', $ticket->id)->get();
        foreach($preferencias as $preferencia){
            $preferencia->getPreferencia->nombre;
        }
        $ticket->preferencias = $preferencias;

        $mascotas = TicketMascota::where('ticket', $ticket->id)->get();
        foreach($mascotas as $mascota){
            $mascota->getMascota->nombre;
        }
        $ticket->mascotas = $mascotas;

        $detalleTickets = DetalleTicket::where('ticket', $ticket->id)->get();
        foreach($detalleTickets as $detalleTicket){
            $detalleTicket->getProducto;
        }
        $ticket->detalleTickets = $detalleTickets;
        
        return response()->json([
            'success' => true,
            'message' => "done",
            'data' => ['ticket'=>$ticket]
        ], 200);
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
        $entradas = $request->only('email', 'receptor', 'emisor', 'nacimiento', 'color', 'excepcion' , 'pyme', 'foto' , 'mensaje' , 'entrega' , 'region', 'comuna', 'direccion' , 'telefono' , 'tipoPersona' , 'motivo' , 'estado', 'tipo' , 'mascota');
        $validator = Validator::make($entradas, [
            'email' => ['nullable', 'string'],
            'receptor' => [' nullable', 'string'],
            'emisor' => ['nullable', 'string'],
            'nacimiento' => [' nullable', 'date'],
            'color' => [' nullable', 'string'],
            'excepcion' => [' nullable', 'string'],
            'pyme' => [' nullable', 'boolean'],
            'foto' => [' nullable', 'string'],
            'mensaje' => [' nullable', 'string'],
            'entrega' => [' nullable', 'date'],
            'region' => [' nullable', 'string'],
            'comuna' => [' nullable', 'string'],
            'direccion' => [' nullable', 'string'],
            'telefono' => [' nullable', 'string'],
            'tipoPersona' => [' nullable', 'numeric'],
            'motivo' => [' nullable', 'numeric'],
            'estado' => [' nullable', 'numeric'],
            'tipo' => ['nullable', 'numeric'],
            'mascota' => [' nullable', 'numeric'],
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
        try{
            $ticket = Ticket::find($id);
            if($ticket==null){
                return response()->json([
                    'success' => false,
                    'message' => 'El ticket con el id '.$id.' no existe',
                    'data' => null
                ], 409 );
            }
            $entradas = $this->rellenarDatosFaltantes($ticket, $entradas);
            $ticket->email=$entradas['email'];
            $ticket->receptor=$entradas['receptor'];
            $ticket->emisor=$entradas['emisor'];
            $ticket->nacimiento=$entradas['nacimiento'];
            $ticket->color=$entradas['color'];
            $ticket->excepcion=$entradas['excepcion'];
            $ticket->pyme=$entradas['pyme'];
            $ticket->foto=$entradas['foto'];
            $ticket->mensaje=$entradas['mensaje'];
            $ticket->entrega=$entradas['entrega'];
            $ticket->region=$entradas['region'];
            $ticket->comuna=$entradas['comuna'];
            $ticket->direccion=$entradas['direccion'];
            $ticket->telefono=$entradas['telefono'];
            $ticket->motivo=$entradas['motivo'];
            $ticket->estado=$entradas['estado'];
            $ticket->tipoCaja=$entradas['tipoCaja'];
            $ticket->mascota=$entradas['mascota'];
            $ticket->save();
            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['ticket'=>$ticket]
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
    public function destroy($id)
    {
        try{
            $ticket = Ticket::find($id);
            if($ticket==null){
                return response()->json([
                    'success' => false,
                    'message' => 'El ticket con el id '.$id.' no existe',
                    'data' => null
                ], 409 );
            }
            $ticket->delete();
            return response()->json([
                'success' => true,
                'message' => "done",
                'data' => ['ticket'=>$ticket]
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
            if(!array_key_exists ("email" , $entradas)){
                $entradas['email'] = null;
            }
            if(!array_key_exists ("receptor" , $entradas)){
                $entradas['receptor'] = null;
            }
            if(!array_key_exists ("emisor" , $entradas)){
                $entradas['emisor'] = null;
            }
            if(!array_key_exists ("nacimiento" , $entradas)){
                $entradas['nacimiento'] = null;
            }
            if(!array_key_exists ("color" , $entradas)){
                $entradas['color'] = null;
            }
            if(!array_key_exists ("excepcion" , $entradas)){
                $entradas['excepcion'] = null;
            }
            if(!array_key_exists ("pyme" , $entradas)){
                $entradas['pyme'] = null;
            }
            if(!array_key_exists ("foto" , $entradas)){
                $entradas['foto'] = null;
            }
            if(!array_key_exists ("mensaje" , $entradas)){
                $entradas['mensaje'] = null;
            }
            if(!array_key_exists ("entrega" , $entradas)){
                $entradas['entrega'] = null;
            }
            if(!array_key_exists ("direccion" , $entradas)){
                $entradas['direccion'] = null;
            }
            if(!array_key_exists ("telefono" , $entradas)){
                $entradas['telefono'] = null;
            }
            if(!array_key_exists ("tipoPersona" , $entradas)){
                $entradas['tipoPersona'] = null;
            }
            if(!array_key_exists ("motivo" , $entradas)){
                $entradas['motivo'] = null;
            }
            if(!array_key_exists ("estado" , $entradas)){
                $entradas['estado'] = null;
            }
            if(!array_key_exists ("tipo" , $entradas)){
                $entradas['tipo'] = null;
            }
            if(!array_key_exists ("mascota" , $entradas)){
                $entradas['mascota'] = null;
            }
        }else{
            if(!array_key_exists ("email" , $entradas)){
                $entradas['email'] = $array['email'];
            }
            if(!array_key_exists ("receptor" , $entradas)){
                $entradas['receptor'] = $array['receptor'];
            }
            if(!array_key_exists ("emisor" , $entradas)){
                $entradas['emisor'] = $array['emisor'];
            }
            if(!array_key_exists ("nacimiento" , $entradas)){
                $entradas['nacimiento'] = $array['nacimiento'];
            }
            if(!array_key_exists ("color" , $entradas)){
                $entradas['color'] = $array['color'];
            }
            if(!array_key_exists ("excepcion" , $entradas)){
                $entradas['excepcion'] = $array['excepcion'];
            }
            if(!array_key_exists ("pyme" , $entradas)){
                $entradas['pyme'] = $array['pyme'];
            }
            if(!array_key_exists ("foto" , $entradas)){
                $entradas['foto'] = $array['foto'];
            }
            if(!array_key_exists ("mensaje" , $entradas)){
                $entradas['mensaje'] = $array['mensaje'];
            }
            if(!array_key_exists ("entrega" , $entradas)){
                $entradas['entrega'] = $array['entrega'];
            }
            if(!array_key_exists ("direccion" , $entradas)){
                $entradas['direccion'] = $array['direccion'];
            }
            if(!array_key_exists ("telefono" , $entradas)){
                $entradas['telefono'] = $array['telefono'];
            }
            if(!array_key_exists ("tipoPersona" , $entradas)){
                $entradas['tipoPersona'] = $array['tipoPersona'];
            }
            if(!array_key_exists ("motivo" , $entradas)){
                $entradas['motivo'] = $array['motivo'];
            }
            if(!array_key_exists ("estado" , $entradas)){
                $entradas['estado'] = $array['estado'];
            }
            if(!array_key_exists ("tipo" , $entradas)){
                $entradas['tipo'] = $array['tipo'];
            }
            if(!array_key_exists ("mascota" , $entradas)){
                $entradas['mascota'] = $array['mascota'];
            }
        }
        return $entradas;
    }
}
