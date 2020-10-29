<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <div class="form-group row">
      <label
        for="operador_pago"
        class="col-sm-4 col-md-4 col-form-label custom-label"
      >Operador de Pago utilizado</label>
      <div class="col-md-6">
        <select
          name="operador_pago"
          class="custom-control form-control"
          v-model="empresaEditar.operador_pago"
          v-validate="'required'"
          data-vv-as="Operador de pago"
        >
          <option
            v-for="(operador, index) in operadoresPagoDatos"
            :key="index"
            :value="operador.valor"
          >{{operador.llave}}</option>>
        </select>
        <small class="invalid" v-if="errors.has('operador_pago')">{{errors.first('operador_pago')}}</small>
      </div>
    </div>

    <div class="form-group row">
      <label for="arl" class="col-sm-4 col-md-4 col-form-label custom-label">Compañía ARL utilizada</label>
      <div class="col-md-6 font-weight-bold">
        <multiselect
          v-model="objetoArl"
          name="arl_id"
          v-validate="'required'"
          data-vv-as="Compañía arl"
          :options="arlDatos"
          placeholder="Seleccione una opción"
          deselectLabel="Enter para remover"
          selectLabel="Enter para seleccionar"
          label="nombre"
        ></multiselect>
        <small class="invalid" v-if="errors.has('arl_id')">{{errors.first('arl_id')}}</small>
      </div>
    </div>

    <div class="form-group row">
      <label
        for="ley_1429"
        class="col-sm-4 col-md-4 col-form-label custom-label"
      >Aplica para la Ley 1429 de 2010?</label>
      <div class="col-md-6">
        <div class="custom-control custom-checkbox">
          <input
            type="checkbox"
            v-model="empresaEditar.ley_1429"
            name="ley_1429"
            id="custom1429"
            class="custom-control-input"
          >
          <label class="custom-control-label" for="custom1429" v-if="empresaEditar.ley_1429">Si</label>
          <label class="custom-control-label" for="custom1429" v-else>No</label>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label
        for="ley_590"
        class="col-sm-4 col-md-4 col-form-label custom-label"
      >Aplica para la Ley 590 de 2000?</label>
      <div class="col-md-6">
        <div class="custom-control custom-checkbox">
          <input
            type="checkbox"
            v-model="empresaEditar.ley_590"
            name="ley_590"
            id="custom590"
            class="custom-control-input"
          >
          <label class="custom-control-label" for="custom590" v-if="empresaEditar.ley_590">Si</label>
          <label class="custom-control-label" for="custom590" v-else>No</label>
        </div>
      </div>
    </div>

    <div class="form-group row">
      <label
        for="ley_1607"
        class="col-sm-4 col-md-4 col-form-label custom-label"
      >Aplica para la Ley 1607 de 2012?</label>
      <div class="col-md-6">
        <div class="custom-control custom-checkbox">
          <input
            type="checkbox"
            v-model="empresaEditar.ley_1607"
            name="ley_1607"
            id="custom1607"
            class="custom-control-input"
          >
          <label class="custom-control-label" for="custom1607" v-if="empresaEditar.ley_1607">Si</label>
          <label class="custom-control-label" for="custom1607" v-else>No</label>
        </div>
      </div>
    </div>
    <div class="form-group text-right">
      <button class="btn btn-secondary raised">Actualizar pila</button>
    </div>
  </form>
</template>

<script>
import operadores from '../registro/datos/operadoresPago'
export default {
  props: {
    empresaEditar: Object,
  },
  data() {
    return {
      arlDatos: [],
      operadoresPagoDatos: [],
      objetoArl: null,
    }
  },
  created() {
    this.operadoresPagoDatos = operadores.operadoresPago
    this.getArlDatos()
  },
  methods: {
    getArlDatos() {
      axios.get(`/api/${localStorage.getItem('tenant')}/arl/datos`).then(datos => {
        this.arlDatos = datos.data

        this.asignarObjetoArl(this.empresaEditar.arl_id)
      })
    },
    validarAntesDeEnviar() {
      this.$validator.validateAll().then(validado => {
        if (validado) {
          this.guardarDatosPila()
          return
        }
        this.$swal.fire('Oops!', 'Corrige los errores', 'error')
      })
    },
    guardarDatosPila() {
      this.empresaEditar.arl.nombre = this.objetoArl.nombre
      this.empresaEditar.arl_id = this.objetoArl.id
      axios
        .patch(
          `/api/${localStorage.getItem('tenant')}/general/empresa/${this.empresaEditar.id}/editar`,
          this.empresaEditar
        )
        .then(respuesta => {
          modalEmitter.$emit('cerrar', 'datosPila')
          this.$emit('notificar', respuesta.data.message)
        })
        .catch(error => {
          this.$swal.fire('Oops hubieron errores', error.data.message, 'error')
        })
    },
    asignarObjetoArl(arlId) {
      this.objetoArl = this.arlDatos.find(arl => {
        return arl.id === arlId
      })
    },
  },
}
</script>

<style scoped>
</style>
