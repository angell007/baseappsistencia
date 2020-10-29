<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card-custom mb-4">
          <div class="card-body">
            <form @submit.prevent>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label class="custom-label" for="nombre_empresa">Empresa</label>
                  <input
                    type="text"
                    name="nombre_empresa"
                    v-validate="'required|min:3'"
                    data-vv-as="Empresa"
                    class="form-control custom-control"
                    placeholder="Nombre de la empresa"
                    v-model="lista.nombre_empresa"
                  >
                  <small
                    class="invalid"
                    v-if="errors.has('nombre_empresa')"
                  >{{errors.first('nombre_empresa')}}</small>
                </div>
                <div class="form-group col-md-4">
                  <label class="custom-label" for="cargo">Cargo</label>
                  <input
                    type="text"
                    name="cargo"
                    v-validate="'alpha|min:3|max:50'"
                    data-vv-as="Cargo"
                    class="form-control custom-control"
                    placeholder="Cargo"
                    v-model="lista.cargo"
                  >
                  <small class="invalid" v-if="errors.has('cargo')">{{errors.first('cargo')}}</small>
                </div>

                <div class="form-group col-md-4">
                  <label class="custom-label" for="telefono_empresa">Teléfono de la Empresa</label>
                  <input
                    type="text"
                    name="telefono_empresa"
                    v-validate="'required|numeric|max:10|min:6'"
                    data-vv-as="Télefono de la empresa"
                    class="form-control custom-control"
                    placeholder="Télefono de la Empresa"
                    v-model="lista.telefono_empresa"
                  >
                  <small
                    class="invalid"
                    v-if="errors.has('telefono_empresa')"
                  >{{errors.first('telefono_empresa')}}</small>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label class="custom-label" for="fecha_ingreso">Fecha de Ingreso</label>
                  <calendario :borrado="true"></calendario>
                </div>
                <div class="form-group col-md-4">
                  <label class="custom-label" for="fecha_retiro">Fecha de Retiro</label>
                  <calendario :borrado="true"></calendario>
                  <small
                    class="invalid"
                    v-if="errors.has('fecha_retiro')"
                  >{{errors.first('fecha_retiro')}}</small>
                </div>
                <div class="form-group col-md-4">
                  <label class="custom-label" for="nombre_jefe">Jefe Inmediato</label>
                  <input
                    type="text"
                    name="nombre_jefe"
                    v-validate="'alpha|min:3'"
                    class="form-control custom-control"
                    placeholder="Nombre del Jefe inmediato"
                    v-model="lista.nombre_jefe"
                  >
                  <small
                    class="invalid"
                    v-if="errors.has('nombre_jefe')"
                  >{{errors.first('nombre_jefe')}}</small>
                </div>
              </div>
              <div class="form-group">
                <label class="custom-label" for="labores">Labores Realizadas</label>
                <textarea
                  name="labores"
                  v-validate="'alpha|max:150|min:5'"
                  data-vv-as="Labores realizadas"
                  cols="30"
                  rows="10"
                  class="form-control custom-control"
                  v-model="lista.labores"
                ></textarea>
                <small class="invalid" v-if="errors.has('labores')">{{errors.first('labores')}}</small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Calendario from '../../../utiles/Calendario'
export default {
  components: { Calendario },
  data() {
    return {
      funcionario_identidad: '',
      lista: {
        id: '',
        funcionario_id: '',
        nombre_empresa: '',
        cargo: '',
        fecha_ingreso: '',
        fecha_retiro: '',
        labores: '',
        nombre_jefe: '',
        telefono_empresa: '',
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
    async guardarExperiencia() {
      let validado = await this.validarAntesDeEnviar()
      if (validado) {
        if (!this.lista.id) {
          let respuesta = await axios.post(
            `/api/${localStorage.getItem('tenant')}/funcionarios/${this.funcionario_identidad}/experiencia/crear`,
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
