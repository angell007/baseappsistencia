<?php

namespace App\Http\Controllers;

use App\Funcionario;
use Illuminate\Validation\ValidationException;

require_once $path = base_path('vendor/pear/http_request2/HTTP/Request2.php');

class FuncionariosController extends Controller
{
    public $ocpApimSubscriptionKey = '1f2a8e35f210434bb655212545802b5b';
    public $azure_grupo = 'personalclinica2020';
    public $uriBase = 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0';

    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getDatos()
    {
        return Funcionario::with('dependencia.centroCosto')->with('cargo')->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $ruta = '';
        if (request()->hasFile('image')) {
            $imagen = request('image');
            $nombre = time() . '.' . $imagen->getClientOriginalName();
            $ruta = $imagen->storeAs('funcionarios', $nombre, 'public');
        }

        try {
            $atributos = request()->validate([
                'identidad' => 'required|min:3|max:10|unique:funcionario,identidad',
                'nombres' => 'required',
                'apellidos' => 'required',
                'liquidado' => 'required',
                'fecha_nacimiento' => 'required',
                'lugar_nacimiento' => '',
                'tipo_sangre' => 'required',
                'telefono' => 'numeric|nullable',
                'celular' => 'required|numeric',
                'email' => 'required|email|unique:funcionario,email',
                'direccion_residencia' => '',
                'estado_civil' => 'required',
                'grado_instruccion' => '',
                'titulo_estudio' => '',
                'talla_pantalon' => '',
                'tallas_botas' => '',
                'talla_bata' => '',
                'talla_camisa' => '',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                'salario' => 'required',
                'fecha_ingreso' => 'required',
                'fecha_retiro' => '',
                'numero_hijos' => 'required',
                'personId' => '',
                'persistedFaceId' => '',
                'fecha_retiro' => '',
                'sexo' => 'required',
                'jefe' => '',
                'eps_id' => 'required',
                'cesantias_id' => 'required',
                'pensiones_id' => 'required',
                'caja_compensacion_id' => 'required',
                'tipo_contrato_id' => 'required',
                'dependencia_id' => 'required',
                'cargo_id' => 'required',
                'jefe_id' => '',
                'tipo_turno' => 'required|string',
                'turno_fijo_id' => ''
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Han ocurrido errores!',
                'errors' => $e->errors()
            ], 422);
        }

        $atributos['image'] = $ruta;

        if($ruta!=''){
            //detectionModel detection_02


            /** CREA EL FUNCIONARIO EN MICROSOFT AZURE */
            $request = new \Http_Request2($this->uriBase.'/persongroups/'.$this->azure_grupo.'/persons');
            $url = $request->getUrl();
            $headers = array(
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->ocpApimSubscriptionKey,
            );
            $request->setHeader($headers);
            $parameters = array(
            );
            $body = array(
                "name"=>$atributos["nombres"]." ".$atributos["apellidos"],
                "userData"=>$atributos["identidad"]
            );
            $url->setQueryVariables($parameters);
            $request->setMethod(\HTTP_Request2::METHOD_POST);
            $request->setBody(json_encode($body));
            try{
                $response = $request->send();
                $resp=$response->getBody();
                $resp=json_decode($resp);
                $person_id=$resp->personId;

                $atributos["personId"]=$person_id;

            }catch (HttpException $ex){
                echo "error: ".$ex;
            }

            /** CREA LOS PUNTOS FACIALES PROPIOS DEL FUNCIONARIO */
            $ruta_guardada='https://app.geneticapp.co/back/storage/app/public/'.$ruta;
            //$ruta_guardada='https://app.geneticapp.co/back/storage/app/public/funcionarios/1591186701.foto1.jpg';

            $request = new \Http_Request2($this->uriBase.'/persongroups/'.$this->azure_grupo.'/persons/'.$person_id.'/persistedFaces');
            $url = $request->getUrl();

            $headers = array(
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->ocpApimSubscriptionKey,
            );

            $request->setHeader($headers);
            $parameters = array(
                "detectionModel"=>"detection_02"
            );
            $body=array(
                "url"=>$ruta_guardada
            );
            $url->setQueryVariables($parameters);
            $request->setMethod(\HTTP_Request2::METHOD_POST);
            $request->setBody(json_encode($body));
            try{
                $response = $request->send();
                $resp=$response->getBody();
                $resp=json_decode($resp);
                $persistedFaceId=$resp->persistedFaceId;

                $atributos["persistedFaceId"]=$persistedFaceId;

            }catch (HttpException $ex){
                echo $ex;
            }

            /** ENTRENA EL GRUPO PARA QUE IDENTIICQUE EL ROSTRO */

            $request = new \Http_Request2($this->uriBase.'/persongroups/'.$this->azure_grupo.'/train');
            $url = $request->getUrl();

            $headers = array(
                'Ocp-Apim-Subscription-Key' => $this->ocpApimSubscriptionKey,
            );
            $request->setHeader($headers);
            $parameters = array(

            );
            $url->setQueryVariables($parameters);
            $request->setMethod(\HTTP_Request2::METHOD_POST);
            $request->setBody("");
            try{
                $response = $request->send();
                echo $response->getBody();
            }catch (HttpException $ex){
                echo $ex;
            }

        }

        Funcionario::create($atributos);

        return response()->json(['message' => 'Funcionario creado correctamente'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($identidad)
    {
        $funcionario =  Funcionario::where('identidad', $identidad)->with('pensiones')->with('cajaCompensacion')->with('cesantias')->with('eps')->with('contrato')->with('dependencia.centroCosto')->with('cargo')->with('contactosEmergencia')->with('experienciasLaborales')->with('referenciasPersonales')->where('identidad', $identidad)->firstOrFail();

        if (!$funcionario) {
            return response()->json(['message' => 'Funcionario no encontrado'], 404);
        }

        return $funcionario;
    }

    public static function funcionario_turno($personId,$dia,$hoy,$ayer){

        $funcionario =  Funcionario::where('personId', $personId)->with(['diariosTurnoFijo' => function($query )use ($hoy){
                                                                            $query->where('fecha', '=', $hoy);
                                                                    }])->with(['turnoFijo.horariosTurnoFijo' => function($query )use ($dia){
                                                                            $query->where('dia', '=', $dia);
                                                                    }])->with(['diariosTurnoRotativo' => function($query )use ($ayer){
                                                                            $query->where('fecha', '=', $ayer);
                                                                    }])->with('turnoRotativo')->first();
        //var_dump($funcionario);
        if (!$funcionario) {
            return false;
        }
        return $funcionario;
    }
    /**
     * Update the specified resource in storage.
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $ruta='';
        if (request()->hasFile('image')) {
            $imagen = request('image');
            $nombre = time() . '.' . $imagen->getClientOriginalName();
            $ruta = $imagen->storeAs('funcionarios', $nombre, 'public');
        }

        $atributos = request()->validate([
            'identidad' => 'required|min:3|max:10|unique:funcionario,identidad,' . $funcionario->id,
            'nombres' => 'required',
            'apellidos' => 'required',
            'liquidado' => 'required',
            'fecha_nacimiento' => 'required',
            'lugar_nacimiento' => '',
            'tipo_sangre' => 'required',
            'telefono' => '',
            'celular' => 'required|numeric',
            'email' => 'required|email|unique:funcionario,email,' . $funcionario->id,
            'direccion_residencia' => '',
            'estado_civil' => 'required',
            'grado_instruccion' => '',
            'titulo_estudio' => '',
            'talla_pantalon' => '',
            'tallas_botas' => '',
            'talla_bata' => '',
            'talla_camisa' => '',
            'image' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'salario' => 'required',
            'fecha_ingreso' => 'required',
            'fecha_retiro' => '',
            'numero_hijos' => 'required',
            'personId' => '',
            'persistedFaceId' => '',
            'fecha_retiro' => '',
            'sexo' => 'required',
            'jefe' => '',
            'eps_id' => 'required',
            'cesantias_id' => 'required',
            'pensiones_id' => 'required',
            'caja_compensacion_id' => 'required',
            'tipo_contrato_id' => 'required',
            'dependencia_id' => 'required',
            'cargo_id' => 'required',
            'jefe_id' => '',
            'tipo_turno' => 'required|string',
            'turno_fijo_id' => ''
        ]);
        if($ruta!=''){
            $atributos['image'] = $ruta;
            /** SI LA PERSONA NO TIENE PERSON ID SE CREA EL REGISTRO EN MICROSOFT */
            if($atributos["personId"]=="0"){
                $request = new \Http_Request2($this->uriBase.'/persongroups/'.$this->azure_grupo.'/persons');
                $url = $request->getUrl();
                $headers = array(
                    'Content-Type' => 'application/json',
                    'Ocp-Apim-Subscription-Key' => $this->ocpApimSubscriptionKey,
                );
                $request->setHeader($headers);
                $parameters = array(
                );
                $body = array(
                    "name"=>$atributos["nombres"]." ".$atributos["apellidos"],
                    "userData"=>$atributos["identidad"]
                );
                $url->setQueryVariables($parameters);
                $request->setMethod(\HTTP_Request2::METHOD_POST);
                $request->setBody(json_encode($body));
                try{
                    $response = $request->send();
                    $resp=$response->getBody();
                    $resp=json_decode($resp);
                    $person_id=$resp->personId;

                    $atributos["personId"]=$person_id;

                }catch (HttpException $ex){
                    echo "error: ".$ex;
                }
            }
            /** VALIDA SI YA TIENE UN ROSTO LO ELIMINA PARA PODER CREAR EL NUEVO */
            if($atributos["persistedFaceId"]!="0"){
                $request = new \Http_Request2($this->uriBase.'/persongroups/'.$this->azure_grupo.'/persons/'.$atributos["personId"].'/persistedFaces/'.$atributos["persistedFaceId"]);
                $url = $request->getUrl();
                $headers = array(
                    'Ocp-Apim-Subscription-Key' => $this->ocpApimSubscriptionKey,
                );
                $request->setHeader($headers);
                $parameters = array(
                );
                $url->setQueryVariables($parameters);
                $request->setMethod(\HTTP_Request2::METHOD_DELETE);
                $request->setBody("");
                try{
                    $response = $request->send();
                    //echo $response->getBody();
                }catch (HttpException $ex){
                    echo $ex;
                }
            }

            /** CREA LOS PUNTOS FACIALES PROPIOS DEL FUNCIONARIO */
            $ruta_guardada='https://app.geneticapp.co/back/storage/app/public/'.$ruta;
            //$ruta_guardada='https://app.geneticapp.co/back/storage/app/public/funcionarios/1591186767.foto5.jpg';

            $request = new \Http_Request2($this->uriBase.'/persongroups/'.$this->azure_grupo.'/persons/'.$person_id.'/persistedFaces');
            $url = $request->getUrl();

            $headers = array(
                'Content-Type' => 'application/json',
                'Ocp-Apim-Subscription-Key' => $this->ocpApimSubscriptionKey,
            );

            $request->setHeader($headers);
            $parameters = array(
                "detectionModel"=>"detection_02"
            );
            $body=array(
                "url"=>$ruta_guardada
            );
            $url->setQueryVariables($parameters);
            $request->setMethod(\HTTP_Request2::METHOD_POST);
            $request->setBody(json_encode($body));
            try{
                $response = $request->send();
                $resp=$response->getBody();
                $resp=json_decode($resp);
                $persistedFaceId=$resp->persistedFaceId;

                $atributos["persistedFaceId"]=$persistedFaceId;

            }catch (HttpException $ex){
                echo $ex;
            }

            /** ENTRENA EL GRUPO PARA QUE IDENTIICQUE EL ROSTRO */

            $request = new \Http_Request2($this->uriBase.'/persongroups/'.$this->azure_grupo.'/train');
            $url = $request->getUrl();

            $headers = array(
                'Ocp-Apim-Subscription-Key' => $this->ocpApimSubscriptionKey,
            );
            $request->setHeader($headers);
            $parameters = array(

            );
            $url->setQueryVariables($parameters);
            $request->setMethod(\HTTP_Request2::METHOD_POST);
            $request->setBody("");
            try{
                $response = $request->send();
                echo $response->getBody();
            }catch (HttpException $ex){
                echo $ex;
            }

        }

        $funcionario->update($atributos);

        return response()->json(['message' => 'Datos del funcionario actualizado correctamente', 'imagen'=>$ruta]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
