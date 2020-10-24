<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="frecuencia_pago" class="custom-label">Frecuencia de Pago</label>
        <select
          name="frecuencia_pago"
          class="form-control custom-control"
          v-validate="'required'"
          data-vv-as="Frecuencia de pago"
          v-model="empresaEditar.frecuencia_pago"
        >
          <option value="Mensual">Mensual</option>>
          <option value="Quincenal">Quincenal</option>
        </select>
        <small
          class="invalid"
          v-if="errors.has('frecuencia_pago')"
        >{{errors.first('frecuencia_pago')}}</small>
      </div>
      <div class="form-group col-md-6">
        <label for="medio_pago" class="custom-label">Medio de Pago</label>
        <select
          type="text"
          name="medio_pago"
          v-validate="'required'"
          data-vv-as="Medio de pago"
          class="form-control custom-control"
          v-model="empresaEditar.medio_pago"
        >
          <option value="Transferencia Bancaria">Transferencia Bancaria</option>>
          <option value="Efectivo">Efectivo</option>
        </select>
        <small class="invalid" v-if="errors.has('medio_pago')">{{errors.first('medio_pago')}}</small>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="banco_pago" class="custom-label">Banco del cual realizaras los pagos</label>

        <multiselect
          :max-height="200"
          name="banco_id"
          class="col-md-6 font-weight-bold"
          placeholder="Seleccione una opción"
          selectLabel="Enter para seleccionar"
          deselectLabel="Enter para remover"
          v-validate="'required'"
          data-vv-as="Banco del pago"
          v-model="objetoBanco"
          :options="bancosDatos"
          label="nombre"
          track-by="id"
        ></multiselect>
        <small v-if="errors.has('banco_id')" class="invalid col-md-6">{{errors.first('banco_id')}}</small>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="tipo_cuenta" class="custom-label">Tipo de cuenta</label>
        <select
          name="tipo_cuenta"
          v-validate="'required'"
          data-vv-as="Tipo de cuenta"
          class="form-control custom-control"
          v-model="empresaEditar.tipo_cuenta"
        >
          <option value="Cuenta de Ahorros">Cuenta de Ahorros</option>
          <option value="Cuenta Corriente">Cuenta Corriente</option>
        </select>
        <small class="invalid" v-if="errors.has('tipo_cuenta')">{{errors.first('tipo_cuenta')}}</small>
      </div>
      <div class="form-group col-md-6">
        <label for="numero_cuenta" class="custom-label">Número de cuenta</label>
        <input
          type="text"
          name="numero_cuenta"
          v-validate="'required|min:10|max:23'"
          data-vv-as="Número de cuenta"
          class="form-control custom-control"
          v-model="empresaEditar.numero_cuenta"
        >
        <small class="invalid" v-if="errors.has('numero_cuenta')">{{errors.first('numero_cuenta')}}</small>
      </div>
    </div>
    <div class="form-group text-right mt-3">
      <button class="btn btn-secondary raised">Actualizar</button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    empresaEditar: Object,
  },

  data() {
    return {
      bancosDatos: [],
      objetoBanco: null,
    }
  },
  created() {
    this.getBancosDatos()
  },

  methods: {
    validarAntesDeEnviar() {
      this.$validator.validateAll().then(validado => {
        if (validado) {
          this.guardarDatosPago()
          return
        }
        this.$swal.fire('Oops!', 'Corrige los errores antes de enviar', 'error')
      })
    },
    getBancosDatos() {
      axios.get('/api/bancos/datos').then(datos => {
        this.bancosDatos = datos.data
        this.asignarObjetoBanco(this.empresaEditar.banco_id)
      })
    },
    guardarDatosPago() {
      this.empresaEditar.banco_id = this.objetoBanco.id
      this.empresaEditar.banco.nombre = this.objetoBanco.nombre
      axios
        .patch(
          `/api/general/empresa/${this.empresaEditar.id}/editar`,
          this.empresaEditar
        )
        .then(respuesta => {
          modalEmitter.$emit('cerrar', 'datosPago')
          this.$emit('notificar', respuesta.data.message)
        })
        .catch(error => {
          this.$swal.fire('Oops!', error.data.message, 'error')
        })
    },
    asignarObjetoBanco(bancoId) {
      this.objetoBanco = this.bancosDatos.find(banco => {
        return banco.id === bancoId
      })
    },
  },
  watch: {
    'empresaEditar.numero_cuenta': function() {
      if (
        this.empresaEditar.numero_cuenta.split('-').join('').length % 3 ==
        0
      ) {
        this.empresaEditar.numero_cuenta = this.empresaEditar.numero_cuenta
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, '-')
      }
    },
  },
}
</script>

<style scoped>
</style>
