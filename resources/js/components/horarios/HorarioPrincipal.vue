<template>
  <div class="container" v-if="renderizar">
    <h1 class="row font-weight-bold">Asignación de Horarios</h1>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="centroCosto" class="custom-label">Filtrar por centro de costos</label>
          <select
            name="centroCosto"
            class="form-control custom-control"
            v-model="filtroCentrosCosto"
            @change="filtrarCentroCostos(filtroCentrosCosto)"
          >
            <option value="todos">Todos</option>
            <option
              v-for="(centro,index) in datosGenerales"
              :key="index"
              :value="centro.id"
            >{{centro.nombre}}</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="dependencia" class="custom-label">Filtrar por dependencia</label>
          <select
            name="dependencia"
            class="form-control custom-control"
            v-model="filtroDependencia"
            :disabled="filtroCentrosCosto == 'todos'"
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
      <div class="col-md-2 mt-1">
        <div class="row mt-4">
          <button
            class="btn btn-secondary default btn-xs"
            @click="filtrar(filtroDependencia,filtroCentrosCosto)"
          >
            <i class="simple-icon-magnifier"></i> Filtrar
          </button>
        </div>
      </div>
      <div class="col-md-3 offset-1">
        <input
          type="week"
          name="semana"
          class="form-control custom-control text-center"
          v-model="semana"
          @change="makeRequestBySemana(semana)"
          required
        >
      </div>
    </div>

    <template v-if="datosGenerales.length">
      <div class="card" v-for="centroCosto in datosGenerales" :key="centroCosto.id">
        <div class="card-title custom-label pl-3 pt-3 mb-1">{{centroCosto.nombre}}</div>
        <div class="card-body">
          <div v-for="dependencia in centroCosto.dependencias" :key="dependencia.id">
            <p class="custom-label">{{dependencia.nombre}}</p>
            <!-- v-for="funcionario in dependencia.funcionarios" -->
            <semana

              :funcionarios="dependencia.funcionarios"
              :turnosRotativos="turnos"
              :diaInicial="diaInicialSemana"
              :diaFinal="diaFinalSemana"
              @asignados="postHorariosTurno"
            ></semana>
          </div>
        </div>
      </div>
    </template>
    <div class="alert alert-secondary" v-else>
      <p
        class="font-weight-bold text-center"
      >Aún no existen centros de costos, puede agregarlos desde el menú "Configuración"</p>
    </div>
  </div>
  <overlay v-else></overlay>
</template>

<script>
import Overlay from '../utiles/Overlay'
import HorarioSemana from './HorarioSemana'
import Semana from './Semana'

export default {
  components: { HorarioSemana, Semana, Overlay },
  data() {
    return {
      renderizar: false,
      datosGenerales: [],
      datosGeneralesFiltro: [],
      turnos: [],
      semana: moment().format(moment.HTML5_FMT.WEEK),
      numeroSemana: moment().week(),
      diaInicialSemana: moment().startOf('week'),
      diaFinalSemana: moment().endOf('week'),
      horariosPostPromises: [],
      /** Filtros */
      filtroCentrosCosto: 'todos',
      filtroDependencia: 'todos',
      filtroDependencias: [],
    }
  },

  created() {
    this.getAllData()
  },

  methods: {
    getAllData() {
      axios
        .all([
          axios(`/api/horarios/datos/generales/${this.numeroSemana}`),
          axios('/api/turnos/rotativos/datos'),
        ])
        .then(
          axios.spread((datosGenerales, turnos) => {
            this.datosGenerales = this.datosGeneralesFiltro =
              datosGenerales.data
            this.turnos = turnos.data
            this.renderizar = true
          })
        )
    },
    /** Guardar datos de horario en Base de Datos */
    postHorariosTurno(horarios = []) {
      horarios.forEach(horario => {
        this.horariosPostPromises.push(this.postHorario(horario))
      })
      axios.all(this.horariosPostPromises).then(respuesta => {
        this.renderizar = false
        this.getAllData()
      })
    },

    postHorario(horario) {
      axios.post('/api/horario/turno_rotativo/crear', horario)
    },

    makeRequestBySemana(semana) {
      this.numeroSemana = moment(semana).week()
      this.diaInicialSemana = moment(semana).startOf('week')
      this.diaFinalSemana = moment(semana).endOf('week')
      this.renderizar = false
      this.getAllData()
    },

    /** Filtros de búsqueda  */
    filtrarCentroCostos(idCentroCosto) {
      if (idCentroCosto == 'todos') {
        this.filtroDependencia = 'todos'
        this.filtroDependencias = []
      } else {
        const centroCosto = this.datosGenerales.find(centro => {
          return centro.id == idCentroCosto
        })
        this.filtroDependencias = centroCosto.dependencias
      }
    },

    filtrar(idDependencia, idCentroCosto) {
      if (idCentroCosto == 'todos') {
        this.datosGenerales = this.datosGeneralesFiltro
        this.filtroDependencia = 'todos'
      } else {
        const centroCosto = this.datosGeneralesFiltro.find(centroCosto => {
          return centroCosto.id === idCentroCosto
        })

        let dependencias = null

        if (idDependencia === 'todos') {
          dependencias = centroCosto.dependencias
        } else {
          dependencias = Array(
            centroCosto.dependencias.find(dependencia => {
              return dependencia.id === idDependencia
            })
          )
        }

        this.datosGenerales = Array({
          id: idCentroCosto,
          nombre: centroCosto.nombre,
          dependencias,
        })
      }
    },
  },
}
</script>

<style scoped>
input[type='week'],
input[type='week']:focus {
  border-color: #2a93d5;
  background-color: #2a93d5;
  color: #fff;
  font-size: 13px;
  padding: 0;
}
</style>
