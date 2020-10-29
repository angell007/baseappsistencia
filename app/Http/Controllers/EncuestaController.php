<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Encuesta;
use App\Models\EncuestaPregunta;
use App\Models\EncuestaFuncionario;
use App\Models\EncuestaFuncionarioRespuesta;
use App\Models\EncuestaPreguntaOpcion;
//use Auth;
//use Illuminate\Support\Facades\Auth as Auth1;

class EncuestaController extends Controller
{

    public function getEncuestas()
    {
        return Encuesta::orderBy('id', 'DESC')->get();
    }

    public function store()
    {

        $atributos = request()->validate([
            'nombre' => 'required',
            'tipo_aplicacion' => 'required',
            'frecuencia_aplicacion' => 'required',
            'restrictiva' => 'required',
            'descripcion' => 'required',
            'Preguntas' => ''
        ]);
        // var_dump($atributos); exit;
        $preguntas = $atributos["Preguntas"];
        unset($atributos["Preguntas"]);

        $encuesta = Encuesta::create($atributos);

        foreach($preguntas as $pregunta){
            $pregunta["encuesta_id"]= $encuesta["id"];
            $opciones = $pregunta["opciones"];
            unset($pregunta["requerido"]);
            unset($pregunta["opciones"]);
            $preg = EncuestaPregunta::create($pregunta);
            if($pregunta["tipo_pregunta"]=='simple-dos'||$pregunta["tipo_pregunta"]=='multiple'){
                foreach($opciones as $op){
                    $op["encuesta_pregunta_id"]=$preg["id"];
                    EncuestaPreguntaOpcion::create($op);
                }
            }
        }

        return response()->json(['message' => 'Encuesta Creado correctamente']);
    }

    public function responder()
    {

        $atributos = request()->validate([
            'id' => 'required',
            'funcionario_id' => 'required',
            'preguntas' => ''
        ]);

        //var_dump($atributos); exit;
        $atributos["encuesta_id"]=$atributos["id"];
        $preguntas = $atributos["preguntas"];
        unset($atributos["preguntas"]);
        unset($atributos["id"]);

        $encuesta = EncuestaFuncionario::create($atributos);


        $novedad=false;
        foreach($preguntas as $pregunta){
            $registro["encuesta_funcionario_id"]= $encuesta["id"];
            $registro["encuesta_pregunta_id"]=$pregunta["id"];
            if(isset($pregunta["respuesta"])){
                if(is_array($pregunta["respuesta"])){
                    if(count($pregunta["respuesta"])>0){
                        if(isset($pregunta["respuesta"]["opcion"])){
                            $registro["respuesta"]=$pregunta["respuesta"]["opcion"];
                        }elseif(isset($pregunta["respuesta"][0]["opcion"])){
                            $res='';
                            foreach($pregunta["respuesta"] as $resp){
                                $res.=$resp["opcion"].",";
                            }
                            $registro["respuesta"]=trim($res,",");
                        }
                    }else{
                        $registro["respuesta"]="no";
                    }
                }else{
                    $registro["respuesta"]=$pregunta["respuesta"];
                }
            }else{
                $registro["respuesta"]="no";
            }

            if($pregunta["tipo_pregunta"]=='simple'&&$registro["respuesta"]=='si'){
                $novedad=true;
            }
            $preg = EncuestaFuncionarioRespuesta::create($registro);
        }


        return response()->json(['message' => 'Encuesta Creado correctamente','novedad'=>$novedad]);
    }

    public function destroy($id)
    {
        $encuesta = Encuesta::find($id);

        $atributos = [
            'estado' => 'Inactiva'
        ];

        $encuesta->update($atributos);

        return response()->json(['message' => 'Encuesta Inactivada correctamente']);
    }

    public function getDatosEncuesta($id)
    {
        $encuesta =  Encuesta::where('id', $id)->with('Preguntas.Opciones')->first();

        if (!$encuesta) {
            return response()->json(['message' => 'Encuesta No Encontrada'], 404);
        }

        return $encuesta;
    }
    public function validarEncuesta($id,$fun,$fecha)
    {
        $encuestas =  EncuestaFuncionario::where([
            ['encuesta_id', '=', $id],
            ['funcionario_id', '=', $fun]
        ])->whereDate('fecha',$fecha)->first();


        if (!$encuestas&&$fecha==date("Y-m-d")) {
            return response()->json(false);
        }

        return response()->json(true);
    }
    public function getRespuestas($id,$inicio,$fin){

        $encuestas =  EncuestaFuncionario::where([
            ['encuesta_id', '=', $id],
        ])->whereBetween('fecha',array($inicio.' 00:00:00',$fin.' 23:59:59'))->with('Funcionario')->get();


        return $encuestas;
    }
    public function getIndicadores($id,$inicio,$fin){
        $preguntas =  EncuestaPregunta::where([
            ['encuesta_id', '=', $id],
        ])->get();

        $resultado=[];
        foreach($preguntas as $preg){
            $res = DB::select('SELECT EFR.respuesta AS Respuesta, count(EFR.id) AS Cantidad
            FROM encuesta_funcionario_respuesta EFR
            INNER JOIN encuesta_funcionario EF ON EF.id = EFR.encuesta_funcionario_id
            WHERE DATE(EF.fecha) BETWEEN "'.$inicio.'" AND "'.$fin.'" AND  EFR.encuesta_pregunta_id='.$preg["id"].'
            GROUP BY EFR.respuesta
            ');


            $res2["Pregunta"]=$preg["pregunta"];
            $res2["Tipo"]=$preg["tipo_pregunta"];
            $res2["Respuestas"]=$res;
            $resultado[]=$res2;
        }

        return $resultado;
    }

}
