<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Cargos</h1>
          <div class="float-sm-right text-zero">
            <button type="button" class="btn btn-link mr-1" @click="mostrarModal('cargo',true)">
              <i class="simple-icon-plus"></i> Nuevo Cargo
            </button>
          </div>
        </div>
      </div>
    </div>

    <modal id="cargo" ref="cargo">
      <template slot="titulo">Agregar/Editar cargo</template>
      <template slot="contenido">
        <cargo-formulario ref="formulario" @recargar="cargarCargos"></cargo-formulario>
      </template>
    </modal>

    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="mb-2">
              <a
                class="btn pt-0 pl-0 d-inline-block d-md-none"
                data-toggle="collapse"
                href="#displayOptions"
                role="button"
                aria-expanded="true"
                aria-controls="displayOptions"
              >
                Display Options
                <i class="simple-icon-arrow-down align-middle"></i>
              </a>
              <div class="collapse d-md-block" id="displayOptions">
                <div class="d-block d-md-inline-block">
                  <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                    <input placeholder="Buscar..." v-model="buscador">
                  </div>
                </div>
                <div class="float-md-right" style="margin-right: 1rem;">
                  <span class="text-muted text-small">Cantidad de Cargos: {{totalCargos}}</span>
                </div>
              </div>
            </div>
            <div class="separator mb-5"></div>

            <div class="row" v-if="cargosDatos.length">
              <div class="col-md-12">
                <table class="table table-bordered table-striped table-sm">
                  <thead class="bg-light">
                    <tr>
                      <th>Nombre</th>
                      <th class="text-center">Dependencia</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(cargo, index) in cargosDatos" :key="index">
                      <td class="custom-label">{{ cargo.nombre}}</td>
                      <td class="custom-label text-center">{{ cargo.dependencia.nombre}}</td>
                      <td class="text-center">
                        <a href="#" class="table-icon" @click.prevent="editarCargo(cargo.id)">
                          <i class="simple-icon-note"></i>
                        </a>
                        <a href="#" class="table-icon" @click.prevent="eliminarCargo(cargo.id)">
                          <i class="simple-icon-trash"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="alert alert-secondary" v-else>
              <p
                class="font-weight-bold text-center"
              >No existen cargos actualmente, para empezar a agregarlos vaya a la opción "Nuevo cargo" en la parte superior derecha</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CargoFormulario from './CargoFormulario'
import Modal from '../utiles/Modal'

export default {
  components: { CargoFormulario, Modal },
  data() {
    return {
      cargosDatos: [],
      cargosDatosBuscador: [],
      buscador: '',
    }
  },

  created() {
    this.cargarCargos()
  },

  methods: {
    mostrarModal(modal, limpiar) {
      if (limpiar) {
        this.$refs.formulario.limpiarFormulario()
        this.$refs.formulario.$validator.reset()
        this.$refs.formulario.dependenciaObjeto = null
      }
      this.$refs.cargo.mostrarModal()
    },

    cargarCargos() {
      axios.get(`/api/${localStorage.getItem('tenant')}/cargos/datos`).then(datos => {
        this.cargosDatos = this.cargosDatosBuscador = datos.data
      })
    },

    editarCargo(id) {
      const cargo = this.cargosDatos.find(cargo => {
        return cargo.id === id
      })
      this.$refs.formulario.lista = Object.assign({}, cargo)
      this.$refs.formulario.asignarDependencia(cargo.dependencia_id)
      this.mostrarModal('cargo')
    },

    eliminarCargo(id) {
      this.$swal
        .fire({
          title: '¿Está seguro(a)?',
          text:
            'Asegúrese de haber movido los funcionarios a otro cargo, de lo contrario serán eliminados',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si,eliminarlo!',
        })
        .then(resultado => {
          if (resultado.value) {
            axios
              .delete(`/api/${localStorage.getItem('tenant')}/cargos/${id}/eliminar`)
              .then(respuesta => {
                this.cargarCargos()
                this.$swal.fire('Correcto!', respuesta.data.message, 'success')
              })
              .catch(error => {
                this.$swal.fire(
                  'Oops!',
                  'Han ocurrido errores, por favor intente más tarde',
                  'error'
                )
              })
          }
        })
    },
    getNombreCargo(id) {
      const dependencia = this.$refs.formaComponent.dependenciasDatos.find(
        dp => {
          return dp.id === id
        }
      )

      return dependencia.nombre
    },
  },
  computed: {
    totalCargos() {
      return this.cargosDatos.length
    },
  },
  watch: {
    buscador() {
      let dp = null
      if (this.buscador !== null || this.buscador.length > 0) {
        dp = this.cargosDatosBuscador.filter(cargo => {
          return (
            cargo.nombre.toLowerCase().indexOf(this.buscador.toLowerCase()) > -1
          )
        })
      } else {
        this.cargosDatos = this.cargosDatosBuscador
      }

      this.cargosDatos = dp
    },
  },
}
</script>

<style scoped>
table thead th {
  width: 25%;
}
.table-icon {
  font-weight: 700;
  margin: 0 10px;
  color: #2a93d5;
  font-size: 0.95rem;
}
</style>
