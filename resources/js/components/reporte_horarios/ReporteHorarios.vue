<template>
  <div v-if="renderizar" class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="font-weight-bold">Reporte de Horarios</h1>
      </div>
    </div>

    <div class="row">
      <div class="col-7">
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label class="custom-label">Fecha de inicio</label>
              <input type="date" v-model="fechaInicio" class="form-control custom-control" required>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label class="custom-label">Fecha de fin</label>
              <input type="date" v-model="fechaFin" class="form-control custom-control" required>
            </div>
          </div>
          <div class="col-md-2 mt-4 pt-1">
            <button class="btn btn-secondary default btn-xs" @click="filtrarByFecha">
              <i class="simple-icon-magnifier"></i> Filtrar
            </button>
          </div>
        </div>

        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label class="custom-label" for="filtroCentroCosto">Filtro Centro de Costos</label>
              <select
                name="filtroCentroCosto"
                v-model="filtroCentroCosto"
                class="form-control custom-control"
                @change="filtrarCentroCosto(filtroCentroCosto)"
              >
                <option value="todos">Todos</option>
                <option
                  v-for="(centro,index) in filtroReporteHorarios"
                  :key="index"
                  :value="centro.id"
                >{{centro.nombre}}</option>
              </select>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label class="custom-label" for="filtroDependencia">Filtro dependencias</label>
              <select
                name="filtroDependencia"
                v-model="filtroDependencia"
                class="form-control custom-control"
                :disabled="filtroCentroCosto == 'todos'"
              >
                <option value="todos">Todos</option>
                <option
                  v-for="(dependencia,index) in filtroDependencias"
                  :key="index"
                  :value="dependencia.id"
                >{{dependencia.nombre}}</option>
              </select>
            </div>
          </div>

          <div class="col-md-2 mt-4 pt-1">
            <button
              class="btn btn-secondary default btn-xs"
              @click="filtrar(filtroDependencia,filtroCentroCosto)"
            >
              <i class="simple-icon-magnifier"></i> Filtrar
            </button>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group row">
          <label class="custom-label col-md-6 text-right" for="tipo_turno">Tipo de turno actual</label>
          <select
            name="tipo_turno"
            v-model="tipoTurno"
            class="form-control custom-control col-md-6"
            @change="getReporteHorarios()"
          >
            <option value="rotativo">Turno Rotativo</option>
            <option value="fijo">Turno Fijo</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row" v-if="reporteHorarios.length">
      <div class="col-12 mt-1">
        <h2 class="font-weight-bold">Lista de Funcionarios</h2>

        <div class="card">
          <div class="card-body ml-4 mt-1">
            <div v-for="(centroCosto) in reporteHorarios" :key="centroCosto.id">
              <div class="row">
                <p class="mb-1 centro-nombre">{{centroCosto.nombre}}</p>

                <div
                  class="col-12 mb-2 pl-0"
                  v-for="(dependencia) in centroCosto.dependencias"
                  :key="dependencia.id"
                >
                  <p class="font-weight-bold mt-3">{{dependencia.nombre}}</p>

                  <div
                    v-for="(funcionario) in dependencia.funcionarios"
                    :key="funcionario.id"
                    class="funcionario-fila"
                  >
                    <div
                      class="d-flex flex-column flex-md-row justify-content-center align-items-center"
                    >
                      <div class="w-50 w-xs-100 mb-0">
                        <img :src="`/back/storage/app/public/${funcionario.image}`" alt="Imagen funcionario">
                        <span class="custom-label">{{funcionario.nombres}} {{funcionario.apellidos}}</span>
                      </div>
                      <div class="w-20 w-xs-100">
                        <button
                          class="btn btn-link"
                          @click="mostrarDetallesHorario(funcionario.id)"
                        >Detalles</button>
                      </div>

                      <p
                        v-if="mostrarHoras  && funcionario.tipo_turno == 'Rotativo'"
                        class="mb-1 text-muted w-30 w-xs-100 font-weight-bold"
                      >Horas trabajadas: {{funcionarioHorasTrabajadas(funcionario.diarios_turno_rotativo)}}</p>
                      <p
                        v-else-if="mostrarHoras  && funcionario.tipo_turno == 'Fijo'"
                        class="mb-1 text-muted w-30 w-xs-100 font-weight-bold"
                      >Horas trabajadas: {{funcionarioHorasTrabajadas(funcionario.diarios_turno_fijo)}}</p>
                    </div>

                    <template v-if="mostrarHoras  && funcionario.tipo_turno == 'Rotativo'">
                      <detalles-horario
                        :ref="'detalles'+funcionario.id"
                        :horarios="funcionario.diarios_turno_rotativo"
                        :index="funcionario.id"
                      ></detalles-horario>
                    </template>

                    <template v-else-if="mostrarHoras  && funcionario.tipo_turno == 'Fijo'">
                      <detalles-horario
                        :ref="'detalles'+funcionario.id"
                        :horarios="funcionario.diarios_turno_fijo"
                        :index="funcionario.id"
                      ></detalles-horario>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="alert alert-secondary">
      <p
        class="font-weight-bold text-center"
      >No existen reportes de horarios para este rango de fechas</p>
    </div>
  </div>
  <overlay v-else></overlay>
</template>

<script>
import DetallesHorario from './DetallesHorario'
import Overlay from '../utiles/Overlay'

export default {
  components: { DetallesHorario, Overlay },
  data() {
    return {
      fechaInicio: moment()
        .startOf('month')
        .format(moment.HTML5_FMT.DATE),
      fechaFin: moment()
        .endOf('month')
        .format(moment.HTML5_FMT.DATE),

      reporteHorarios: [],
      reporteHorariosRotativo: [],
      reporteHorariosFijo: [],
      mostrarHoras: false,
      renderizar: false,

      /** filtros */
      filtroReporteHorarios: [],
      filtroDependencias: [],
      filtroCentroCosto: 'todos',
      filtroDependencia: 'todos',

      /** Tipo de turno */
      tipoTurno: 'rotativo',
    }
  },

  created() {
    this.getAllData()
  },

  methods: {
    getAllData() {
      axios
        .all([this.getReporteHorariosRotativo(), this.getReporteHorariosFijo()])
        .then(
          axios.spread((horariosRotativo, horariosFijo) => {
            this.reporteHorariosRotativo = horariosRotativo.data
            this.reporteHorariosFijo = horariosFijo.data
            this.getReporteHorarios()
            this.mostrarHoras = this.renderizar = true
          })
        )
    },

    getReporteHorariosRotativo() {
      return axios.get(
        `/api/${localStorage.getItem('tenant')}/reporte/horarios/${this.fechaInicio}/${
          this.fechaFin
        }/turno_rotativo`
      )
    },

    getReporteHorariosFijo() {
      return axios.get(
        `/api/${localStorage.getItem('tenant')}/reporte/horarios/${this.fechaInicio}/${this.fechaFin}/turno_fijo`
      )
    },

    getReporteHorarios() {
      this.reporteHorarios = this.filtroReporteHorarios =
        this.tipoTurno === 'rotativo'
          ? this.reporteHorariosRotativo
          : this.reporteHorariosFijo
    },

    mostrarDetallesHorario(idFuncionario = null) {
      let horario = this.$children.find(child => {
        return child.index === idFuncionario
      })
      horario.estadoActivo = !horario.estadoActivo
    },

    funcionarioHorasTrabajadas(diarios = []) {
      let cantidadHorasTrabajadas = diarios.reduce((anterior, actual) => {
        return {
          cantidad_horas:
            Number.parseFloat(anterior.cantidad_horas) +
            Number.parseFloat(actual.cantidad_horas),
        }
      })
      return Number(cantidadHorasTrabajadas.cantidad_horas).toFixed(2)
    },

    /** Métodos de filtros */
    filtrarCentroCosto(idCentroCostos) {
      if (this.filtroCentroCosto === 'todos') {
        this.filtroDependencia = 'todos'
        return false
      }
      let centroCostos = this.filtroReporteHorarios.find(centro => {
        return centro.id == idCentroCostos
      })

      let dependencias = centroCostos.dependencias

      this.filtroDependencias = dependencias
    },

    filtrar(idDependencia, idCentroCostos) {
      if (
        this.filtroDependencia == 'todos' ||
        this.filtroCentroCosto == 'todos'
      ) {
        this.reporteHorarios = this.filtroReporteHorarios
        return false
      }

      let centroCosto = this.filtroReporteHorarios.find(centroCosto => {
        return centroCosto.id === idCentroCostos
      })

      let dependencia = centroCosto.dependencias.find(dependencia => {
        return dependencia.id === idDependencia
      })

      let datos = Array({
        id: idCentroCostos,
        nombre: centroCosto.nombre,
        dependencias: [dependencia],
      })

      this.reporteHorarios = datos
    },

    filtrarByFecha() {
      if (this.fechaInicio > this.fechaFin) {
        this.$swal.fire(
          'Error!',
          'La fecha inicial no se puede ser mayor que la final',
          'error'
        )
        return false
      }
      this.renderizar = false
      this.getAllData()
    },
  },
}
</script>

<style scoped>
.funcionario-fila {
  border-bottom: 1px solid #c0c0c0;
}

img {
  width: 38px;
  border-radius: 50%;
  padding: 5px;
}
.centro-nombre {
  font-weight: bold;
  font-family: 'Montserrat', sans-serif;
  text-transform: uppercase;
}
.container-spinner {
  height: 50%;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
