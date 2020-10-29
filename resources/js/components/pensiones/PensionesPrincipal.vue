<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Fondos de Pensiones</h1>
          <div class="float-sm-right text-zero">
            <button type="button" class="btn btn-link mr-1" @click="mostrarModal('pensiones',true)">
              <i class="simple-icon-plus"></i> Nuevo fondo de Pensiones
            </button>
          </div>
        </div>
      </div>
    </div>

    <modal id="pensiones" ref="pensiones">
      <template slot="titulo">Agregar/Editar fondo de pensiones</template>
      <template slot="contenido">
        <pension-formulario ref="formulario" @recargar="getPensiones"></pension-formulario>
      </template>
    </modal>

    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="mb-2">
              <a
                class="btn pt-0 pl-0 d-inline-block d-md-none"
                data-toggle="collapse"
                href="#displayOptions"
                role="button"
                aria-expanded="true"
                aria-controls="displayOptions"
              >
                Mostrar Opciones
                <i class="simple-icon-arrow-down align-middle"></i>
              </a>
              <div class="collapse d-md-block" id="displayOptions">
                <div class="d-block d-md-inline-block">
                  <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                    <input placeholder="Buscar..." v-model="buscador">
                  </div>
                </div>
                <div class="float-md-right" style="margin-right: 1rem;">
                  <span
                    class="text-muted text-small"
                  >Cantidad de Fondo de Pensiones: {{pensionesDatos.length}}</span>
                </div>
              </div>
            </div>
            <div class="separator mb-5"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-sm" role="grid">
              <thead class="bg-light">
                <tr role="row">
                  <th>Nombre</th>
                  <th class="text-center">NIT</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody role="row">
                <tr v-for="(pension, index) in pensionesDatos" :key="index">
                  <td class="custom-label">{{ pension.nombre}}</td>
                  <td class="text-center custom-label">{{ pension.nit}}</td>
                  <td class="text-center">
                    <template v-if="pension.editable">
                      <a href="#" class="table-icon" @click.prevent="editPension(pension.id)">
                        <i class="simple-icon-note"></i>
                      </a>
                      <a href="#" class="table-icon" @click.prevent="deletePension(pension.id)">
                        <i class="simple-icon-trash"></i>
                      </a>
                    </template>
                    <template v-else>
                      <span class="custom-label">No editable</span>
                    </template>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PensionFormulario from './PensionFormulario'
import Modal from '../utiles/Modal'

export default {
  components: { PensionFormulario, Modal },
  data() {
    return {
      pensionesDatos: [],
      pensionesDatosBuscador: [],
      buscador: '',
    }
  },

  created() {
    this.getPensiones()
  },

  methods: {
    mostrarModal(modal, limpiarDatos = false) {
      if (limpiarDatos) {
        this.$refs.formulario.limpiarDatos()
        this.$refs.formulario.$validator.reset()
      }
      this.$refs[modal].mostrarModal()
    },

    getPensiones() {
      axios.get(`/api/${localStorage.getItem('tenant')}/pensiones/datos`).then(datos => {
        this.pensionesDatos = this.pensionesDatosBuscador = datos.data
      })
    },

    editPension(id) {
      const pension = this.pensionesDatos.find(pension => {
        return pension.id === id
      })
      this.$refs.formulario.lista = Object.assign({}, pension)
      this.mostrarModal('pensiones')
    },

    deletePension(id) {
      this.$swal
        .fire({
          title: '¿Está seguro(a)?',
          text:
            'Asegúrese de haber movido los funcionarios a otro fondo de pensiones, de lo contrario serán eliminados',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si,eliminarlo!',
        })
        .then(resultado => {
          if (resultado.value) {
            axios
              .delete(`/api/pensiones/${id}/eliminar`)
              .then(respuesta => {
                this.getPensiones()
                this.$swal.fire('Correcto!', respuesta.data.message, 'success')
              })
              .catch(error => {
                if (error.response) {
                  this.$swal.fire(
                    'Error!',
                    'Ha ocurrido un error, por favor intente más tarde',
                    'error'
                  )
                }
              })
          }
        })
    },
  },

  watch: {
    buscador() {
      let ps = null
      if (this.buscador !== null || this.buscador.length > 0) {
        ps = this.pensionesDatosBuscador.filter(pension => {
          return (
            pension.nombre.toLowerCase().indexOf(this.buscador.toLowerCase()) >
            -1
          )
        })
      } else {
        this.pensionesDatos = this.pensionesDatosBuscador
      }

      this.pensionesDatos = ps
    },
  },
}
</script>

<style scoped>
.table-icon {
  font-weight: 700;
  margin: 0 10px;
  color: #2a93d5;
  font-size: 0.95rem;
}
</style>
