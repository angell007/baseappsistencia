<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Centros de Costos</h1>
          <div class="float-sm-right text-zero">
            <button
              type="button"
              class="btn btn-link mr-1"
              @click="mostrarModal('centroCostos',true)"
            >
              <i class="simple-icon-plus"></i> Nuevo centro de costos
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <modal id="centroCostos" ref="centroCostos" :esLg="false">
              <template slot="titulo">Agregar/Editar centro de costos</template>
              <template slot="contenido">
                <centro-costos-formulario ref="formulario" @recargar="cargarCentrosCostos()"></centro-costos-formulario>
              </template>
            </modal>

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
                  >Cantidad de Centros de Costos: {{totalCentros}}</span>
                </div>
              </div>
            </div>
            <div class="separator mb-5"></div>
          </div>
        </div>
        <div class="row" v-if="centrosCostos.length">
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-sm">
              <thead class="bg-light">
                <tr>
                  <th>Nombre</th>
                  <th class="text-center">Código</th>
                  <th class="text-center">Prefijo cuenta contable</th>
                  <th class="text-center"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(centro, index) in centrosCostos" :key="index">
                  <td class="custom-label">{{ centro.nombre}}</td>
                  <td class="text-center custom-label">{{ centro.codigo}}</td>
                  <td class="text-center custom-label">{{ centro.prefijo_cuenta_contable}}</td>
                  <td style class="text-center">
                    <a href="#" class="table-icon" @click.prevent="editarCentroCostos(centro.id)">
                      <i class="simple-icon-note"></i>
                    </a>
                    <a href="#" class="table-icon" @click.prevent="eliminarCentroCostos(centro.id)">
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
          >No existen centros de costos actualmente, para empezar a agregarlos vaya a la opción "Nuevo centro de costos" en la parte superior derecha</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CentroCostosFormulario from './CentroCostosFormulario'
import Modal from '../utiles/Modal'

export default {
  components: { CentroCostosFormulario, Modal },
  data() {
    return {
      centrosCostos: [],
      centrosCostosBuscador: [],
      buscador: '',
    }
  },
  created() {
    this.cargarCentrosCostos()
  },
  methods: {
    cargarCentrosCostos() {
      axios
        .get('/api/centros_costos/datos')
        .then(datos => {
          this.centrosCostos = this.centrosCostosBuscador = datos.data
        })
        .catch(error => {
          if (error.response.status === 400) {
            this.$swal.fire(
              'Error!',
              'No se encuentra autorizado para ver está página',
              'error'
            )
            this.$router.push({ name: 'TableroPrincipal' })
          }
        })
    },

    editarCentroCostos(id) {
      const centro = this.centrosCostos.find(centro => {
        return centro.id === id
      })
      this.$refs.formulario.lista = Object.assign({}, centro)
      this.mostrarModal('centroCostos')
    },

    eliminarCentroCostos(id) {
      this.$swal
        .fire({
          title: '¿Está seguro(a)?',
          text:
            'Asegúrese de haber movido los funcionarios a otro centro, de lo contrario serán eliminados',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si,eliminarlo!',
        })
        .then(resultado => {
          if (resultado.value) {
            axios
              .delete(`/api/centros_costos/${id}/eliminar`)
              .then(respuesta => {
                this.cargarCentrosCostos()
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
    mostrarModal(modal, limpiar = false) {
      if (limpiar) {
        this.$refs.formulario.limpiarFormulario()
        this.$refs.formulario.$validator.reset()
      }
      this.$refs[modal].mostrarModal()
    },
  },

  computed: {
    totalCentros() {
      return this.centrosCostos.length
    },
  },

  watch: {
    buscador() {
      let gp = null
      if (this.buscador !== null || this.buscador.length > 0) {
        gp = this.centrosCostosBuscador.filter(centro => {
          return (
            centro.nombre.toLowerCase().indexOf(this.buscador.toLowerCase()) >
            -1
          )
        })
      } else {
        this.centrosCostos = this.centrosCostosBuscador
      }

      this.centrosCostos = gp
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
