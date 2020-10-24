<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label class="custom-label" for="funcionario_id">Funcionario</label>

        <multiselect
          selectedLabel="Actual"
          deselectLabel="Enter para remover"
          selectLabel="Enter para seleccionar"
          placeholder="Seleccione Funcionario"
          :custom-label="nombreCompleto"
          v-model="funcionario"
          :options="funcionariosDatos"
          name="funcionario_id"
          v-validate="'required|min:3'"
          data-vv-as="Funcionario"
          @input="asignarIdFuncionario"
          :disabled="deshabilitarCampo"
        ></multiselect>
        <small
          class="invalid"
          v-if="errors.has('funcionario_id')"
        >{{errors.first('funcionario_id')}}</small>
      </div>

      <div class="form-group col-md-6">
        <label class="custom-label" for="contable_licencia_incapacidad_id">Novedad</label>
        <select
          class="form-control custom-control"
          name="contable_licencia_incapacidad_id"
          v-validate="'required'"
          data-vv-as="Novedad"
          v-model="lista.contable_licencia_incapacidad_id"
          @change="obtenerTipoNovedad(lista.contable_licencia_incapacidad_id)"
        >
          <option
            v-for="(novedad,index) in nombresNovedadesDatos"
            :key="index"
            :value="novedad.id"
          >{{novedad.concepto}}</option>
        </select>
        <small
          class="invalid"
          v-if="errors.has('contable_licencia_incapacidad_id')"
        >{{errors.first('contable_licencia_incapacidad_id')}}</small>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label class="custom-label" for="tipo">Tipo de Novedad</label>
        <input
          type="text"
          name="tipo"
          v-validate="'required|alpha_spaces|min:3'"
          data-vv-as="Tipo de novedad"
          v-model="lista.tipo"
          class="form-control custom-control"
          :disabled="true"
        >
      </div>

      <div class="form-group col-md-6">
        <label class="custom-label" for="modalidad">Modalidad de la novedad</label>
        <select
          name="modalidad"
          v-model="lista.modalidad"
          class="form-control custom-control"
          v-validate="'required|min:3'"
          data-vv-as="Modalidad"
        >
          <option value="Día">Día</option>
          <option value="Hora">Hora</option>
        </select>
        <small class="invalid" v-if="errors.has('modalidad')">{{errors.first('modalidad')}}</small>
      </div>
    </div>

    <div class="form-row" v-if="lista.modalidad != '' ">
      <div class="form-group col-md-6">
        <label class="custom-label" for="fecha_inicio">Fecha de Inicio</label>
        <input
          type="date"
          name="fecha_inicio"
          v-model="lista.fecha_inicio"
          class="form-control custom-control"
          v-if="lista.modalidad == 'Día'"
        >
        <input
          type="datetime-local"
          name="fecha_inicio"
          v-model="lista.fecha_inicio"
          class="form-control custom-control"
          v-else-if="lista.modalidad == 'Hora'"
        >
        <small class="invalid" v-if="errors.has('fecha_inicio')">{{errors.first('fecha_inicio')}}</small>
      </div>
      <div class="form-group col-md-6">
        <label class="custom-label" for="fecha_fin">Fecha de Fin</label>
        <input
          type="date"
          name="fecha_fin"
          v-model="lista.fecha_fin"
          class="form-control custom-control"
          v-if="lista.modalidad == 'Día'"
        >
        <input
          type="datetime-local"
          name="fecha_fin"
          v-model="lista.fecha_fin"
          class="form-control custom-control"
          v-else-if="lista.modalidad == 'Hora'"
        >
        <small class="invalid" v-if="errors.has('fecha_fin')">{{errors.first('fecha_fin')}}</small>
      </div>
    </div>
    <div class="form-group">
      <button
        type="button"
        class="btn btn-link p-0"
        @click.prevent="agregarObservacion = !agregarObservacion"
      >Agregar Observación</button>
    </div>
    <div class="form-row" v-if="agregarObservacion">
      <div class="form-group col-md-12">
        <label class="custom-label" for="observacion">Observación</label>
        <textarea
          name="observación"
          v-model="lista.observacion"
          rows="5"
          class="form-control custom-control"
        ></textarea>
      </div>
    </div>
    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary raised">Guardar Novedad</button>
    </div>
  </form>
</template>

<script>
export default {
  data() {
    return {
      funcionario: '',
      lista: {
        id: '',
        funcionario_id: '',
        contable_licencia_incapacidad_id: '',
        fecha_inicio: '',
        fecha_fin: '',
        tipo: '',
        modalidad: '',
        observacion: '',
      },
      funcionariosDatos: [],
      nombresNovedadesDatos: [],
      agregarObservacion: false,
      deshabilitarCampo: false,
    }
  },

  created() {
    this.cargarFuncionarios()
    this.cargarNovedades()
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.guardarNovedad()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar',
        'error'
      )
    },
    cargarFuncionarios() {
      axios.get('/api/novedades/funcionarios').then(funcionarios => {
        this.funcionariosDatos = funcionarios.data
      })
    },
    cargarNovedades() {
      axios.get('/api/novedades/nombres_novedades').then(novedades => {
        this.nombresNovedadesDatos = novedades.data
      })
    },

    obtenerTipoNovedad(id) {
      let novedad = this.nombresNovedadesDatos.find(novedad => {
        return novedad.id === id
      })
      let tipo = novedad.concepto.split(' ')[0]
      this.lista.tipo = tipo
    },

    asignarIdFuncionario(funcionario) {
      this.lista.funcionario_id = !funcionario ? '' : funcionario.id
    },

    nombreCompleto({ nombres, apellidos }) {
      return `${nombres} ${apellidos}`
    },

    guardarNovedad() {
      if (!this.lista.id) {
        axios
          .post('/api/novedades/crear', this.$data.lista)
          .then(respuesta => {
            this.guardadoDatosFin()
          })
          .catch(error => {
            this.errorDelServidor(error)
          })
      } else {
        axios
          .put(`/api/novedades/${this.lista.id}/editar`, this.$data.lista)
          .then(respuesta => {
            this.guardadoDatosFin()
          })
          .catch(error => {
            this.errorDelServidor(error)
          })
      }
    },

    guardadoDatosFin() {
      this.$emit('recargar')
      modalEmitter.$emit('cerrar', this.$parent.id)
      this.limpiarFormulario()
      this.$validator.reset()
    },

    errorDelServidor(error) {
      if (error.response) {
        this.$swal.fire(
          'Error!',
          'Han ocurrido errores, por favor intente más tarde',
          'error'
        )
      }
    },

    limpiarFormulario() {
      for (let propiedad in this.$data.lista) {
        this.$data.lista[propiedad] = ''
      }
      this.funcionario = ''
      this.deshabilitarCampo = false
    },
  },
}
</script>

<style scoped>
input[type='date']::-webkit-inner-spin-button,
input[type='datetime-local']::-webkit-inner-spin-button {
  display: none;
  -webkit-appearance: none;
}
</style>

