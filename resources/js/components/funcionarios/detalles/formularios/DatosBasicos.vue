<template>
  <form @submit.prevent="validarAntesDeEnviar" class="row">
      <div class="form-group col-md-2 text-center">
            <img
            id="imageOutput"
            :src="`/back/storage/app/public/${this.funcionarioEditar.image}`"
            alt="Imagen del funcionario"
            class="d-block m-auto"
            >
            <label for="image" class="subir-archivo mt-2">
            Cargar imagen
            <i class="simple-icon-doc"></i>
            </label>

            <input
            type="file"
            accept="image/*"
            name="image"
            v-validate="'size:800'"
            data-vv-as="Imagen"
            class="form-control-file"
            id="image"
            placeholder="Imagen"
            @change="vistaPreviaImagen"
            >

            <div class="col-md-12 text-center" v-if="errors.has('image')">
            <small class="invalid">{{errors.first('image')}}</small>
            </div>
        </div>
        <div class="form-group col-md-10 text-center">
            <div class="form-group row">
                <label class="custom-label text-right col-form-label col-md-2 offset-2" for="nombres">Nombres</label>
                <input
                    type="text"
                    name="nombres"
                    v-validate="'required|alpha_spaces|min:3'"
                    data-vv-as="Nombres"
                    class="form-control custom-control col-md-5"
                    placeholder="Nombres"
                    v-model="funcionarioEditar.nombres"
                >
                <small
                    class="invalid col-md-5 offset-4"
                    v-if="errors.has('nombres')"
                >{{errors.first('nombres')}}</small>
                </div>
                <div class="form-group row">
                <label
                    class="custom-label text-right col-form-label col-md-2 offset-2"
                    for="apellidos"
                >Apellidos</label>
                <input
                    type="text"
                    name="apellidos"
                    v-validate="'required|alpha_spaces|min:3'"
                    data-vv-as="Apellidos"
                    class="form-control custom-control col-md-5"
                    placeholder="Apellidos"
                    v-model="funcionarioEditar.apellidos"
                >
                <small
                    class="invalid col-md-5 offset-4"
                    v-if="errors.has('apellidos')"
                >{{errors.first('apellidos')}}</small>
                </div>

                <div class="form-group row">
                <label
                    class="custom-label text-right col-md-3 offset-1"
                    for="identidad"
                >Documento de Identidad</label>
                <input
                    type="text"
                    name="identidad"
                    v-validate="'required|numeric|min:6|max:15'"
                    data-vv-as="Documento de identidad"
                    class="form-control custom-control col-md-5"
                    placeholder="Documento de Identidad"
                    v-model="funcionarioEditar.identidad"
                >
                <small
                    class="invalid col-md-5 offset-4"
                    v-if="errors.has('identidad')"
                >{{errors.first('identidad')}}</small>
                </div>
                <div class="form-group row">
                <label
                    class="custom-label text-right col-md-3 offset-1"
                    for="tipo_contrato_id"
                >Tipo de Contrato</label>
                <multiselect
                    :max-height="200"
                    name="tipo_contrato_id"
                    placeholder="Seleccione una opción"
                    selectLabel="Enter para seleccionar"
                    deselectLabel="Enter para remover"
                    v-validate="'required'"
                    data-vv-as="Tipo de contrato"
                    v-model="contratoActual"
                    :options="contratosDatos"
                    class="col-md-5 font-weight-bold"
                    label="nombre"
                    @input="toggleFechaRetiro(contratoActual)"
                >
                    <template slot="noOptions">La lista está vacía</template>
                    <template slot="noResult">No existen resultados!</template>
                </multiselect>
                <small
                    class="invalid col-md-7 offset-4"
                    v-if="errors.has('tipo_contrato_id')"
                >{{errors.first('tipo_contrato_id')}}</small>
                </div>

                <div class="form-group row">
                <label class="custom-label text-right col-md-2 offset-2" for="email">Email</label>
                <input
                    type="email"
                    name="email"
                    v-validate="'required|email'"
                    class="form-control custom-control col-md-5"
                    v-model="funcionarioEditar.email"
                >
                <small class="invalid col-md-5 offset-4" v-if="errors.has('email')">{{errors.first('email')}}</small>
                </div>
                <div class="form-group row">
                <label
                    class="custom-label text-right col-form-label col-md-3 offset-1"
                    for="fecha_ingreso"
                >Fecha de Ingreso</label>
                <calendario ref="calendarioIngreso" :fecha="fechaIngresoFormato"></calendario>
                </div>
                <div class="form-group row" v-show="showFechaRetiro">
                <label
                    class="custom-label text-right col-form-label col-md-3 offset-1"
                    for="fecha_ingreso"
                >Fecha de Retiro</label>
                <calendario ref="calendarioRetiro" :fecha="fechaRetiroFormato"></calendario>

                <small class="invalid" v-if="errors.has('fecha_retiro')">{{errors.first('fecha_retiro')}}</small>
                </div>

                <div class="form-group row">
                <label
                    class="custom-label text-right col-form-label col-md-3 offset-1"
                    for="titulo_estudio"
                >Título de estudio</label>
                <input
                    type="text"
                    name="titulo_estudio"
                    v-validate="'alpha_spaces|min:3'"
                    data-vv-as="Título de estudio"
                    class="form-control custom-control col-md-5"
                    v-model="funcionarioEditar.titulo_estudio"
                >
                <small
                    class="invalid col-md-5 offset-4"
                    v-if="errors.has('titulo_estudio')"
                >{{errors.first('titulo_estudio')}}</small>
                </div>
                <div class="form-group text-right">
                <button type="submit" class="btn btn-secondary raised">Actualizar</button>
                </div>
        </div>



  </form>
</template>

<script>
import Calendario from '../../../utiles/Calendario'
export default {
  components: { Calendario },
  name: 'datos-basicos',
  props: {
    funcionarioEditar: Object,
  },
  data() {
    return {
      contratosDatos: [],
      contratoActual: '',
      showFechaRetiro: '',
      initialIdentidad: '',
      imagenTemporal: '',
    }
  },

  created() {
    this.initialIdentidad = this.funcionarioEditar.identidad
    this.getTiposContrato()
  },

  mounted() {
    this.showFechaRetiro = this.funcionarioEditar.fecha_retiro ? true : false
    if (!this.funcionarioEditar.fecha_retiro) {
      this.$refs.calendarioRetiro.fechaSeleccionada = moment.now()
    }
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.putDatosBasicos()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar',
        'error'
      )
    },

    putDatosBasicos() {

    this.setFuncionarioFechaRetiro()
      this.funcionarioEditar.tipo_contrato_id = this.contratoActual.id
      this.funcionarioEditar.fecha_ingreso = this.$refs.calendarioIngreso.formatearFecha();
      //this.funcionarioEditar.fecha_ingreso.formatearFecha()
      this.funcionarioEditar.image='';
      delete this.funcionarioEditar["image"];
      let data = new FormData()

      for (let prop in this.funcionarioEditar) {
        data.append(prop, this.funcionarioEditar[prop])
      }
      if(this.imagenTemporal!=''){
        data.append('image', this.imagenTemporal)
      }


      axios
        .post(
          `/api/funcionarios/${this.funcionarioEditar.id}/editar`,
          data
        )
        .then(respuesta => {
          this.funcionarioEditar.contrato.nombre = this.contratoActual.nombre
          this.$emit('mensaje', respuesta.data.message)
          if(respuesta.data.imagen!=''){
            this.$emit('cambiarRuta',respuesta.data.imagen);
          }
          modalEmitter.$emit('cerrar', 'datosBasicos')
          this.redirectIfIdentidadChanges()
        })
        .catch(error => {
          this.$swal.fire(
            'Oops!',
            error.response.data.message,
            'error'
          )
        })
    },
    setFuncionarioFechaRetiro() {
      if (this.contratoActual.id === 2 || this.contratoActual.id === 5) {
        this.funcionarioEditar.fecha_retiro = ''
      } else {
        this.funcionarioEditar.fecha_retiro = this.$refs.calendarioRetiro.formatearFecha();
      }
    },
    getTiposContrato() {
      axios.get('/api/contratos/datos').then(datos => {
        this.contratosDatos = datos.data
        this.getContratoFuncionario()
      })
    },
    getContratoFuncionario() {
      this.contratoActual = this.contratosDatos.find(contrato => {
        return contrato.id == this.funcionarioEditar.tipo_contrato_id
      })
    },

    toggleFechaRetiro(contrato) {
      if (contrato) {
        this.showFechaRetiro = contrato.id !== 2 && contrato.id !== 5
      }
    },

    redirectIfIdentidadChanges() {
      if (this.funcionarioEditar.identidad !== this.initialIdentidad) {
        this.$router.push({ name: 'FuncionariosPrincipal' })
      }
    },

    vistaPreviaImagen(event) {
      const image = document.getElementById('imageOutput')
      image.src = URL.createObjectURL(event.target.files[0])
      if (event.target.files.length > 0) {
        this.imagenTemporal = event.target.files[0]
      }
    },

  },

  computed: {
    fechaIngresoFormato() {
      return moment(this.funcionarioEditar.fecha_ingreso).format('YYYY-MM-DD')
    },
    fechaRetiroFormato() {
      return moment(this.funcionarioEditar.fecha_retiro).format('YYYY-MM-DD')
    },
  },
}
</script>
<style scoped>
input[type='file'] {
  display: none;
}
.subir-archivo {
  border: 1px solid #ccc;
  display: inline-block;
  padding: 6px 12px;
  font-weight: bold;
  cursor: pointer;
}
.subir-archivo {
  font-family: 'Lato';
  color: #7a7e7e;
}
fieldset legend {
  font-size: 1.2rem;
}
#imageOutput {
  width: 100px;
  height: 100px;
  border-radius: 50%;
}
</style>
