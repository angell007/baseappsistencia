<template>
    <div v-if="mostrar">
    <div class="container" v-if="!encuesta_aplicada" >
        <div class="row" style="padding-top: 15px;background: #FFFFFF;padding-bottom: 15px;">
            <div class="col-6 text-center">
                <h2 style="margin-top:15px;">{{ empresa }}</h2>
            </div>
            <div class="col-6 text-center">
                <img alt="" src="/img/logo-cliente.png" class="logo-cliente">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h4 class="font-weight-bold text-warning" style="margin-top:25px;">Hola, {{funcionario}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="font-weight-bold text-primary" style="margin-top:25px;">{{encuesta.nombre}}</h3>
                <p>{{encuesta.descripcion}}</p>
                <div class="separator mb-5"></div>
            </div>
        </div>
        <form @submit.prevent="validarAntesDeEnviar">
        <div class="row mb-2" v-for="(pregunta, index) in encuesta.preguntas"
            :key="`${index}-pregunta`">
          <div class="col-12">
            <div class="card">
              <div class="card-title m-2">
                <h6 class="text-primary">{{pregunta.pregunta}}</h6>
              </div>
              <div class="card-body p-2" v-if="pregunta.tipo_pregunta=='simple'">
                  <div class="row">
                      <div class="col-6 text-center">
                        <input type="radio" value="si" v-validate="'required'" :name="`${index}-respuesta`" v-model="encuesta.preguntas[index].respuesta">
                        <label for="uno">Si</label>
                      </div>
                      <div class="col-6 text-center">
                        <input type="radio" value="no" v-validate="'required'" :name="`${index}-respuesta`" v-model="encuesta.preguntas[index].respuesta">
                        <label for="Dos">No</label>
                      </div>
                      <div class="col-12 text-center">
                          <small class="invalid" :v-if="errors.has('`${index}-respuesta`')">{{ errors.first(index+'-respuesta') ? errors.first(index+'-respuesta').replace(index+'-','') : '' }}</small>
                      </div>
                  </div>
              </div>
              <div class="card-body p-2" v-if="pregunta.tipo_pregunta=='simple-dos'">
                  <div class="row">
                      <div class="col-12 text-center">
                          <multiselect
                            :max-height="200"
                            :name="`${index}-respuesta`"
                            placeholder="Seleccione una opción"
                            selectLabel="Enter para seleccionar"
                            deselectLabel="Enter para remover"
                            v-validate="'required'"
                            data-vv-as="respuesta"
                            v-model="encuesta.preguntas[index].respuesta"
                            :options="encuesta.preguntas[index].opciones"
                            class="font-weight-bold"
                            label="opcion"
                            track-by="opcion"
                            >
                            <template slot="noOptions">La lista está vacía</template>
                            <template slot="noResult">No existen resultados!</template>
                            </multiselect>
                            <small class="invalid" :v-if="errors.has('`${index}-respuesta`')">{{ errors.first(index+'-respuesta') ? errors.first(index+'-respuesta').replace(index+'-','') : '' }}</small>
                      </div>
                  </div>
              </div>
              <div class="card-body p-2" v-if="pregunta.tipo_pregunta=='multiple'">
                  <div class="row">
                      <div class="col-12 text-center">
                          <multiselect
                            :multiple="true"
                            :max-height="200"
                            :name="`${index}-respuesta`"
                            placeholder="Seleccione una opción"
                            selectLabel="Enter para seleccionar"
                            deselectLabel="Enter para remover"
                            v-validate="''"
                            data-vv-as="respuesta"
                            v-model="encuesta.preguntas[index].respuesta"
                            :options="encuesta.preguntas[index].opciones"
                            class="font-weight-bold"
                            label="opcion"
                            track-by="opcion"
                            :hide-selected="true"

                            >
                            <template slot="noOptions">La lista está vacía</template>
                            <template slot="noResult">No existen resultados!</template>
                            </multiselect>
                            <small class="invalid" :v-if="errors.has('`${index}-respuesta`')">{{ errors.first(index+'-respuesta') ? errors.first(index+'-respuesta').replace(index+'-','') : '' }}</small>
                      </div>
                  </div>
              </div>
              <div class="card-body p-2" v-if="pregunta.tipo_pregunta=='respuesta-corta'">
                  <div class="row">
                      <div class="col-12 text-center">
                            <input
                                type="text"
                                class="form-control custom-control"
                                :name="`${index}-respuesta`"
                                v-validate="'required|min:3'"
                                data-vv-as="respuesta"
                                placeholder="Respuesta Corta"
                                v-model="encuesta.preguntas[index].respuesta"
                            >
                            <small class="invalid" :v-if="errors.has('`${index}-respuesta`')">{{ errors.first(index+'-respuesta') ? errors.first(index+'-respuesta').replace(index+'-','') : '' }}</small>
                      </div>
                  </div>
              </div>
              <div class="card-body p-2" v-if="pregunta.tipo_pregunta=='respuesta-larga'">
                  <div class="row">
                      <div class="col-12 text-center">
                            <textarea
                                type="text"
                                class="form-control"
                                :name="`${index}-respuesta`"
                                v-validate="'required|min:10'"
                                data-vv-as="respuesta"
                                placeholder="Respuesta Larga"
                                v-model="encuesta.preguntas[index].respuesta"
                                rows="3"
                            ></textarea>
                            <small class="invalid" :v-if="errors.has('`${index}-respuesta`')">{{ errors.first(index+'-respuesta') ? errors.first(index+'-respuesta').replace(index+'-','') : '' }}</small>
                      </div>
                  </div>
              </div>


            </div>
          </div>
        </div>
        <div  class="row mb-2">
            <div class="col-12">
                <small class="invalid" :v-if="errors.has('terminos')">{{ errors.first('terminos') ? 'Debe Aceptar los Términos y Condiciones' : '' }}</small>
                 <p><input type="checkbox" v-validate="'required'" checked name="terminos" value="acepto" v-model="encuesta.acepto_terminos" /> Yo {{ funcionario }} identificado con cédula de ciudadanía {{ funcionario_identidad }} {{ encuesta.terminos }}</p>
            </div>
        </div>


        <div class="form-group " style="margin-top:20px;">
            <button type="submit" class="btn btn-secondary raised btn-sm btn-block">Guardar</button>
          </div>
        </form>

    </div>
     <div class="container" v-else >
         <div class="row" style="padding-top: 15px;background: #FFFFFF;padding-bottom: 15px;">
            <div class="col-6 text-center">
                <h2 style="margin-top:15px;">{{ empresa }}</h2>
            </div>
            <div class="col-6 text-center">
                <img alt="" src="/img/logo-cliente.png" class="logo-cliente">
            </div>
        </div>
        <div class="row mt-4 mb-2">
          <div class="col-12" v-if="error">
            <div class="card">
              <div class="card-title m-2">
                <h3 class="text-primary text-center">Error del Documento</h3>
              </div>
              <div class="card-body p-2 text-center" >
                  <img alt="" src="/img/robot.jpg" >
                  <h5>La encuesta a la que estás intentando acceder ya fué realizada, o está sin vigencia; por favor contacta al departamento de <strong>Recursos Humanos</strong> de tu compañía</h5>
              </div>
            </div>
          </div>
          <div class="col-12" v-if="!error">
            <div class="card">
              <div class="card-title m-2">
                <h3 class="text-primary text-center">Gracias por Diligenciar la Encuesta</h3>
              </div>
              <div class="card-body p-2 text-center" v-if="novedad" >
                  <img alt="" src="/img/peligro.png" >
                  <h5>Alguna de las respuestas suministradas puede significar algún <strong>riesgo</strong> para la salud tuya o tus compañeros, espera en los próximos minutos la comunicación del departamento <strong>Recursos Humanos</strong> para autorizar tu ingreso a las instalaciones o las medidas pertinentes.</h5>
                  <br>
                  <img alt="" src="/img/prevencion-covid.png" >
                  <h5>Recuerda Lavarte las manos con frecuencia, usar el tapabocas desde que sales de casa y mantener distancia social de más de 1 metro.</h5>
              </div>
              <div class="card-body p-2 text-center" v-else >
                  <img alt="" src="/img/ok.png" >
                  <h5>Gracias por cumplir los <strong>Protocolos de Bioseguridad</strong> de nuestra compañía, te esperamos en nuestras instalaciones para que sigas dando tu mejor esfuerzo para que juntos salgamos adelante.</h5>
                  <br>
                  <img alt="" src="/img/prevencion-covid.png" >
                  <h5>Recuerda Lavarte las manos con frecuencia, usar el tapabocas desde que sales de casa y mantener distancia social de más de 1 metro.</h5>
              </div>
            </div>
          </div>
        </div>

     </div>
     </div>
</template>

<script>
export default {
    data() {
        return {
            funcionario: '',
            encuesta: '',
            empresa:'',
            funcionario_identidad: '',
            funcionario_id: '',
            encuesta_id : '',
            encuesta_aplicada : false,
            fecha : '',
            mostrar:false,
            error:true,
            novedad:false
        }
    },
    created() {
        //
        var id =    atob(this.$route.params.id);
        var dos =   id.split(',');
        this.funcionario_identidad=dos[1];
        this.encuesta_id=dos[0];
        this.fecha = dos[2];
        this.obtenerDatosEmpresa();
        this.obtenerFuncionario(this.funcionario_identidad);
        this.obtenerEncuesta(this.encuesta_id);

    },
    methods: {
        obtenerFuncionario(identidad) {
            axios.get(`/api/${localStorage.getItem('tenant')}/funcionarios/${identidad}/mostrar`).then(datos => {
                this.funcionario = datos.data.nombres+" "+datos.data.apellidos;
                this.funcionario_id = datos.data.id;
                this.validarEncuesta();
            })
        },

        obtenerDatosEmpresa() {
            axios.get(`/api/${localStorage.getItem('tenant')}/general/empresa/global`).then(datos => {
                this.empresa=datos.data.razon_social;
            })
        },
        obtenerEncuesta(id){
            axios.get(`/api/${localStorage.getItem('tenant')}/encuestas/${id}/mostrar`).then(datos => {
                this.encuesta = datos.data;
            })
        },
        validarEncuesta(){
            axios.get(`/api/${localStorage.getItem('tenant')}/encuestas/${this.encuesta_id}/${this.funcionario_id}/${this.fecha}/validar`).then(datos => {
                this.encuesta_aplicada = datos.data;
                this.mostrar=true;
            })
        },
        async validarAntesDeEnviar() {
            let validado = await this.$validator.validateAll()
            if (validado) {
                this.GuardarEncuesta()
                return
            }
            this.$swal.fire(
                'Error!',
                'Debe corregir los errores antes de enviar',
                'error'
            )
        },
        GuardarEncuesta(){
            this.encuesta["funcionario_id"]=this.funcionario_id;
      axios
        .post(`/api/${localStorage.getItem('tenant')}/encuestas/responder`,  this.encuesta)
        .then(respuesta => {
          this.$swal.fire('Correcto', respuesta.data.message, 'success')
          this.encuesta_aplicada=true;
          this.error=false;
          this.novedad = respuesta.data.novedad;
          //this.$router.push('/encuestas')
        })
        .catch(error => {
          this.catchErrorServidor(error)
        })
        }
    }

}
</script>

<style>
.multiselect .multiselect__tags{
    height:auto !important;
    line-height: 14px;
}
.multiselect__tag{
    margin-right:5px;
    margin-bottom:0px;
}
</style>
