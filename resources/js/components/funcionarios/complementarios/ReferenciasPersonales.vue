<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 offset-2">
        <div class="card-custom mb-4">
          <div class="card-body">
            <form @submit.prevent>
              <div class="form-group row">
                <label
                  class="custom-label col-form-label col-md-4 text-right"
                  for="nombre_completo"
                >Nombre Completo</label>
                <input
                  type="text"
                  name="nombre_completo"
                  v-validate="'required|alpha_spaces|min:3'"
                  data-vv-as="Nombre completo"
                  class="form-control custom-control col-md-6"
                  placeholder="Nombre Completo"
                  v-model="lista.nombre_completo"
                >
                <small
                  class="invalid col-md-6 offset-4"
                  v-if="errors.has('nombre_completo')"
                >{{errors.first('nombre_completo')}}</small>
              </div>
              <div class="form-group row">
                <label
                  class="custom-label col-form-label col-md-4 text-right"
                  for="profesion"
                >Profesión</label>
                <input
                  type="text"
                  name="profesion"
                  v-validate="'alpha_spaces|min:3'"
                  data-vv-as="Profesión"
                  class="form-control custom-control col-md-6"
                  placeholder="Profesión"
                  v-model="lista.profesion"
                >
                <small
                  class="invalid col-md-6 offset-4"
                  v-if="errors.has('profesion')"
                >{{errors.first('profesion')}}</small>
              </div>
              <div class="form-group row">
                <label
                  class="custom-label col-form-label col-md-4 text-right"
                  for="telefono"
                >Teléfono</label>
                <input
                  type="text"
                  name="telefono"
                  v-validate="'numeric|min:6'"
                  data-vv-as="Teléfono"
                  class="form-control custom-control col-md-6"
                  placeholder="Teléfono"
                  v-model="lista.telefono"
                >
                <small
                  class="invalid col-md-6 offset-4"
                  v-if="errors.has('telefono')"
                >{{errors.first('telefono')}}</small>
              </div>
              <div class="form-group row">
                <label class="custom-label col-form-label col-md-4 text-right" for="celular">Celular</label>
                <input
                  type="text"
                  name="celular"
                  v-validate="'numeric|min:10'"
                  class="form-control custom-control col-md-6"
                  placeholder="Celular"
                  v-model="lista.celular"
                >
                <small
                  class="invalid col-md-6 offset-4"
                  v-if="errors.has('celular')"
                >{{errors.first('celular')}}</small>
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
        nombre_completo: '',
        profesion: '',
        telefono: '',
        celular: '',
      },
    }
  },

  created() {
    funcionarioEmitter.$on('creado', datos => {
      this.funcionario_identidad = datos.identidad
      this.lista.funcionario_id = datos.id
    })
  },
  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (!validado) {
        this.$swal(
          'Oops!',
          'Debe corregir los errores antes de enviar',
          'error'
        )
        return false
      }
      return true
    },
    async guardarReferencia() {
      let validado = await this.validarAntesDeEnviar()

      if (validado) {
        if (!this.lista.id) {
          let respuesta = await axios.post(
            `/api/${localStorage.getItem('tenant')}/funcionarios/${this.funcionario_identidad}/referencia/crear`,
            this.$data.lista
          )

          try {
            if (respuesta) {
              this.borrarDatos()
              this.$validator.reset()
              this.$emit('correcto')
              return true
            }
          } catch (error) {
            this.$swal.fire(
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

    borrarDatos() {
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
