<template>
  <div class="container" v-if="mostrarForma">
    <form @submit.prevent="validarFormulario">
      <div class="form-group row">
        <label for="ingreso" class="col-md-4 col-form-label custom-label">Ingreso</label>
        <div class="col-md-8">
          <select
            name="ingresosNPDatos"
            v-model="lista.contable_ingreso_id"
            class="form-control custom-control"
          >
            <option
              v-for="(ingreso,index) in ingresosNPDatos"
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
      <div class="form-group text-center">
        <button type="submit" class="btn btn-secondary raised">Agregar</button>
      </div>
    </form>
    <template v-if="ingresosNPFuncionarioDatos.length">
      <div class="row mb-3 mt-2">
        <div class="col-md-12">
          <p class="font-weight-bold">Ingresos actuales para {{funcionarioProp.nombres}}</p>
        </div>
      </div>
      <div class="row" v-for="(ingresoNP,index) in ingresosNPFuncionarioDatos" :key="`C-${index}`">
        <div class="col-md-6">
          <p>{{ingresoNP.ingreso.concepto}}</p>
        </div>
        <div class="col-md-3">
          <p>{{ingresoNP.valor | moneda}}</p>
        </div>
        <div class="col-md-3">
          <p>
            <a class="ml-1" href="#" @click.prevent="deleteIngresoNoPrestacional(ingresoNP.id)">
              <i class="simple-icon-trash"></i>
            </a>
          </p>
        </div>
      </div>
    </template>
    <div class="row">
      <div class="col-12">
        <p class="alert alert-secondary mt-3">
          <small
            class="font-weight-bold"
          >Si se desea crear más ingresos no constitutivos, puede ir al apartado de parametrización en la opción de contabilidad "Crear otros ingresos no constitutivos"</small>
        </p>
      </div>
    </div>
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
      ingresosNPDatos: [],
      ingresosNPFuncionarioDatos: [],
      mostrarForma: false,
    }
  },
  methods: {
    getIngresosNPrestacionales() {
      axios.get('/api/nomina/pago/ingresos_no_prestacionales').then(datos => {
        this.ingresosNPDatos = datos.data
        this.lista.contable_ingreso_id = this.ingresosNPDatos[0].id
        this.getDatosIngresosNP()
      })
    },
    getDatosIngresosNP() {
      axios
        .get(
          `/api/ingresos_no_prestacionales/funcionarios/${
            this.funcionarioProp.id
          }`
        )
        .then(datos => {
          this.ingresosNPFuncionarioDatos = datos.data
          this.mostrarForma = true
        })
    },
    async validarFormulario() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.postIngresoNoPrestacional()
        return
      }
      this.$swal.fire(
        'Error!',
        'Debe corregir los errores antes de continuar',
        'error'
      )
    },
    postIngresoNoPrestacional() {
      this.lista['funcionario_id'] = this.funcionarioProp.id
      axios
        .post('/api/ingresos_no_prestacionales/crear', this.$data.lista)
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
    deleteIngresoNoPrestacional(id) {
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
              .delete(`/api/ingresos_no_prestacionales/${id}/eliminar`)
              .then(respuesta => {
                this.$swal.fire('Eliminado', respuesta.data.message, 'success')
                this.getDatosIngresosNP()
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
