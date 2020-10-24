<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Cajas de Compensación</h1>
          <div class="float-sm-right text-zero">
            <button
              type="button"
              class="btn btn-link mr-1"
              @click="mostrarModal('compensacion',true)"
            >
              <i class="simple-icon-plus"></i> Caja de Compensación
            </button>
          </div>
        </div>
      </div>
    </div>

    <modal id="compensacion" ref="compensacion">
      <template slot="titulo">Agregar/Editar caja compensación</template>
      <template slot="contenido">
        <c-compensacion-formulario ref="formulario" @recargar="getCompensaciones"></c-compensacion-formulario>
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
                  >Cantidad de Cajas de Compensación: {{compensacionesDatos.length}}</span>
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
              <paginate
                ref="paginator"
                name="compensacionesDatos"
                :list="compensacionesDatos"
                :per="10"
                tag="tbody"
              >
                <tr v-for="(compensacion, index) in paginated('compensacionesDatos')" :key="index">
                  <td class="custom-label">{{ compensacion.nombre}}</td>
                  <td class="text-center custom-label">{{ compensacion.nit}}</td>
                  <td class="text-center">
                    <template v-if="compensacion.editable">
                      <a
                        href="#"
                        class="table-icon"
                        @click.prevent="editCompensacion(compensacion.id)"
                      >
                        <i class="simple-icon-note"></i>
                      </a>
                      <a
                        href="#"
                        class="table-icon"
                        @click.prevent="deleteCompensacion(compensacion.id)"
                      >
                        <i class="simple-icon-trash"></i>
                      </a>
                    </template>
                    <template v-else>
                      <span class="custom-label">No editable</span>
                    </template>
                  </td>
                </tr>
              </paginate>
            </table>
            <paginate-links
              for="compensacionesDatos"
              :show-step-links="true"
              :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"
            ></paginate-links>
            <small
              class="font-weight-bold"
              v-if="$refs.paginator"
            >Mostrando {{$refs.paginator.pageItemsCount}} resultados</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CCompensacionFormulario from './CCompensacionFormulario'
import Modal from '../utiles/Modal'

export default {
  components: { CCompensacionFormulario, Modal },
  data() {
    return {
      compensacionesDatos: [],
      compensacionesDatosBuscador: [],
      buscador: '',
      paginate: ['compensacionesDatos'],
    }
  },

  created() {
    this.getCompensaciones()
  },

  methods: {
    getCompensaciones() {
      axios.get('/api/compensaciones/datos').then(datos => {
        this.compensacionesDatos = this.compensacionesDatosBuscador = datos.data
      })
    },

    editCompensacion(id) {
      const compensacion = this.compensacionesDatos.find(compensacion => {
        return compensacion.id === id
      })
      this.$refs.formulario.lista = Object.assign({}, compensacion)
      this.mostrarModal('compensacion')
    },

    mostrarModal(modal, limpiarDatos = false) {
      if (limpiarDatos) {
        this.$refs.formulario.limpiarDatos()
        this.$refs.formulario.$validator.reset()
      }
      this.$refs[modal].mostrarModal()
    },

    deleteCompensacion(id) {
      this.confirmacionUsuario().then(resultado => {
        if (resultado.value) {
          axios
            .delete(`/api/compensaciones/${id}/eliminar`)
            .then(respuesta => {
              this.getCompensaciones()
              this.$swal.fire('Correcto!', respuesta.data.message, 'success')
            })
            .catch(error => {
              if (error.response) {
                this.$swal(
                  'Error!',
                  'Han ocurrido errores, por favor intente más tarde',
                  'error'
                )
              }
            })
        }
      })
    },
    confirmacionUsuario() {
      return this.$swal.fire({
        title: '¿Está seguro(a)?',
        text:
          'Asegúrese de haber movido los funcionarios a otra caja de compensación, de lo contrario serán eliminados',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si,eliminarlo!',
      })
    },
  },

  watch: {
    buscador() {
      let cp = null
      if (this.buscador !== null || this.buscador.length > 0) {
        cp = this.compensacionesDatosBuscador.filter(compensacion => {
          return (
            compensacion.nombre
              .toLowerCase()
              .indexOf(this.buscador.toLowerCase()) > -1
          )
        })
      } else {
        this.compensacionesDatos = this.compensacionesDatosBuscador
      }
      this.compensacionesDatos = cp
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
