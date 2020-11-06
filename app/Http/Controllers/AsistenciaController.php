<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\FuncionariosController as Funcionario;
use App\Http\Controllers\DiariosController as Diarios;
use App\Http\Controllers\LlegadasTardeController as Llegadas;
use App\Models\Correo;
use App\Models\Marcacion;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Exception\HttpException;

require_once $path = base_path('vendor/pear/http_request2/HTTP/Request2.php');
date_default_timezone_set('America/Bogota');


class AsistenciaController extends Controller
{
    public function validar(){
        $dias = array(
            0=> "Domingo",
            1=> "Lunes",
            2=> "Martes",
            3=> "Miercoles",
            4=> "Jueves",
            5=> "Viernes",
            6=> "Sabado"
        );

        $imgBase64 = request()->imagen;
        $png_url = time().".png";
        if(!is_dir(storage_path().'/temporales/')){
            File::makeDirectory(storage_path().'/temporales/', $mode = 0777, true, true);
        }
        $path = storage_path().'/temporales/' . $png_url;
        Image::make(file_get_contents($imgBase64))->save($path);


        $ocpApimSubscriptionKey = '1f2a8e35f210434bb655212545802b5b';
        $azure_grupo = 'personalclinica2020';
        $uriBase = 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0';
        $imageUrl = str_replace("/home/geneticapp/","https://",storage_path()).'/temporales/' . $png_url;
        //$imageUrl ='https://app.geneticapp.co/back/storage/tenantfd91ae10e8ce27d51b5401655bd53c53/temporales/' . $png_url;

        $request2 = new \Http_Request2($uriBase . '/detect');
        $url = $request2->getUrl();

        $headers = array(
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $ocpApimSubscriptionKey
        );
        $request2->setHeader($headers);
        $parameters = array(
            'returnFaceId' => 'true',
            'returnFaceLandmarks' => 'false',
            'returnFaceAttributes' => '',
            'recognitionModel' => 'recognition_02',
            'detectionModel' => 'detection_02'
        );
        $url->setQueryVariables($parameters);

        $request2->setMethod(\HTTP_Request2::METHOD_POST);
        $body = json_encode(array('url' => $imageUrl));

        $request2->setBody($body);

        $face_id='';
        try{
            $response = $request2->send();
            $resp=$response->getBody();
            $resp=json_decode($resp);

            if(is_array($resp)&&count($resp)>0){
                $face_id=$resp[0]->faceId;
            }else{
                Marcacion::create([
                        'tipo'=>'error',
                        'detalles'=>'Error conectando al Servidor de rostros',
                        'fecha'=>date("Y-m-d H:i:s")
                ]);
                $error = array(
                    'title' => 'Opps!',
                    'text' => 'Error conectando al Servidor de rostros, por favor intente en unos segundos o ubique su rostro frente a la cámara',
                    'type' => 'error'
                );
                return $error;
            }
        }catch (HttpException $ex){
            Marcacion::create([
                'tipo'=>'error',
                'detalles'=>'Error de Servidor: '.$ex,
                'fecha'=>date("Y-m-d H:i:s")
            ]);
            $error = array(
                'title' => 'Opps!',
                'text' => 'Error de Servidor: '.$ex,
                'type' => 'error'
            );
            return $error;
        }

        if($face_id!=""){
            /* INICIO DE IDENTIFICACIÓN DE ROSTRO */
            $request2 = new \Http_Request2($uriBase . '/identify');
            $url = $request2->getUrl();
            $headers = array(
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $ocpApimSubscriptionKey,
            );
            $request2->setHeader($headers);
            $parameters = array(
            );
            $url->setQueryVariables($parameters);
            $request2->setMethod(\HTTP_Request2::METHOD_POST);
            $body = array(
                'personGroupId' => $azure_grupo,
                'faceIds' => [
                    $face_id
                ],
                "confidenceThreshold" => 0.6,
                "maxNumOfCandidatesReturned"=>1
            );
            $request2->setBody(json_encode($body));

            try{
                $response = $request2->send();
                $resp=$response->getBody();
                $resp=json_decode($resp);
                if(is_array($resp)&&count($resp)>0){
                    $candidatos=$resp[0]->candidates;

                    if(count($candidatos)>0){
                        $candidato=$candidatos[0]->personId;
                        if($candidato!=''){
                            $hactual=date("H:i:s");
                            $hoy=date('Y-m-d');
                            $ayer=date("Y-m-d", strtotime(date("Y-m-d").' - 1 day'));

                            $funcionario = Funcionario::funcionario_turno($candidato,$dias[date("w",strtotime($hoy))],$hoy,$ayer);

                            if($funcionario){
                                $tipo_turno = $funcionario->tipo_turno;
                                switch ($tipo_turno) {
                                    case 'Fijo':
                                        return $this->ValidaTurnoFijo($funcionario,$hoy,$hactual);
                                        break;
                                    case 'Rotativo':
                                        return $this->ValidaTurnoRotativo($funcionario,$ayer,$hactual);
                                        break;
                                    case 'Libre':
                                        return $this->ValidaTurnoLibre($funcionario,$hoy,$hactual);
                                        break;
                                }

                            }else{
                                Marcacion::create([
                                    'tipo'=>'error',
                                    'detalles'=>'Se identifica un rostro pero al parecer no esta activo en el Sistema',
                                    'fecha'=>date("Y-m-d H:i:s")
                                ]);
                                $error = array(
                                    'title' => 'Error!',
                                    'html' => 'Identificamos un rostro pero al parecer no esta activo en el Sistemaa',
                                    'type' => 'error'
                                );
                                return $error;
                            }
                        }
                    }else{
                        Marcacion::create([
                            'tipo'=>'error',
                            'detalles'=>'No se logra identificar el rosto',
                            'fecha'=>date("Y-m-d H:i:s")
                        ]);
                        $error = array(
                            'title' => 'Acceso Denegado!',
                            'html' => 'Su rostro no se encuentra en nuestros registros',
                            'type' => 'error'
                        );
                        return $error;
                    }
                }else{
                    Marcacion::create([
                        'tipo'=>'error',
                        'detalles'=>'No se logra identificar el rosto',
                        'fecha'=>date("Y-m-d H:i:s")
                    ]);
                    $error = array(
                        'title' => 'Acceso Denegado!',
                        'html' => 'Su rostro no se encuentra en nuestros registros',
                        'type' => 'error'
                    );
                    return $error;
                }
            }catch (HttpException $ex){
                Marcacion::create([
                    'tipo'=>'error',
                    'detalles'=>'Error de Servidor: '.$ex,
                    'fecha'=>date("Y-m-d H:i:s")
                ]);
                $error = array(
                    'title' => 'Opps!',
                    'html' => 'Error de Servidor: '.$ex,
                    'type' => 'error'
                );
                return $error;
            }
        }
    }
    private function ValidaTurnoFijo($func,$hoy,$hactual){
        $ruta=str_replace("/home/geneticapp/","https://",storage_path()).'/';
        /** VALIDACION DE TURNO FIJO ASIGNADO AL FUNCIONARIO */
        //var_dump($func->diariosTurnoFijo);
        if(count($func->diariosTurnoFijo)==0){
            /** VALIDO LA ENTRADA */
            if(isset($func->turnoFijo->horariosTurnoFijo[0])){
                $hora=$func->turnoFijo->horariosTurnoFijo[0];

                $tipo_dia= date("w",strtotime($hoy));

                if($hactual<='12:00:00'&&($tipo_dia!=6&&$tipo_dia!=0)){
                    $diferencia=$this->RestarHoras($hactual,$hora->hora_inicio_uno);
                    $h_inicio=$hora->hora_inicio_uno;
                }elseif($hactual<='12:00:00'&&($tipo_dia==6||$tipo_dia==0)){
                    $diferencia=$this->RestarHoras($hactual,$hora->hora_inicio_uno);
                    $h_inicio=$hora->hora_inicio_uno;
                }else{
                    $diferencia=$this->RestarHoras($hactual,$hora->hora_inicio_dos);
                    $h_inicio=$hora->hora_inicio_dos;
                }
                $dife=$diferencia;
                $diferencia=explode(":",$diferencia);

                $sig=1;
                if(strpos($diferencia[0],"-")!==false){
                    $sig=-1;
                    $diferencia[0]=str_replace("-", "", $diferencia[0]);
                }
                $diff_a=$diferencia[0]*60;
                $diff_b=($diff_a+$diferencia[1])*$sig;

                $diff=(($diferencia[0]*60*60)+($diferencia[1]*60)+($diferencia[2]))*$sig;
                $tol_ent=($hora->Tolerancia_Entrada*60);

                /** GUARDO LOS DATOS DEL HORARIO DEL DIA */
                $datos= array(
                    'funcionario_id' => $func->id,
                    'fecha' => $hoy,
                    'turno_fijo_id' => $hora->turno_fijo_id,
                    'hora_entrada_uno' => $hactual,
                    'img_uno' => '',
                );
                Diarios::guardarDiarioTurnoFijo($datos);
                /** FIN DEL GUARDAR */

                if($diff<=$tol_ent){
                    $obj = new \stdClass();
                    $obj->nombre = $func->nombres." ".$func->apellidos;
                    $obj->imagen = $ruta.'app/'.$func->image;
                    $obj->tipo = 'ingreso';
                    $obj->hora = date("d/m/Y H:i:s",strtotime($hoy." ".$hactual));
                    $obj->ubicacion = 'entrada';
                    $obj->destino = $func->email;
            
                    Mail::to($func->email)->send(new Correo($obj));

                    $respuesta = array(
                        'title' => 'Acceso Autorizado',
                        'html' => "<img src='".$ruta.$func->image."' class='img-thumbnail rounded-circle img-fluid' style='max-width:140px;'  /><br><strong>Bienvenido, Hoy ha llegado temprano</strong><br><strong>".$func->nombres." ".$func->apellidos."</strong><br>".date("d/m/Y H:i:s",strtotime($hoy." ".$hactual)),
                        'type' => 'success'
                    );
                    return $respuesta;
                }else{
                    $obj = new \stdClass();
                    $obj->nombre = $func->nombres." ".$func->apellidos;
                    $obj->imagen = $ruta.'app/'.$func->image;
                    $obj->tipo = 'ingreso';
                    $obj->hora = date("d/m/Y H:i:s",strtotime($hoy." ".$hactual));
                    $obj->ubicacion = 'entrada';
                    $obj->destino = $func->email;
            
                    Mail::to($func->email)->send(new Correo($obj));
                    
                    /** GUARDO LA LLEGADA TARDE */
                    $datos_llegada = array(
                        'funcionario_id' => $func->id,
                        'fecha' => $hoy,
                        'tiempo' => $diff,
                        'entrada_real' => $hactual,
                        'entrada_turno' => $h_inicio
                    );

                    Llegadas::guardarLlegadaTarde($datos_llegada);
                    /** FIN GUARDAR LLEGADA */

                    $lleg='Hoy ha Llegado tarde';
                    $respuesta = array(
                        'title' => 'Acceso Autorizado',
                        'html' => "<img src='".$ruta.$func->image."' class='img-thumbnail rounded-circle img-fluid' style='max-width:140px;'  /><br><strong>Bienvenido</strong><br><strong>".$func->nombres." ".$func->apellidos."</strong><br><strong style='color:red;'>".$lleg."</strong><br>".date("d/m/Y H:i:s",strtotime($hoy." ".$hactual)),
                        'type' => 'success'
                    );
                    return $respuesta;
                }

            }else{
                /** NO TIENE UN TURNO/HORARIO PARA ESE DIA */
                $error = array(
                    'title' => 'Acceso Denegado',
                    'html' => "<img src='".$ruta.$func->image."' class='img-thumbnail rounded-circle img-fluid' style='max-width:140px;'  /><br><strong>Hoy no Tiene un Turno Asignado</strong>",
                    'type' => 'error'
                );
                return $error;
            }

        }else{
            $diario=$func->diariosTurnoFijo[0];
            if($diario->hora_salida_uno=='00:00:00')
            {   /** VALIDO LA SALIDA */
                $datos= array(
                    'hora_salida_uno' => $hactual,
                    'img_dos' => '',
                );
                Diarios::actualizaDiarioTurnoFijo($datos,$diario->id);
                $respuesta = array(
                    'title' => 'Hasta Luego',
                    'html' => "<img src='".$ruta.$func->image."' class='img-thumbnail rounded-circle img-fluid' style='max-width:140px;'  /><br><strong>Hasta Luego</strong><br><strong>".$func->nombres." ".$func->apellidos."</strong><br>".date("d/m/Y H:i:s",strtotime($hoy." ".$hactual)),
                    'type' => 'success'
                );
                return $respuesta;
            }elseif($diario->hora_entrada_dos=='00:00:00')
            {
                $hora=$func->turnoFijo->horariosTurnoFijo[0];
                $datos= array(
                    'hora_entrada_dos' => $hactual,
                    'img_tres' => '',
                );
                Diarios::actualizaDiarioTurnoFijo($datos,$diario->id);

                $diferencia=$this->RestarHoras($hactual,$hora->hora_inicio_dos);
                $diferencia=explode(":",$diferencia);
                $sig=1;
                if(strpos($diferencia[0],"-")!==false){
                    $sig=-1;
                    $diferencia[0]=str_replace("-", "", $diferencia[0]);
                }
                $diff=(($diferencia[0]*60*60)+($diferencia[1]*60)+($diferencia[2]))*$sig;
                $tol_ent=($hora->Tolerancia_Entrada*60);

                if($diff>=$tol_ent){
                    $datos_llegada = array(
                        'funcionario_id' => $func->id,
                        'fecha' => $hoy,
                        'tiempo' => $diff,
                        'entrada_real' => $hactual,
                        'entrada_turno' => $hora->hora_inicio_dos
                    );

                    Llegadas::guardarLlegadaTarde($datos_llegada);
                    /** FIN GUARDAR LLEGADA */

                    $lleg='Hoy ha Llegado tarde';
                    $respuesta = array(
                        'title' => 'Bienvenido de Nuevo',
                        'html' => "<img src='".$ruta.$func->image."' class='img-thumbnail rounded-circle img-fluid' style='max-width:140px;'  /><br><strong>Bienvenido</strong><br><strong>".$func->nombres." ".$func->apellidos."</strong><br><strong style='color:red;'>".$lleg."</strong><br>".date("d/m/Y H:i:s",strtotime($hoy." ".$hactual)),
                        'type' => 'success'
                    );
                    return $respuesta;
                }else{
                    $respuesta = array(
                        'title' => 'Bienvenido de Nuevo',
                        'html' => "<img src='".$ruta.$func->image."' class='img-thumbnail rounded-circle img-fluid' style='max-width:140px;'  /><br><strong>Bienvenido de Nuevo</strong><br><strong>".$func->nombres." ".$func->apellidos."</strong><br>".date("d/m/Y H:i:s",strtotime($hoy." ".$hactual)),
                        'type' => 'success'
                    );
                    return $respuesta;
                }
            }elseif($diario->hora_salida_dos=='00:00:00'){
                $datos= array(
                    'hora_salida_dos' => $hactual,
                    'img_cuatro' => '',
                );
                Diarios::actualizaDiarioTurnoFijo($datos,$diario->id);
                $respuesta = array(
                    'title' => 'Hasta Mañana',
                    'html' => "<img src='".$ruta.$func->image."' class='img-thumbnail rounded-circle img-fluid' style='max-width:140px;'  /><br><strong>Hasta Mañana</strong><br><strong>".$func->nombres." ".$func->apellidos."</strong><br>".date("d/m/Y H:i:s",strtotime($hoy." ".$hactual)),
                    'type' => 'success'
                );
                return $respuesta;
            }else{
                $respuesta = array(
                    'title' => 'Ya has reportado Turno',
                    'html' => "<img src='".$ruta.$func->image."' class='img-thumbnail rounded-circle img-fluid' style='max-width:140px;'  /><br><strong>Ya reportaste entrada y salida el día de hoy</strong><br><strong>".$func->nombres." ".$func->apellidos."</strong>",
                    'type' => 'warning'
                );
                return $respuesta;
            }
        }
    }
    private function ValidaTurnoRotativo($func){
        return "Turno Rotativo";
    }
    private function ValidaTurnoLibre($func){
        return "Turno Libre";
    }
    private function RestarHoras($horaini,$horafin)
    {
        $horai=substr($horaini,0,2);
        $mini=substr($horaini,3,2);
        $segi=substr($horaini,6,2);

        $horaf=substr($horafin,0,2);
        $minf=substr($horafin,3,2);
        $segf=substr($horafin,6,2);

        $ini=((($horai*60)*60)+($mini*60)+$segi);
        $fin=((($horaf*60)*60)+($minf*60)+$segf);

        $dif=$fin-$ini;
        $band=0;
        if($dif<0){
            $dif=$dif*(-1);
            $band=1;
        }

        $difh=floor($dif/3600);
        $difm=floor(($dif-($difh*3600))/60);
        $difs=$dif-($difm*60)-($difh*3600);
        if($band==0){
            return "-".date("H:i:s",mktime($difh,$difm,$difs));
        }else{
            return date("H:i:s",mktime($difh,$difm,$difs));
        }

    }
}
