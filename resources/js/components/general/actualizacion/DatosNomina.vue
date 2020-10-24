<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <div class="form-group row">
      <label
        for="max_horas_extras"
        class="col-form-label custom-label text-right col-md-5"
      >Máx. núm. horas extras</label>
      <input
        type="number"
        name="max_horas_extras"
        v-validate="'required|numeric|min_value:0|max_value:20'"
        data-vv-as="Máximo número de horas exras"
        class="form-control custom-control col-md-6"
        v-model="empresaEditar.max_horas_extras"
      >
      <small
        class="invalid col-md-6 offset-5"
        v-if="errors.has('max_horas_extras')"
      >{{errors.first('max_horas_extras')}}</small>
    </div>
    <div class="form-group row">
      <label
        for="max_festivos_legales"
        class="custom-label text-right col-form-label col-md-5"
      >Máx. núm. fest. legales</label>
      <input
        type="number"
        name="max_festivos_legales"
        v-validate="'required|numeric|min_value:0|max_value:20'"
        data-vv-as="Máximo número de festivos legales"
        class="form-control custom-control col-md-6"
        v-model="empresaEditar.max_festivos_legales"
      >
      <small
        class="invalid col-md-6 offset-5"
        v-if="errors.has('max_festivos_legales')"
      >{{errors.first('max_festivos_legales')}}</small>
    </div>
    <div class="form-group row">
      <label
        for="max_llegadas_tarde"
        class="custom-label text-right col-form-label col-md-5"
      >Máx. núm. llegadas tarde</label>
      <input
        type="number"
        name="max_llegadas_tarde"
        v-validate="'required|numeric|min_value:0'"
        data-vv-as="Máximo número de llegadas tarde"
        class="form-control custom-control col-md-6"
        v-model="empresaEditar.max_llegadas_tarde"
      >
      <small
        class="invalid col-md-6 offset-5"
        v-if="errors.has('max_llegadas_tarde')"
      >{{errors.first('max_llegadas_tarde')}}</small>
    </div>

    <div class="form-group row">
      <label for="salario_base" class="custom-label text-right col-form-label col-md-5">Salario base</label>
      <input
        type="number"
        name="salario_base"
        v-validate="'required|numeric|min_value:0'"
        data-vv-as="Salario base"
        class="form-control custom-control col-md-6"
        v-model="empresaEditar.salario_base"
      >
      <small
        class="invalid col-md-6 offset-5"
        v-if="errors.has('salario_base')"
      >{{errors.first('salario_base')}}</small>
    </div>
    <div class="form-group row">
      <label
        for="auxilio_transporte"
        class="custom-label text-right col-form-label col-md-5"
      >Aux. transporte</label>
      <input
        type="number"
        name="auxilio_transporte"
        v-validate="'required|numeric|min_value:0'"
        data-vv-as="Auxilio de transporte"
        class="form-control custom-control col-md-6"
        v-model="empresaEditar.auxilio_transporte"
      >
      <small
        class="invalid col-md-6 offset-5"
        v-if="errors.has('auxilio_transporte')"
      >{{errors.first('auxilio_transporte')}}</small>
    </div>
    <div class="form-group row">
      <label
        for="hora_inicio_noche"
        class="custom-label text-right col-form-label col-md-5"
      >Hora inicio noche</label>

      <calendario-hora
        class="col-md-6 pl-0"
        :default="empresaEditar.hora_inicio_noche"
        ref="nomHoraInicioNoche"
      ></calendario-hora>
    </div>
    <div class="form-group row">
      <label
        for="hora_fin_noche"
        class="custom-label text-right col-form-label col-md-5"
      >Hora fin noche</label>
      <calendario-hora
        class="col-md-6 pl-0"
        :default="empresaEditar.hora_fin_noche"
        ref="nomHoraFinNoche"
      ></calendario-hora>
    </div>

    <div class="form group text-right mt-4">
      <button type="submit" class="btn btn-secondary raised">Actualizar</button>
    </div>
  </form>
</template>

<script>
import CalendarioHora from '../../utiles/CalendarioHora'
export default {
  components: { CalendarioHora },
  props: {
    empresaEditar: Object,
  },
  data() {
    return {}
  },
  methods: {
    validarAntesDeEnviar() {
      this.$validator.validateAll().then(validado => {
        if (validado) {
          this.guardarDatosGenerales()
          return
        }
        this.$swal.fire('Oops!', 'Corrige los errores antes de enviar', 'error')
      })
    },
    guardarDatosGenerales() {
      this.empresaEditar.hora_inicio_noche = moment(
        this.$refs.nomHoraInicioNoche.horaSeleccionada
      ).format('HH:mm:ss')

      this.empresaEditar.hora_fin_noche = moment(
        this.$refs.nomHoraFinNoche.horaSeleccionada
      ).format('HH:mm:ss')
      axios
        .patch(
          `/api/general/empresa/${this.empresaEditar.id}/editar`,
          this.empresaEditar
        )
        .then(respuesta => {
          modalEmitter.$emit('cerrar', 'datosNomina')
          this.$emit('notificar', respuesta.data.message)
        })
        .catch(error => {
          this.$swal.fire('Oops!', error.data.message, 'error')
        })
    },
  },
}
//v-validate="{required:true,regex:/^\$?(?=\(.*\)|[^()]*$)\(?\d{1,3}(\.?\d{3})?(\.\d{1,3}?)?\)?$/}"
</script>

<style scoped>
</style>
