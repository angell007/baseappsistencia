<template>
  <div class="container" v-if="renderizar">
    <div class="row mb-3">
      <div class="col-md-6">
        <h3 class="font-weight-bold">Lista de turnos fijos</h3>
      </div>
      <div class="col-md-6 text-right">
        <router-link to="/turnos/fijos" class="btn btn-link btn-sm mr-1">
          <i class="simple-icon-plus"></i>
          Crear Nuevo turno fijo
        </router-link>
      </div>
    </div>

    <div class="card" v-if="turnosFijos.length">
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
                  <span class="text-muted text-small">Cantidad de Turnos:{{ turnosFijos.length}}</span>
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
                      <th class="text-center">Horario Semana</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(turnoFijo, index) in turnosFijos" :key="index">
                      <td class="custom-label">{{ turnoFijo.nombre}}</td>
                      <td class="text-center">
                        <button
                          type="button"
                          class="btn btn-link btn-xs"
                          @click="mostrarTurnoFijo(turnoFijo.id)"
                        >
                          <i class="simple-icon-eye"></i>
                        </button>

                        <div
                          class="modal fade"
                          id="horaTurnoFijo"
                          tabindex="-1"
                          role="dialog"
                          style="display: none;"
                          aria-hidden="true"
                        >
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Información de horario</h5>
                                <button
                                  type="button"
                                  class="close"
                                  data-dismiss="modal"
                                  aria-label="Close"
                                >
                                  <span aria-hidden="true">×</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <table>
                                  <thead>
                                    <tr>
                                      <th class="custom-label">Día</th>
                                      <th class="custom-label">Entrada 1</th>
                                      <th class="custom-label">Salida 1</th>
                                      <th class="custom-label">Entrada 2</th>
                                      <th class="custom-label">Salida 2</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr
                                      v-for="(horaTurno, index) in horariosTurnoFijo"
                                      :key="index"
                                    >
                                      <td class="custom-label">{{ horaTurno.dia}}</td>
                                      <td class="custom-label">{{ horaTurno.hora_inicio_uno}}</td>
                                      <td class="custom-label">{{ horaTurno.hora_fin_uno}}</td>
                                      <td class="custom-label">{{ horaTurno.hora_inicio_dos}}</td>
                                      <td class="custom-label">{{ horaTurno.hora_fin_dos}}</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="text-center">
                        <button
                          class="btn btn-link btn-xs dropdown-toggle"
                          type="button"
                          data-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >Acciones</button>

                        <div class="dropdown-menu">
                          <a class="dropdown-item" @click="editTurnoFijo(turnoFijo.id)">
                            <i class="simple-icon-note"></i> Editar
                          </a>
                          <a class="dropdown-item" @click="deleteTurnoFijo(turnoFijo.id)">
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
    <div class="alert alert-secondary text-center" v-else>
      <p class="font-weight-bold">No existen turnos fijos actualmente.</p>
    </div>
  </div>
  <overlay v-else></overlay>
</template>

<script>
import TurnoFijoFormulario from './TurnoFijoFormulario'
import Overlay from '../utiles/Overlay'

export default {
  components: { TurnoFijoFormulario, Overlay },
  data() {
    return {
      buscador: '',
      turnosFijos: [],
      turnosFijosBuscador: [],
      horariosTurnoFijo: [],
      renderizar: false,
    }
  },

  created() {
    this.getTurnosFijos()
  },

  methods: {
    getTurnosFijos() {
      axios.get(`/api/turnos/fijos/datos`).then(datos => {
        this.turnosFijos = this.turnosFijosBuscador = datos.data
        this.renderizar = true
      })
    },

    editTurnoFijo(id) {
      const turnoFijo = this.turnosFijos.find(turnoFijo => {
        return turnoFijo.id === id
      })

      this.$router.push({
        name: 'TurnoFijoFormulario',
        params: { turno: turnoFijo },
      })
    },

    deleteTurnoFijo(id) {
      if (confirm('¿Seguro que desea borrar el turno')) {
        axios.delete(`/api/turnos/${id}/fijo/eliminar`).then(respuesta => {})
        this.getTurnosFijos()
      }
    },

    mostrarTurnoFijo(turnoId) {
      if (this.horariosTurnoFijo.length) {
        $('#horaTurnoFijo').modal({
          backdrop: 'static',
          keyboard: false,
        })
        return false
      }
      axios.get(`/api/horario/turno_fijo/datos/${turnoId}`).then(datos => {
        this.horariosTurnoFijo = datos.data
        $('#horaTurnoFijo').modal({
          backdrop: 'static',
          keyboard: false,
        })
      })
    },
  },
}
</script>

<style scoped>
i.simple-icon-eye {
  font-size: 0.9rem;
  font-weight: bold;
}
</style>

