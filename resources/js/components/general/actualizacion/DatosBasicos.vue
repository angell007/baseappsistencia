<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="razon_social" class="custom-label">Razón social</label>
        <input
          type="text"
          v-validate="'required'"
          data-vv-as="Razón social"
          name="razon_social"
          class="form-control custom-control"
          v-model="empresaEditar.razon_social"
        >
        <small class="invalid" v-if="errors.has('razon_social')">{{errors.first('razon_social')}}</small>
      </div>
      <div class="form-group col-md-6">
        <label for="tipo_documento" class="custom-label">Tipo de documento</label>
        <select
          name="tipo_documento"
          class="form-control custom-control"
          v-model="empresaEditar.tipo_documento"
        >
          <option value="NIT">NIT</option>
          <option value="Cédula de ciudadanía">Cédula de ciudadanía</option>
          <option value="Cédula de extranjería">Cédula de extranjería</option>
          <option value="Tarjeta de identidad">Tarjeta de identidad</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label for="numero_documento" class="custom-label">Número de documento</label>
        <input
          type="text"
          name="numero_documento"
          v-validate="'required|min:10|max:20'"
          data-vv-as="Número de documento"
          class="form-control custom-control"
          v-model="empresaEditar.numero_documento"
        >
        <small
          class="invalid"
          v-if="errors.has('numero_documento')"
        >{{errors.first('numero_documento')}}</small>
      </div>
      <div class="form-group col-md-12">
        <label for="fecha_constitucion" class="custom-label">Fecha de constitución</label>
        <calendario :fecha="empresaEditar.fecha_constitucion" ref="calendarioDatosBasicos"></calendario>
      </div>
      <div class="form-group col-md-7">
        <label for="email_contacto" class="custom-label">Email de contacto</label>
        <input
          type="email"
          name="email_contacto"
          v-validate="'required|email'"
          data-vv-as="Email de contacto"
          class="form-control custom-control"
          v-model="empresaEditar.email_contacto"
        >
        <small
          class="invalid"
          v-if="errors.has('email_contacto')"
        >{{errors.first('email_contacto')}}</small>
      </div>
      <div class="form-group col-md-5">
        <label for="telefono_contacto" class="custom-label">Teléfono de contacto</label>
        <input
          type="text"
          name="telefono_contacto"
          v-validate="'required|min:6|max:20'"
          data-vv-as="Teléfono de contacto"
          class="form-control custom-control"
          v-model="empresaEditar.telefono_contacto"
        >
        <small
          class="invalid"
          v-if="errors.has('telefono_contacto')"
        >{{errors.first('telefono_contacto')}}</small>
      </div>
    </div>
    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary raised">Actualizar</button>
    </div>
  </form>
</template>

<script>
import Calendario from '../../utiles/Calendario'

export default {
  components: { Calendario },
  props: {
    empresaEditar: Object,
  },
  data() {
    return {}
  },
  methods: {
    validarAntesDeEnviar() {
      this.$validator.validateAll().then(resultado => {
        if (resultado) {
          this.guardarDatosBasicos()
          return
        }
        this.$swal.fire('Ooops!', 'Corrige los errores', 'error')
      })
    },
    guardarDatosBasicos() {
      this.empresaEditar.fecha_constitucion = moment(
        this.$refs.calendarioDatosBasicos.fechaSeleccionada
      ).format('YYYY-MM-DD')

      axios
        .patch(
          `/api/general/empresa/${this.empresaEditar.id}/editar`,
          this.empresaEditar
        )
        .then(respuesta => {
          this.$validator.reset()
          modalEmitter.$emit('cerrar', 'datosBasicos')
          this.$emit('notificar', respuesta.data.message)
        })
        .catch(error => {
          this.$swal.fire('Oops!', error.data.message, 'error')
        })
    },
  },
  watch: {
    'empresaEditar.numero_documento': function() {
      if (
        this.empresaEditar.numero_documento.split('-').join('').length % 3 ==
        0
      ) {
        this.empresaEditar.numero_documento = this.empresaEditar.numero_documento
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, '-')
      }
    },
  },
}
</script>

<style scoped>
</style>
