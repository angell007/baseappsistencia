<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Fondos de Cesantías</h1>
          <div class="float-sm-right text-zero">
            <button type="button" class="btn btn-link mr-1" @click="mostrarModal('cesantias',true)">
              <i class="simple-icon-plus"></i> Nuevo fondo de cesantías
            </button>
          </div>
        </div>
      </div>
    </div>

    <modal id="cesantias" ref="cesantias">
      <template slot="titulo">Agregar/Editar fondo de cesantías</template>
      <template slot="contenido">
        <cesantias-formulario ref="formulario" @recargar="getCesantias"></cesantias-formulario>
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
                  >Cantidad de Fondo de Cesantías: {{cesantiasDatos.length}}</span>
                </div>
              </div>
            </div>
            <div class="separator mb-5"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table
              class="table table-bordered table-striped table-sm"
              role="grid"
              v-if="cesantiasDatos.length"
            >
              <thead class="bg-light">
                <tr role="row">
                  <th>Nombre</th>
                  <th class="text-center">NIT</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody role="row">
                <tr v-for="(cesantia, index) in cesantiasDatos" :key="index">
                  <td class="custom-label">{{ cesantia.nombre}}</td>
                  <td class="text-center custom-label">{{ cesantia.nit}}</td>
                  <td style="width:100px" class="text-center">
                    <template v-if="cesantia.editable">
                      <a href="#" class="table-icon" @click.prevent="editCesantia(cesantia.id)">
                        <i class="simple-icon-note"></i>
                      </a>
                      <a href="#" class="table-icon" @click.prevent="deleteCesantia(cesantia.id)">
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
            <div class="alert alert-secondary" v-else>
              <p class="font-weight-bold">No existen actualmente fondos de cesantías.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CesantiasFormulario from './CesantiasFormulario'
import Modal from '../utiles/Modal'

export default {
  components: { CesantiasFormulario, Modal },
  data() {
    return {
      cesantiasDatos: [],
      cesantiasDatosBuscador: [],
      buscador: '',
    }
  },

  created() {
    this.getCesantias()
  },

  methods: {
    mostrarModal(modal, limpiarDatos = false) {
      if (limpiarDatos) {
        this.$refs.formulario.limpiarDatos()
        this.$refs.formulario.$validator.reset()
      }
      this.$refs[modal].mostrarModal()
    },

    getCesantias() {
      axios.get(`/api/${localStorage.getItem('tenant')}/cesantias/datos`).then(datos => {
        this.cesantiasDatos = this.cesantiasDatosBuscador = datos.data
      })
    },

    editCesantia(id) {
      const cesantia = this.cesantiasDatos.find(cesantia => {
        return cesantia.id === id
      })
      this.$refs.formulario.lista = Object.assign({}, cesantia)
      this.mostrarModal('cesantias')
    },

    deleteCesantia(id) {
      this.$swal
        .fire({
          title: '¿Está seguro(a)?',
          text:
            'Asegúrese de haber movido los funcionarios a otro fondo de cesantias, de lo contrario serán eliminados',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si,eliminarlo!',
        })
        .then(resultado => {
          if (resultado.value) {
            axios.delete(`/api/${localStorage.getItem('tenant')}/cesantias/${id}/eliminar`).then(respuesta => {
              this.getCesantias()
              this.$swal.fire('Correcto!', respuesta.data.message, 'success')
            })
          }
        })
    },
  },

  watch: {
    buscador() {
      let ct = null
      if (this.buscador !== null || this.buscador.length > 0) {
        ct = this.cesantiasDatosBuscador.filter(cesantia => {
          return (
            cesantia.nombre.toLowerCase().indexOf(this.buscador.toLowerCase()) >
            -1
          )
        })
      } else {
        this.cesantiasDatos = this.cesantiasDatosBuscador
      }

      this.cesantiasDatos = ct
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
