<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Ticket;
use App\Models\Mensaje;
//use Auth;
//use Illuminate\Support\Facades\Auth as Auth1;

class AdministrativoController extends Controller
{

    public function getClientes()
    {
        return Cliente::orderBy('fecha_registro', 'DESC')->get();
    }
    public function getGraficaClientes(){

        $fecha_actual  = date("Y-m-01");
        $fecha_inicial = date("Y-m-01",strtotime($fecha_actual."- 12 Month"));

        $j=0;
        $meses=[];
        for($i=strtotime($fecha_inicial);$i<=strtotime($fecha_actual);$i=strtotime(date("Y-m-01",strtotime(date("Y-m-d",$i)."+1 Month")))){ $j++;
            $mes["Mes"]=date("Y-m-01",$i);
            $mes["Valor"]=rand(3900,5000);
            $meses[]=$mes;

        }


        return $meses;
    }
    public function getTickets(){
        return Ticket::orderBy('fecha', 'DESC')->withCount('mensajes')->get();
    }
    public function getDetalleTicket($id){
        return Ticket::where('id',$id)->get();
    }
    public function getMensajesTicket($id){
        return Mensaje::where('ticket_id',$id)->get();
    }
}
