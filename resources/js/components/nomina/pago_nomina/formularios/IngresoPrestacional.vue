<template>
  <div class="container" v-if="mostrarForma">
    <form @submit.prevent="validarFormulario">
      <div class="form-group row">
        <label for="ingreso" class="col-md-4 col-form-label custom-label">Ingreso</label>
        <div class="col-md-8">
          <select
            name="ingresosPDatos"
            v-model="lista.contable_ingreso_id"
            class="form-control custom-control"
          >
            <option
              v-for="(ingreso,index) in ingresosPDatos"
              :key="index"
              :value="ingreso.id"
            >{{ingreso.concepto}}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="valor" class="col-md-4 col-form-label custom-label">Valor</label>
        <div class="col-md-8">
          <input
            type="number"
            min="0"
            name="valor"
            v-validate="'required|numeric|min_value:1000'"
            v-model="lista.valor"
            class="form-control custom-control"
            placeholder="0"
          >
          <small class="invalid" v-if="errors.has('valor')">{{errors.first('valor')}}</small>
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-secondary raised">Agregar</button>
      </div>
    </form>
    <template v-if="ingresosPFuncionarioDatos.length > 0">
      <div class="row mb-3 mt-2">
        <div class="col-md-12">
          <h6>Ingresos actuales para {{funcionarioProp.nombres}}</h6>
        </div>
      </div>
      <div class="row" v-for="(ingresoP,index) in ingresosPFuncionarioDatos" :key="`C-${index}`">
        <div class="col-md-6">
          <p>{{ingresoP.ingreso.concepto}}</p>
        </div>
        <div class="col-md-3">
          <p>{{ingresoP.valor | moneda}}</p>
        </div>
        <div class="col-md-3">
          <p>
            <a
              title="eliminar"
              class="ml-1"
              href="#"
              @click.prevent="deleteIngresoPrestacional(ingresoP.id)"
            >
              <i class="simple-icon-trash"></i>
            </a>
          </p>
        </div>
      </div>
    </template>
    <p class="alert alert-secondary mt-3">
      <small
        class="font-weight-bold"
      >Si se desea crear más ingresos constitutivos, puede ir al apartado de parametrización en la opción de contabilidad "Crear otros ingresos constitutivos"</small>
    </p>
  </div>
</template>

<script>
export default {
  props: {
    funcionarioProp: Object,
  },
  data() {
    return {
      lista: {
        contable_ingreso_id: '',
        valor: '',
      },
      ingresosPDatos: [],
      ingresosPFuncionarioDatos: [],
      mostrarForma: false,
    }
  },
  methods: {
    getIngresosPrestacionales() {
      axios.get(`/api/${localStorage.getItem('tenant')}/nomina/pago/ingresos_prestacionales`).then(datos => {
        this.ingresosPDatos = datos.data
        this.lista.contable_ingreso_id = this.ingresosPDatos[0].id
        this.getDatosIngresosP()
      })
    },
    getDatosIngresosP() {
      axios
        .get(
          `/api/${localStorage.getItem('tenant')}/ingresos_prestacionales/funcionarios/${this.funcionarioProp.id}`
        )
        .then(datos => {
          this.ingresosPFuncionarioDatos = datos.data
          this.mostrarForma = true
        })
    },
    async validarFormulario() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.postIngresoPrestacional()
        return
      }
      this.$swal.fire(
        'Error!',
        'Debe corregir los errores antes de continuar',
        'error'
      )
    },
    postIngresoPrestacional() {
      this.lista['funcionario_id'] = this.funcionarioProp.id
      axios
        .post(`/api/${localStorage.getItem('tenant')}/ingresos_prestacionales/crear`, this.$data.lista)
        .then(respuesta => {
          this.$emit('cerrar', respuesta.data)
          setTimeout(() => {
            this.borrarDatos()
            this.$validator.reset()
          }, 300)
        })
        .catch(error => {
          if (error.response) {
            this.$swal.fire(
              'Error!',
              'Han ocurrido errores, por favor intente más tarde',
              'error'
            )
          }
        })
    },
    deleteIngresoPrestacional(id) {
      this.$swal
        .fire({
          title: '¿Seguro que desea eliminar el ingreso?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, eliminarlo!',
        })
        .then(resultado => {
          if (resultado.value) {
            axios
              .delete(`/api/${localStorage.getItem('tenant')}/ingresos_prestacionales/${id}/eliminar`)
              .then(respuesta => {
                this.$swal.fire('Eliminado', respuesta.data.message, 'success')
                this.getDatosIngresosP()
              })
          }
        })
    },

    borrarDatos() {
      this.lista = { contable_ingreso_id: '', valor: '' }
    },
  },
}
</script>

<style scoped>
.simple-icon-trash {
  color: #2a93d5;
}
</style>
