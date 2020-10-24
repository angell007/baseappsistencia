<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <div class="form-group row">
      <label class="custom-label col-form-label col-md-5" for="fecha_nacimiento">Fecha de nacimiento</label>
      <calendario ref="calendario" customWidth="240" :fecha="fechaDeNacimiento"></calendario>
    </div>
    <div class="form-group row">
      <label class="custom-label col-form-label col-md-5" for="sexo">Género</label>
      <select
        name="sexo"
        v-model="funcionarioEditar.sexo"
        class="form-control custom-control col-md-6"
      >
        <option value="Masculino">Masculino</option>
        <option value="Femenino">Femenino</option>
      </select>
    </div>
    <div class="form-group row">
      <label class="custom-label col-form-label col-md-5" for="estado_civil">Estado civil</label>
      <select v-model="estadoActual" class="form-control custom-control col-md-6">
        <option
          v-for="(estado,index) in estados"
          :key="index"
          :value="estado.valor"
        >{{estado.clave}}</option>
      </select>
    </div>

    <div class="form-group row">
      <label class="custom-label col-form-label col-md-5" for="celular">Celular</label>
      <input
        type="text"
        name="celular"
        v-validate="'required|numeric|min:10|max:15'"
        data-vv-as="Celular"
        class="form-control custom-control col-md-6"
        v-model="funcionarioEditar.celular"
      >
      <small
        class="invalid col-md-6 offset-5"
        v-if="errors.has('celular')"
      >{{errors.first('celular')}}</small>
    </div>
    <div class="form-group row">
      <label
        class="custom-label col-form-label col-md-5"
        for="direccion_residencia"
      >Dirección de residencia</label>
      <input
        type="text"
        name="direccion_residencia"
        v-validate="'required|min:3'"
        data-vv-as="Dirección de residencia"
        class="form-control custom-control col-md-6"
        v-model="funcionarioEditar.direccion_residencia"
      >
      <small
        class="invalid col-md-6 offset-5"
        v-if="errors.has('direccion_residencia')"
      >{{errors.first('direccion_residencia')}}</small>
    </div>

    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary raised">Actualizar</button>
    </div>
  </form>
</template>

<script>
import Calendario from '../../../utiles/Calendario'
import estados from '../../registro/formularios/datos/atributosFuncionario'
export default {
  components: { Calendario },
  props: {
    funcionarioEditar: Object,
  },
  data() {
    return {
      estados: '',
      estadoActual: '',
    }
  },

  created() {
    this.estados = estados.datos.estados
    this.getEstadoActual()
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.actualizarDatosPersonales()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar',
        'error'
      )
    },
    actualizarDatosPersonales() {
      this.funcionarioEditar.fecha_nacimiento = this.$refs.calendario.fechaSeleccionada
      this.funcionarioEditar.estado_civil = this.estadoActual
      this.funcionarioEditar.image='';
      delete this.funcionarioEditar["image"];
      axios
        .post(
          `/api/funcionarios/${this.funcionarioEditar.id}/editar`,
          this.funcionarioEditar
        )
        .then(respuesta => {
          this.$emit('notificar', respuesta.data.message)
          modalEmitter.$emit('cerrar', 'datosPersonales')
        })
        .catch(error => {
          this.$swal.fire(
            'Oops!',
            'Ha ocurrido un error, por favor intente más tarde',
            'error'
          )
        })
    },
    getEstadoActual() {
      this.estadoActual = this.estados.find(estado => {
        return estado.valor === this.funcionarioEditar.estado_civil
      }).valor
    },
  },
  computed: {
    fechaDeNacimiento() {
      return moment(this.funcionarioEditar.fecha_nacimiento).format(
        'YYYY-MM-DD'
      )
    },
  },
}
</script>

<style>
</style>
