<template>
  <div>
    <div class="row mb-3">
      <div class="col-md-6">
        <h3 class="font-weight-bold">Lista de turnos rotativos</h3>
      </div>
      <div class="col-md-6 text-right">
        <button type="button" class="btn btn-link btn-sm mr-1" @click="mostrarModal">
          <i class="simple-icon-plus"></i>
          Crear nuevo turno rotativo
        </button>
      </div>
    </div>

    <div
      class="modal fade"
      id="rotativoFormulario"
      tabindex="-1"
      role="dialog"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Nuevo turno</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <turno-rotativo-formulario
              ref="rotativoFormulario"
              @recargar="getTurnosRotativos"
              @cerrar="cerrarModal"
            ></turno-rotativo-formulario>
          </div>
        </div>
      </div>
    </div>

    <div class="card" v-if="turnosRotativosDatos.length">
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
                  <span
                    class="text-muted text-small"
                  >Cantidad de Turnos:{{ turnosRotativosDatos.length}}</span>
                </div>
              </div>
            </div>
            <div class="separator mb-5"></div>

            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-striped table-sm">
                  <thead class="bg-light">
                    <tr>
                      <th>Nombre</th>
                      <th class="text-center">Hora de Inicio</th>
                      <th class="text-center">Hora de Fin</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(turnoRotativo, index) in turnosRotativosDatos" :key="index">
                      <td class="custom-label">{{ turnoRotativo.nombre}}</td>
                      <td class="text-center custom-label">{{ turnoRotativo.hora_inicio_uno}}</td>
                      <td class="text-center custom-label">{{ turnoRotativo.hora_fin_uno}}</td>
                      <td class="text-center">
                        <button
                          class="btn btn-link btn-xs dropdown-toggle"
                          type="button"
                          data-toggle="dropdown"
                        >Acciones</button>

                        <div class="dropdown-menu" x-placement="bottom-start">
                          <a class="dropdown-item" @click="editTurnoRotativo(turnoRotativo.id)">
                            <i class="simple-icon-note"></i> Editar
                          </a>
                          <a class="dropdown-item" @click="deleteTurnoRotativo(turnoRotativo.id)">
                            <i class="simple-icon-trash"></i> Eliminar
                          </a>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <p
        class="alert alert-secondary font-weight-bold"
      >No existen turnos actualmente en la compañía, para agregar uno vaya a la opción "Crear nuevo turno rotativo"</p>
    </div>
  </div>
</template>

<script>
import TurnoRotativoFormulario from './TurnoRotativoFormulario'

export default {
  components: { TurnoRotativoFormulario },
  data() {
    return {
      buscador: '',
      turnosRotativosDatos: [],
      turnosRotativosDatosBuscador: [],
    }
  },

  created() {
    this.getTurnosRotativos()
  },

  methods: {
    getTurnosRotativos() {
      axios.get(`/api/${localStorage.getItem('tenant')}/turnos/rotativos/datos`).then(datos => {
        this.turnosRotativosDatos = this.turnosRotativosDatosBuscador =
          datos.data
      })
    },

    editTurnoRotativo(id) {
      const turnoRotativo = this.turnosRotativosDatos.find(turnoRotativo => {
        return turnoRotativo.id === id
      })

      this.$refs.rotativoFormulario.lista = Object.assign({}, turnoRotativo)

      $('#rotativoFormulario').modal({
        backdrop: 'static',
        keyboard: false,
      })
    },

    deleteTurnoRotativo(id) {
      this.$swal
        .fire({
          title: '¿Está seguro(a)?',
          text:
            'Asegúrese de haber movido los funcionarios a otro turno, si existen en el turno actual serán eliminados',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminarlo!',
          cancelButtonText: 'Cancelar',
        })
        .then(respuesta => {
          if (respuesta.value) {
            axios
              .delete(`/api/${localStorage.getItem('tenant')}/turnos/${id}/rotativo/eliminar`)
              .then(respuesta => {
                this.$swal.fire(
                  'Eliminado',
                  'El turno ha sido eliminado correctamente',
                  'success'
                )
              })
            this.getTurnosRotativos()
          }
        })
    },

    mostrarModal() {
      this.$refs.rotativoFormulario.limpiarDatos()
      this.$refs.rotativoFormulario.$validator.reset()
      $('#rotativoFormulario').modal({
        backdrop: 'static',
        keyboard: false,
      })
    },

    cerrarModal() {
      $('#rotativoFormulario').modal('hide')
    },
  },
}
</script>
