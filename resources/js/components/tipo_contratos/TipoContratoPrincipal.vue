<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h1 class="font-weight-bold">Tipos de Contratos</h1>
          <div class="float-sm-right text-zero">
            <button
              type="button"
              class="btn btn-link mr-1"
              @click="mostrarModal('tipoContrato',true)"
            >
              <i class="simple-icon-plus"></i> Nuevo Contrato
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <modal id="tipoContrato" ref="tipoContrato">
      <template slot="titulo">Agregar/Editar tipos de contratos</template>
      <template slot="contenido">
        <tipo-contrato-formulario ref="formulario" @recargar="getContratos"></tipo-contrato-formulario>
      </template>
    </modal>
    <!-- Modal -->

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
                  >Cantidad de Contratos: {{contratosDatos.length}}</span>
                </div>
              </div>
            </div>
            <div class="separator mb-5"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-sm">
              <thead class="bg-light">
                <tr role="row">
                  <th>Nombre</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody role="row">
                <tr v-for="(contrato, index) in contratosDatos" :key="index">
                  <td class="custom-label">{{ contrato.nombre}}</td>
                  <td class="text-center">
                    <template v-if="contrato.editable">
                      <a href="#" class="table-icon" @click.prevent="editContrato(contrato.id)">
                        <i class="simple-icon-note"></i>
                      </a>
                      <a href="#" class="table-icon" @click.prevent="deleteContrato(contrato.id)">
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
import TipoContratoFormulario from './TipoContratoFormulario'
import Modal from '../utiles/Modal'

export default {
  components: { TipoContratoFormulario, Modal },
  data() {
    return {
      contratosDatos: [],
      contratosDatosBuscador: [],
      buscador: '',
    }
  },

  created() {
    this.getContratos()
  },

  methods: {
    mostrarModal(modal, limpiarFormulario = false) {
      if (limpiarFormulario) {
        this.$refs.formulario.limpiarFormulario()
        this.$refs.formulario.$validator.reset()
      }
      this.$refs[modal].mostrarModal()
    },

    getContratos() {
      axios
        .get('/api/contratos/datos')
        .then(datos => {
          this.contratosDatos = this.contratosDatosBuscador = datos.data
        })
        .catch(error => {
          if (error.response) {
            this.$swal.fire(
              'Oops!',
              'Han  ocurrido errores, por favor intente más tarde',
              'error'
            )
          }
        })
    },

    editContrato(id) {
      const contrato = this.contratosDatos.find(contrato => {
        return contrato.id === id
      })
      this.$refs.formulario.lista = Object.assign({}, contrato)
      this.mostrarModal('tipoContrato')
    },

    deleteContrato(id) {
      this.$swal
        .fire({
          title: '¿Está seguro(a)?',
          text:
            'Asegúrese de haber cambiado los funcionarios a otro tipo de contrato, de lo contrario serán eliminados',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminarlo!',
        })
        .then(resultado => {
          if (resultado.value) {
            axios
              .delete(`/api/contratos/${id}/eliminar`)
              .then(respuesta => {
                this.getContratos()
                this.$swal.fire('Correcto!', respuesta.data.message, 'success')
              })
              .catch(error => {
                if (error.response) {
                  this.$swal.fire(
                    'Oops!',
                    'Han  ocurrido errores, por favor intente más tarde',
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
      let ct = null
      if (this.buscador !== null || this.buscador.length > 0) {
        ct = this.contratosDatosBuscador.filter(contrato => {
          return (
            contrato.nombre.toLowerCase().indexOf(this.buscador.toLowerCase()) >
            -1
          )
        })
      } else {
        this.contratosDatos = this.contratosDatosBuscador
      }

      this.contratosDatos = ct
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
