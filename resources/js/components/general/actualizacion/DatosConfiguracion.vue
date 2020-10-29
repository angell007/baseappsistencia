<template>
  <form @submit.prevent="guardarConfiguracionPago">
    <div class="form-group row">
      <label
        for="calculo_incapacidad_general"
        class="col-sm-5 custom-label col-form-label font-weight-bold"
      >Cálculo para la incapacidad general</label>
      <div class="col-sm-6">
        <select
          name="calculo_incapacidad_general"
          class="form-control custom-control"
          v-model="configuracion.calculo_incapacidad_general"
        >
          <option value="del 100 % al 66,67%">Al 100 % primeros 2 días y del día 3 al 90 al 66,67%</option>
          <option value="al 66,67%">Al 66,67% del día 1 al 90</option>
          <option value="al 100%">Al 100% del día 1 al 90</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label
        for="pago_deducciones"
        class="col-sm-5 custom-label col-form-label font-weight-bold"
      >Pago de las deducciones</label>
      <div class="col-sm-6">
        <select
          name="pago_deducciones"
          class="form-control custom-control"
          v-model="configuracion.pago_deducciones"
        >
          <option value="proporcionales">Proporcionales en cada pago</option>
          <option value="final_periodo">Al final del periodo</option>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label
        for="pago_recurrente"
        class="col-sm-5 custom-label col-form-label font-weight-bold"
      >¿Pagos recurrentes?</label>
      <div class="col-sm-6">
        <select
          name="pago_recurrente"
          class="form-control custom-control"
          v-model="configuracion.pago_recurrente"
        >
          <option value="proporcionales">Proporcionales</option>
          <option value="fijos">Fijos</option>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label
        for="pago_subsidio_transporte"
        class="col-sm-5 custom-label col-form-label font-weight-bold"
      >¿Cómo se paga el auxilio de transporte?</label>
      <div class="col-sm-6">
        <select
          name="pago_subsidio_transporte"
          class="form-control custom-control"
          v-model="configuracion.pago_subsidio_transporte"
        >
          <option value="mensual">Menusal</option>
          <option value="quincenal">Quincenal</option>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label
        for="afecta_subsidio_transporte"
        class="col-sm-5 col-form-label custom-label font-weight-bold"
      >¿Horas extras y recargos afectan auxilio de transporte?</label>
      <div class="col-sm-6">
        <select
          name="afecta_subsidio_transporte"
          class="form-control custom-control"
          v-model="configuracion.afecta_subsidio_transporte"
        >
          <option :value="true">Si</option>
          <option :value="false">No</option>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label
        for="pagar_vacaciones_31"
        class="col-sm-5 col-form-label custom-label font-weight-bold"
      >¿Pagar el día 31 del mes en vacaciones?</label>
      <div class="col-sm-6">
        <select
          name="pagar_vacaciones_31"
          class="form-control custom-control"
          v-model="configuracion.pagar_vacaciones_31"
        >
          <option :value="true">Si</option>
          <option :value="false">No</option>
        </select>
      </div>
    </div>

    <div class="form-group row text-right mb-0">
      <div class="col-sm-11">
        <button type="submits" class="btn btn-secondary raised">Guardar</button>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  props: ['empresaId', 'empresaConfiguracion'],
  data() {
    return {
      configuracion: {
        id: '',
        empresa_id: '',
        calculo_incapacidad_general: '',
        pago_deducciones: '',
        pago_recurrente: '',
        pago_subsidio_transporte: '',
        afecta_subsidio_transporte: '',
        pagar_vacaciones_31: '',
      },
    }
  },

  mounted() {
    this.configuracion.empresa_id = this.empresaId
    if (this.empresaConfiguracion != null) {
      this.configuracion = this.empresaConfiguracion
    }
  },

  methods: {
    guardarConfiguracionPago() {
      if (!this.empresaConfiguracion) {
        axios
          .post(`/api/${localStorage.getItem('tenant')}/general/empresa/configuracion/crear`, this.configuracion)
          .then(respuesta => {
            modalEmitter.$emit('cerrar', 'datosConfiguracion')
            this.$emit('notificar', respuesta.data.message)
          })
          .catch(error => {
            this.$swal.fire('Oops!', error.data.message, 'error')
          })
      } else {
        axios
          .put(
            `/api/${localStorage.getItem('tenant')}/general/empresa/configuracion/${
              this.configuracion.id
            }/editar`,
            this.configuracion
          )
          .then(respuesta => {
            modalEmitter.$emit('cerrar', 'datosConfiguracion')
            this.$emit('notificar', respuesta.data.message)
          })
          .catch(error => {
            this.$swal.fire('Oops!', error.data.message, 'error')
          })
      }
    },
  },
}
</script>

<style scoped>
</style>
