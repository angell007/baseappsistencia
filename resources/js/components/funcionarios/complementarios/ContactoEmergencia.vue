<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 offset-2">
        <div class="card-custom mb-4">
          <div class="card-body">
            <form @submit.prevent>
              <div class="form-group row">
                <label
                  class="custom-label text-right col-form-label col-md-3 offset-2"
                  for="nombre_completo"
                >Nombre completo</label>
                <input
                  type="text"
                  name="nombre_completo"
                  v-validate="'required|alpha_spaces|min:3'"
                  data-vv-as="Nombre completo"
                  class="form-control custom-control col-md-5"
                  placeholder="Nombre completo"
                  v-model="lista.nombre_completo"
                >
                <small
                  class="invalid offset-5"
                  v-if="errors.has('nombre_completo')"
                >{{errors.first('nombre_completo')}}</small>
              </div>
              <div class="form-group row">
                <label
                  class="custom-label text-right col-form-label col-md-2 offset-3"
                  for="parentesco"
                >Parentesco</label>
                <input
                  type="text"
                  name="parentesco"
                  v-validate="'required|alpha_spaces'"
                  class="form-control custom-control col-md-4"
                  placeholder="Parentesco"
                  v-model="lista.parentesco"
                >
                <small
                  class="invalid offset-5"
                  v-if="errors.has('parentesco')"
                >{{errors.first('parentesco')}}</small>
              </div>

              <div class="form-group row">
                <label
                  class="custom-label text-right col-form-label col-md-2 offset-3"
                  for="celular"
                >Celular</label>
                <input
                  type="text"
                  name="celular"
                  v-validate="'required|numeric'"
                  class="form-control custom-control col-md-4"
                  placeholder="Celular"
                  v-model="lista.celular"
                >
                <small
                  class="invalid offset-5"
                  v-if="errors.has('celular')"
                >{{errors.first('celular')}}</small>
              </div>
              <div class="form-group row">
                <label
                  class="custom-label text-right col-form-label col-md-2 offset-3"
                  for="telefono_fijo"
                >Teléfono fijo</label>
                <input
                  type="text"
                  name="telefono_fijo"
                  v-validate="'numeric'"
                  data-vv-as="Teléfono fijo"
                  class="form-control custom-control col-md-4"
                  placeholder="Teléfono fijo"
                  v-model="lista.telefono_fijo"
                >
                <small
                  class="invalid offset-5"
                  v-if="errors.has('telefono_fijo')"
                >{{errors.first('telefono_fijo')}}</small>
              </div>
              <div class="form-group row">
                <label
                  class="custom-label text-right col-form-label col-md-3 offset-2"
                  for="direccion_residencia"
                >Dirección residencia</label>
                <input
                  type="text"
                  name="direccion_residencia"
                  class="form-control custom-control col-md-5"
                  placeholder="Dirección de Residencia"
                  v-model="lista.direccion_residencia"
                >
                <small
                  class="invalid offset-5"
                  v-if="errors.has('direccion_residencia')"
                >{{errors.first('direccion_residencia')}}</small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      funcionario_identidad: '',
      lista: {
        id: '',
        funcionario_id: '',
        parentesco: '',
        nombre_completo: '',
        telefono: '',
        celular: '',
        direccion: '',
      },
    }
  },

  created() {
    funcionarioEmitter.$on('creado', datos => {
      this.lista.funcionario_id = datos.id
      this.funcionario_identidad = datos.identidad
    })
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (!validado) {
        this.$swal.fire(
          'Oops!',
          'Debe corregir los errores antes de enviar',
          'error'
        )
        return false
      }
      return true
    },
    async guardarContacto() {
      let validado = await this.validarAntesDeEnviar()

      if (validado) {
        if (!this.lista.id) {
          let respuesta = await axios.post(
            `/api/${localStorage.getItem('tenant')}/funcionarios/${this.funcionario_identidad}/contacto/crear`,
            this.$data.lista
          )
          try {
            if (respuesta) {
              this.eliminarDatos()
              this.$validator.reset()
              return true
            }
          } catch (error) {
            this.$swal(
              'Oops!',
              'Hubo un error, por favor intente más tarde',
              'error'
            )
            this.$emit('errores')
            return false
          }
        }
      }
      return false
    },
    eliminarDatos() {
      for (let prop in this.lista) {
        this.lista[prop] = ''
      }
    },
  },
}
</script>

<style scoped>
.card-custom {
  background-color: rgb(250, 250, 250);
  border-radius: 2px;
  /* -webkit-box-shadow: -1px 1px 12px 1px rgba(189, 189, 189, 0.57);
  -moz-box-shadow: -1px 1px 12px 1px rgba(189, 189, 189, 0.57);
  box-shadow: -1px 1px 12px 1px rgba(189, 189, 189, 0.57); */
}
</style>
