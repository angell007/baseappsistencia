<template>
  <div class="container">
    <router-link to="/encuestas" class="btn btn-link mb-2 p-0">
      <i class="simple-icon-action-undo"></i> Volver
    </router-link>
    <h2 class="font-weight-bold text-primary">Agregar/Editar Encuesta</h2>



    <div class="card">
      <div class="card-body">
        <form @submit.prevent="validarAntesDeEnviar">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label class="custom-label" for="nombre">Nombre</label>
              <input
                type="text"
                class="form-control custom-control"
                name="nombre"
                v-validate="'required|min:5'"
                data-vv-as="Nombre"
                placeholder="Nombre de la Encuesta"
                v-model="lista.nombre"
              >
              <small class="invalid" v-if="errors.has('nombre')">{{errors.first('nombre')}}</small>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label class="custom-label" for="tipo_aplicacion">Tipo de Aplicación</label>
              <select name="tipo_aplicacion" class="form-control custom-control"  v-model="lista.tipo_aplicacion">
                <option value="sms">Vía SMS</option>
                <option value="correo">Vía Correo</option>
                <option value="ambos">Ambas Vías</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label class="custom-label" for="frecuencia_aplicacion">Frecuencia Aplicación</label>
              <select name="frecuencia_aplicacion" class="form-control custom-control" v-model="lista.frecuencia_aplicacion">
                <option value="unica">Única</option>
                <option value="diaria">Diaria</option>
                <option value="semanal">Semanal</option>
                <option value="quincenal">Quincenal</option>
                <option value="mensual">Mensual</option>
                <option value="bimensual">Bimensual</option>
                <option value="trimestral">Trimestral</option>
                <option value="semestral">Semestral</option>
                <option value="anual">Anual</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label class="custom-label" for="restrictiva">¿Es Restrictiva?</label>
              <select name="restrictiva" class="form-control custom-control" v-model="lista.restrictiva">
                <option value="no">No</option>
                <option value="si">Si</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
                <label class="custom-label" for="descripcion">Descripción</label>
                <textarea
                    type="text"
                    class="form-control"
                    name="descripcion"
                    v-validate="'required|min:10'"
                    data-vv-as="descripcion"
                    placeholder="Descripción o Justificación de la Encuesta"
                    v-model="lista.descripcion"
                    rows="3"
                ></textarea>
                <small class="invalid" v-if="errors.has('descripcion')">{{errors.first('descripcion')}}</small>
            </div>
          </div>

          <h5 style="margin-top:20px; ">Preguntas de la Encuesta</h5>
          <hr>
          <div class="form-row" v-for="(pregunta, index) in Preguntas"
            :key="`${index}-pregunta`">
                <div class="form-group col-md-8">
                    <label class="custom-label" for="pregunta">Pregunta {{index +1}}</label>
                    <input
                        type="text"
                        name="pregunta"
                        v-validate="Preguntas[index].requerido"
                        class="form-control custom-control"
                        placeholder="Ingrese al menos una pregunta"
                        v-model="Preguntas[index].pregunta"
                    >
                    <small class="invalid" v-if="errors.has('pregunta')">{{errors.first('pregunta')}}</small>
                </div>
                <div class="form-group col-md-3">
                    <label class="custom-label" for="tipo_pregunta">Tipo Pregunta {{index +1}}</label>
                    <select name="tipo_pregunta" class="form-control custom-control" v-model="Preguntas[index].tipo_pregunta">
                        <option value="simple"                      >Selección Simple (Si - No)         </option>
                        <option value="simple-dos"          >Selección Simple (Personalizada)   </option>
                        <option value="multiple"            >Selección Múltiple                 </option>
                        <option value="respuesta-corta"     >Respuesta Corta                    </option>
                        <option value="respuesta-larga"     >Respuesta Larga                    </option>
                    </select>
                    <div v-if="Preguntas[index].tipo_pregunta=='simple-dos'||Preguntas[index].tipo_pregunta=='multiple'" >
                        <hr>
                        <div class="form-row" v-for="(opcion, i) in Preguntas[index].opciones"
                                    :key="`${index}-${i}-opcion-pregunta`">
                            <div class="form-group col-md-10 grupo-opciones">
                            <input
                                type="text"
                                name="opcion"
                                class="form-control custom-control opciones"
                                :placeholder="`Opcion ${i+1}`"
                                v-model="Preguntas[index].opciones[i].opcion"
                            >
                            <small class="invalid" v-if="errors.has('opcion')">{{errors.first('opcion')}}</small>
                            </div>
                            <div class="form-group col-md-2 grupo-opciones">
                                <a
                                    href="#"
                                    class="table-icon-2"
                                    v-if="Preguntas[index].opciones.length==(i+1)"
                                    @click.prevent="agregarOpcion(index)"
                                    data-toggle="tooltip" data-placement="top" title="" data-original-title="Agregar Opcion"
                                    >
                                    <i class="simple-icon-plus"></i>
                                    </a>

                                    <a
                                    href="#"
                                    class="table-icon-2"
                                    v-if="i>0"
                                    @click.prevent="eliminarOpcion(index,i)"
                                    data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar Opcion"
                                    >
                                    <i class="simple-icon-trash"></i>
                                    </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div  class="form-group col-md-1 text-center">
                    <a
                      href="#"
                      class="table-icon"
                      v-if="Preguntas.length==(index+1)"
                      @click.prevent="agregarPregunta()"
                      data-toggle="tooltip" data-placement="top" title="" data-original-title="Agregar Otra Pregunta"
                    >
                      <i class="simple-icon-plus"></i>
                    </a>

                    <a
                      href="#"
                      class="table-icon"
                      v-if="index>0"
                      @click.prevent="eliminarPregunta(index)"
                      data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar Pregunta"
                    >
                      <i class="simple-icon-trash"></i>
                    </a>

                </div>
          </div>



          <div class="form-group text-right" style="margin-top:20px;">
            <button type="submit" class="btn btn-secondary raised">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>

export default {

  data() {
    return {
      lista: {
        id: '',
        nombre: '',
        tipo_aplicacion: 'sms',
        frecuencia_aplicacion: 'diaria',
        restrictiva: 'si',
        descripcion : ''
      },

      Preguntas: [
          {
              pregunta:'',
              tipo_pregunta : 'simple',
              requerido : 'required|min:5',
              opciones : [
                  { opcion : '' }
              ]
          }
      ],
      PreguntasLlenas:[]
    }
  },
  created() {
    if (this.encuestaExistente()) {
      this.lista = this.$route.params['encuesta']
    }
    this.fillPreguntas()
  },

  methods: {
    encuestaExistente() {
      return this.$route.params['encuesta'] ? true : false
    },

    fillPreguntas() {
    },

    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.makeRequest()
        return
      }
      this.$swal.fire(
        'Error!',
        'Debe corregir los errores antes de enviar',
        'error'
      )
    },

    agregarPregunta(){
        this.Preguntas.push({
              pregunta:'',
              tipo_pregunta : 'simple',
              requerido : 'required|min:5',
              opciones : [
                  { opcion : '' }
              ]
          });
    },
    eliminarPregunta(index){
        this.$delete(this.Preguntas,index)
    },
    agregarOpcion(index){
        this.Preguntas[index].opciones.push(
              { opcion : '' }
          );
    },
    eliminarOpcion(index,i){
        this.$delete(this.Preguntas[index].opciones,index)
    },
    makeRequest() {
      if (!this.lista.id) {
        this.postEncuesta()
      } else {
        this.putEncuesta()
      }
    },

    postEncuesta() {
        this.lista["Preguntas"]=this.Preguntas;
      axios
        .post('/api/encuestas/crear',  this.lista)
        .then(respuesta => {
          this.$swal.fire('Correcto', respuesta.data.message, 'success')
          this.$router.push('/encuestas')
        })
        .catch(error => {
          this.catchErrorServidor(error)
        })
    },

    putEncuesta() {
      axios
        .put(`/api/encuestas/${this.lista.id}/editar`, this.lista)
        .then(respuesta => {
          this.$swal.fire('Correcto', respuesta.data.message, 'success')
          this.$router.push('/encuestas')
        })
        .catch(error => {
          this.catchErrorServidor(error)
        })
    },


    catchErrorServidor(error) {
      if (error.response) {
        this.$swal.fire(
          'Error',
          'Han ocurrido errores, por favor intente más tarde',
          'error'
        )
      }
    },
  },
}
</script>
<style scoped>
    .table-icon{
        margin-top: 34px !important;
        display: inline-block;
    }
    .table-icon i{
        font-weight: bold;
        font-size: 15px;
    }
    .opciones{
        height: auto;
        padding: 3px;
        font-size: 12px;
    }
    .table-icon-2{
        margin-top: 3px !important;
        display: inline-block;
    }
    .grupo-opciones{
        margin-bottom: 5px;
    }
</style>
