<template>
  <div class="container" v-if="mostrarForma">
    <form @submit.prevent="validarFormulario">
      <div class="form-group row">
        <label for="deduccion" class="col-md-4 col-form-label custom-label">Deduccion</label>
        <div class="col-md-8">
          <select
            name="deduccionesDatos"
            v-model="lista.contable_deduccion_id"
            class="form-control custom-control"
          >
            <option
              v-for="(deduccion,index) in deduccionesDatos"
              :key="index"
              :value="deduccion.id"
            >{{deduccion.concepto}}</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="valor" class="col-md-4 col-form-label custom-label">Valor</label>
        <div class="col-md-8">
          <input
            type="number"
            min="0"
            v-model="lista.valor"
            name="valor"
            v-validate="'required|numeric|min_value:1000'"
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
    <template v-if="deduccionesFuncionarioDatos.length > 0">
      <div class="row mb-3 mt-2">
        <div class="col-md-12">
          <p class="font-weight-bold">Deducciones actuales para {{funcionarioProp.nombres}}</p>
        </div>
      </div>
      <div class="row" v-for="(deduccion,index) in deduccionesFuncionarioDatos" :key="`E-${index}`">
        <div class="col-md-6">
          <p class="custom-label">{{deduccion.deduccion.concepto}}</p>
        </div>
        <div class="col-md-3">
          <p>{{deduccion.valor | moneda}}</p>
        </div>
        <div class="col-md-3">
          <p>
            <a
              title="eliminar"
              class="ml-1"
              href="#"
              @click.prevent="deleteDeduccion(deduccion.id)"
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
      >Si se desea crear más deducciones , puede ir al apartado de parametrización en la opción de contabilidad "Deducciones"</small>
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
        contable_deduccion_id: '',
        valor: '',
      },
      deduccionesDatos: [],
      deduccionesFuncionarioDatos: [],
      mostrarForma: false,
      tooltip: 'invalid',
    }
  },
  methods: {
    getDeducciones() {
      axios.get(`/api/${localStorage.getItem('tenant')}/api/deducciones`).then(datos => {
        this.deduccionesDatos = datos.data
        this.lista.contable_deduccion_id = this.deduccionesDatos[0].id
        this.getDatosDeducciones()
      })
    },
    getDatosDeducciones() {
      axios
        .get(`/api/${localStorage.getItem('tenant')}/deducciones/funcionarios/${this.funcionarioProp.id}`)
        .then(datos => {
          this.deduccionesFuncionarioDatos = datos.data
          this.mostrarForma = true
        })
    },
    async validarFormulario() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.postDeduccion()
        return
      }
      this.$swal.fire(
        'error',
        'Debe corregir los errores antes de continuar',
        'error'
      )
    },
    postDeduccion() {
      this.lista['funcionario_id'] = this.funcionarioProp.id
      //return console.log(this.lista)
      axios
        .post(`/api/${localStorage.getItem('tenant')}/deducciones/crear`, this.$data.lista)
        .then(respuesta => {
          this.$emit('cerrar', respuesta.data)
          setTimeout(() => {
            this.borrarDatos()
          }, 300)
        })
        .catch(error => {})
    },
    deleteDeduccion(id) {
      this.$swal
        .fire({
          title: '¿Seguro que desea eliminar esta deducción?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, eliminarlo!',
        })
        .then(resultado => {
          if (resultado.value) {
            axios.delete(`/api/${localStorage.getItem('tenant')}/deducciones/${id}/eliminar`).then(respuesta => {
              this.$swal.fire('Eliminada', respuesta.data.message, 'success')
              this.getDatosDeducciones()
            })
          }
        })
    },

    borrarDatos() {
      this.lista = { contable_deduccion_id: '', valor: '' }
    },
  },
}
</script>
<style scoped>
.simple-icon-trash {
  color: #2a93d5;
}
</style>
