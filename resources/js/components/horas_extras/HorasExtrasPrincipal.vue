<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 class="font-weight-bold">Validación de horas extras reportadas</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <label class="custom-label">Tipo de turno actual</label>
          <select
            v-model="tipoTurno"
            class="form-control custom-control"
            @change="changeTipoTurno(tipoTurno)"
          >
            <option value="rotativo">Rotativo</option>
            <option value="fijo">Fijo</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label class="custom-label" for="filtroCentroCosto">Filtrar por centro de costos</label>
            <select
              name="filtroCentroCosto"
              v-model="filtroCentroCosto"
              class="form-control custom-control"
            >
              <option value="seleccionar">Seleccionar</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label class="custom-label" for="filtroDependencia">Filtrar por centro de costos</label>
            <select
              name="filtroDependencia"
              v-model="filtroDependencia"
              class="form-control custom-control"
            >
              <option value="seleccionar">Seleccionar</option>
            </select>
          </div>

          <div class="form-group col-md-4 mt-4 pt-1">
            <button type="button" class="btn btn-secondary default btn-xs">Filtrar</button>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <p
          class="text-center font-weight-bold"
        >Del {{primerDiaSemanaFormato}} al {{ultimoDiaSemanaFormato}}</p>
        <div class="form-group">
          <input
            type="week"
            name="semana"
            class="form-control custom-control"
            v-model="semana"
            @change="cambiarSemana"
            required
          >
        </div>
      </div>
    </div>

    <template v-if="renderizarContenido">
      <div class="row mt-3" v-if="horasExtras.length">
        <div class="col-12">
          <h2 class="font-weight-bold">Lista de funcionarios</h2>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-12" v-for="(centro) in horasExtras" :key="centro.id">
                  <p class="font-weight-bold mt-4">{{centro.nombre}}</p>
                  <div class="row">
                    <div
                      class="col-12"
                      v-for="(dependencia) in centro.dependencias"
                      :key="dependencia.id"
                    >
                      <p class="font-weight-bold mt-3">{{dependencia.nombre}}</p>
                      <div v-for="(funcionario) in dependencia.funcionarios" :key="funcionario.id">
                        <div class="row pl-2 pr-3">
                          <div class="col-md-3">
                            <div>
                              <img :src="`${funcionario.image}`" alt="foto_funcionario">
                              <span
                                class="custom-label"
                              >{{funcionario.nombres}} {{funcionario.apellidos}}</span>
                              <span
                                class="turno text-center font-weight-bold"
                              >{{funcionario.tipo_turno.slice(0,1)}}</span>
                            </div>
                          </div>

                          <div class="col-md-1">
                            <button
                              class="btn btn-link btn-sm"
                              @click="showExtrasFuncionario(funcionario.id)"
                            >
                              <i class="simple-icon-magnifier font-weight-bold"></i>
                            </button>
                          </div>

                          <div class="col-md-1">
                            <p class="text-center item-hora" title="Horas Trabajadas">HT</p>
                          </div>

                          <div class="col-md-1">
                            <p class="text-center item-hora" title="Horas Extras Diurnas">HED</p>
                          </div>
                          <div class="col-md-1">
                            <p class="text-center item-hora" title="Horas Extras Nocturnas">HEN</p>
                          </div>
                          <div class="col-md-1">
                            <p
                              class="text-center item-hora"
                              title="Horas Extras Diurnas Festivas/Dominicales"
                            >HEDFD</p>
                          </div>
                          <div class="col-md-1">
                            <p
                              class="text-center item-hora"
                              title="Horas Extras Nocturnas Festivas/Dominicales"
                            >HEDFN</p>
                          </div>
                          <div class="col-md-1">
                            <p class="text-center item-hora" title="Recargos Nocturnos">RN</p>
                          </div>
                          <div class="col-md-1">
                            <p class="text-center item-hora" title="Recargos Festivos">RF</p>
                          </div>
                        </div>

                        <lista-rotativos v-if="tipoTurno == 'rotativo'" :funcionario="funcionario"></lista-rotativos>
                        <lista-fijos v-else-if="tipoTurno == 'fijo'" :funcionario="funcionario"></lista-fijos>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="alert alert-secondary mt-3" v-else>
        <p class="font-weight-bold text-center">No existen horas extras reportadas en este periodo</p>
      </div>
    </template>
    <overlay v-else></overlay>
  </div>
</template>

<script>
import ListaRotativos from './ListaRotativos'
import ListaFijos from './ListaFijos'
import Overlay from '../utiles/Overlay'
export default {
  components: { ListaRotativos, ListaFijos, Overlay },
  data() {
    return {
      semana: moment().format(moment.HTML5_FMT.WEEK),
      primerDiaSemana: moment()
        .startOf('week')
        .format('YYYY-MM-DD'),
      ultimoDiaSemana: moment()
        .endOf('week')
        .format('YYYY-MM-DD'),
      diasSemanaActual: [],
      horasExtras: [],
      horasExtrasRotativos: [],
      horasExtrasFijos: [],
      tipoTurno: 'rotativo',
      //Filtros
      filtroCentroCosto: 'seleccionar',
      filtroDependencia: 'seleccionar',
      noMostrarExtrasFijos: true,
      //Banderas
      renderizarContenido: false,
    }
  },
  created() {
    this.getAllData()
  },

  methods: {
    getAllData() {
      axios
        .all([this.getHorasExtrasRotativos(), this.getHorasExtrasFijos()])
        .then(
          axios.spread((turnosRotativos, turnosFijos) => {
            this.horasExtrasRotativos = this.horasExtras = turnosRotativos.data
            this.horasExtrasFijos = turnosFijos.data
            this.renderizarContenido = true
          })
        )
    },
    getHorasExtrasRotativos() {
      return axios.get(
        `/api/${localStorage.getItem('tenant')}/horas_extras/turno_rotativo/${this.primerDiaSemana}/${
          this.ultimoDiaSemana
        }`
      )
    },

    getHorasExtrasFijos() {
      return axios.get(
        `/api/${localStorage.getItem('tenant')}/horas_extras/turno_fijo/${this.primerDiaSemana}/${
          this.ultimoDiaSemana
        }`
      )
    },

    changeTipoTurno(tipoTurno) {
      this.horasExtras =
        tipoTurno === 'rotativo'
          ? this.horasExtrasRotativos
          : this.horasExtrasFijos
    },

    showExtrasFuncionario(idFuncionario) {
      let child = this.$children.find(child => {
        return child.funcionario.id === idFuncionario
      })
      child.mostrarLista = !child.mostrarLista
    },
    showExtrasFijos(idFuncionario) {
      let elemento = `listaFijos${idFuncionario}`
      this.$refs[elemento][0].mostrarLista = !this.$refs[elemento][0]
        .mostrarLista
    },
    cambiarSemana() {
      let año = this.semana.split('-')[0]
      let sem = this.semana.split('-')[1]
      sem = sem.split('W')[1]
      let diasSemana = []

      for (let i = 0; i < 7; i++) {
        diasSemana.push(
          moment()
            .year(año)
            .day(i)
            .week(sem)
            .format('YYYY-MM-DD')
        )
      }
      diasSemana.sort((a, b) => {
        return new Date(a) - new Date(b)
      })
      this.diasSemanaActual = diasSemana
      this.primerDiaSemana = moment(this.diasSemanaActual[0]).format(
        'YYYY-MM-DD'
      )
      this.ultimoDiaSemana = moment(
        this.diasSemanaActual[this.diasSemanaActual.length - 1]
      ).format('YYYY-MM-DD')

      this.renderizarContenido = false
      this.getHorasExtrasRotativos()
    },
  },

  computed: {
    primerDiaSemanaFormato() {
      return moment(this.primerDiaSemana, 'YYYY-MM-DD').format('DD/MM/YYYY')
    },
    ultimoDiaSemanaFormato() {
      return moment(this.ultimoDiaSemana, 'YYYY-MM-DD').format('DD/MM/YYYY')
    },
  },
}
</script>

<style scoped>
img {
  width: 38px;
  border-radius: 50%;
}
.turno {
  color: #2a93d5;
  font-size: 13px;
  padding: 0px 5px;
  border: 1px solid #2a93d5;
}
.item-hora {
  font-weight: bold;
  font-family: 'Montserrat', sans-serif;
  font-size: 0.75rem;
}
input[type='week'] {
  border-color: #2a93d5;
  background-color: #2a93d5;
  padding: 0;
  color: #fff;
  text-align: center;
}
input[type='week']::-webkit-inner-spin-button {
  display: none;
  -webkit-appearance: none;
}
</style>
