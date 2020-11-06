<template>
  <div class="container">
    <h1 class="font-weight-bold">Indicadores Llegadas Tarde</h1>

    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="fechaInicio" class="custom-label">Fecha Inicio</label>
          <input type="date" v-model="fechaInicio" class="custom-control form-control">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="fechaFin" class="custom-label">Fecha Fin</label>
          <input type="date" v-model="fechaFin" class="custom-control form-control">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group mt-4">
          <button
            type="button"
            class="btn btn-secondary default btn-xs mt-1"
            @click="filtrarPorFecha"
          >Filtrar</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="centro_costos" class="custom-label">Centro de costos</label>
          <select
            v-model="centro_costo_id"
            class="form-control custom-control"
            @change="filtrarPorDependencia(centro_costo_id)"
            :disabled="!llegadasTardeDatos.length"
          >
            <option value="todos">Todos</option>
            <option
              v-for="(centro,index) in filtroCentrosCostos"
              :key="index"
              :value="centro"
            >{{centro}}</option>
          </select>
        </div>
      </div>
    </div>
    <section v-if="renderizarContenido">
      <div class="row" v-if="!llegadasTardeDatos.length">
        <div class="col-md-12">
          <p
            class="alert alert-secondary font-weight-bold"
          >No existen llegadas tarde en este periodo</p>
        </div>
      </div>
      <grafica-llegadas-tarde
        :datos="llegadasTardeDatos"
        graficaCategoria="nombre"
        graficaValor="llegadas"
        ref="grafica"
      ></grafica-llegadas-tarde>

      <div class="content-tops" v-if="llegadasTardeDatos.length">
        <h2 class="font-weight-bold mt-4">Funcionarios con más llegadas tarde</h2>
        <div class="card mt-1">
          <div class="card-title mb-0 pl-4 pt-3">
            <p class="custom-label">Entre {{formatoFechaInicio}} y {{formatoFechaFin}}</p>
          </div>
          <div class="card-body pt-2">
            <table class="table table-bordered table-sm">
              <thead class="thead">
                <tr class="custom-head">
                  <th class="text-center">Nombre completo</th>
                  <th class="text-center">Dependencia</th>
                  <th class="text-center">Centro de costos</th>
                  <th class="text-center">Cantidad de llegadas tarde</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(funcionario,index) in funcionariosDatos" :key="index">
                  <td class="custom-label d-flex align-items-center justify-content-center">
                    <img
                      class="img-funcionario"
                      :src="`${funcionario.image}`"
                      alt="Imagen funcionario"
                    >
                    <span>{{funcionario.nombres}} {{funcionario.apellidos}}</span>
                  </td>
                  <td class="text-center custom-label">{{funcionario.dependencia.nombre}}</td>
                  <td
                    class="text-center custom-label"
                  >{{funcionario.dependencia.centro_costo.nombre}}</td>
                  <td class="text-center custom-label">{{funcionario.llegadas}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <h3 class="font-weight-bold mt-3">Funcionarios con más tiempo acumulado en llegadas tarde</h3>
        <div class="card mt-1" v-if="llegadasTardeDatos.length">
          <div class="card-title mb-0 pl-4 pt-3">
            <p class="custom-label">Entre {{formatoFechaInicio}} y {{formatoFechaFin}}</p>
          </div>
          <div class="card-body pt-2">
            <table class="table table-bordered table-sm">
              <thead class="thead">
                <tr class="custom-head">
                  <th class="text-center">Nombre completo</th>
                  <th class="text-center">Dependencia</th>
                  <th class="text-center">Centro de costos</th>
                  <th class="text-center">Tiempo acumulado (minutos)</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(funcionario,index) in funcionariostiempoDatos" :key="index">
                  <td class="custom-label d-flex align-items-center justify-content-center">
                    <img
                      class="img-funcionario"
                      :src="`${funcionario.image}`"
                      alt="Imagen funcionario"
                    >
                    <span>{{funcionario.nombres}} {{funcionario.apellidos}}</span>
                  </td>
                  <td class="text-center custom-label">{{funcionario.dependencia.nombre}}</td>
                  <td
                    class="text-center custom-label"
                  >{{funcionario.dependencia.centro_costo.nombre}}</td>
                  <td
                    class="text-center custom-label"
                  >{{formatoTiempoAcumulado(funcionario.tiempo_acumulado)}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    <overlay v-else></overlay>
  </div>
</template>

<script>
am4core.useTheme(am4themes_animated)
import Grafica from './reutilizables/Grafica'
import Overlay from '../utiles/Overlay'
export default {
  components: { Overlay, 'grafica-llegadas-tarde': Grafica },
  data() {
    return {
      fechaInicio: moment()
        .startOf('month')
        .format(moment.HTML5_FMT.DATE),
      fechaFin: moment()
        .endOf('month')
        .format(moment.HTML5_FMT.DATE),
      centrosCostosDatos: [],
      filtroCentrosCostos: [],
      filtroDependencias: [],
      filtroTipos: [],
      llegadasTardeDatos: [],
      funcionariosDatos: [],
      funcionariostiempoDatos: [],
      tiposDatos: [],
      graficaDatos: [],
      //Filtros
      centro_costo_id: 'todos',
      dependencia_id: 'todos',
      tipo_novedad_id: 'todos',
      //Bandera
      renderizarContenido: false,
    }
  },
  created() {
    this.getAllData()
  },
  methods: {
    getAllData() {
      axios
        .all([
          this.getLlegadasTarde(),
          this.getLlegadasTardeByDependencias(),
          this.getTopFuncionariosByRetardos(),
          this.getTopFuncionariosByTiempo(),
        ])
        .then(
          axios.spread(
            (
              llegadasTarde,
              llegadasTardeByDependencia,
              topFuncionariosByRetardos,
              topFuncionariosByTiempo
            ) => {
              this.llegadasTardeDatos = llegadasTarde.data
              this.centrosCostosDatos = llegadasTardeByDependencia.data
              this.filtroCentrosCostos = Object.keys(
                llegadasTardeByDependencia.data
              )
              this.funcionariosDatos = topFuncionariosByRetardos.data
              this.funcionariostiempoDatos = topFuncionariosByTiempo.data
              this.renderizarContenido = true
            }
          )
        )
    },
    getLlegadasTarde() {
      return axios.get(
        `/api/${localStorage.getItem('tenant')}/indicadores/tiempo/${this.fechaInicio}/${this.fechaFin}`
      )
    },
    getLlegadasTardeByDependencias() {
      return axios.get(
        `/api/${localStorage.getItem('tenant')}/indicadores/tiempo/${this.fechaInicio}/${
          this.fechaFin
        }/dependencias`
      )
    },
    getTopFuncionariosByRetardos() {
      return axios.get(
        `/api/${localStorage.getItem('tenant')}/indicadores/tiempo/${this.fechaInicio}/${
          this.fechaFin
        }/top_llegadas`
      )
    },
    getTopFuncionariosByTiempo() {
      return axios.get(
        `/api/${localStorage.getItem('tenant')}/indicadores/tiempo/${this.fechaInicio}/${
          this.fechaFin
        }/top_tiempo`
      )
    },

    filtrarPorDependencia(centroCosto) {
      if (centroCosto === 'todos') {
        this.filtroDependencias = []
        this.$refs.grafica.datosGrafica = this.llegadasTardeDatos
        this.$refs.grafica.crearGrafica()
        this.dependencia_id = 'todos'
        return false
      }
      this.filtroDependencias = this.centrosCostosDatos[centroCosto]
      this.$refs.grafica.datosGrafica = this.filtroDependencias
      this.$refs.grafica.crearGrafica()
      this.dependencia_id = 'todos'
    },

    filtrarPorFecha() {
      if (this.fechaInicio > this.fechaFin) {
        this.$swal.fire(
          'Error!',
          'La fecha inicial no puede ser menor que la final',
          'error'
        )
      } else {
        this.renderizarContenido = false
        this.getAllData()
      }
    },

    totalLlegadasTarde(llegadas) {
      return llegadas.reduce((anterior, actual) => {
        return { llegadas: anterior.llegadas + actual.llegadas }
      })
    },

    formatoTiempoAcumulado(minutos) {
      return moment(minutos, 'mm').format('HH:mm:ss')
    },

    errorServidor(err) {
      if (err.response) {
        this.$swal.fire(
          'Error!',
          'Han ocurrido errores, intente más tarde',
          'error'
        )
      }
    },
  },
  computed: {
    formatoFechaInicio() {
      return moment(this.fechaInicio).format('DD/MM/YYYY')
    },
    formatoFechaFin() {
      return moment(this.fechaFin).format('DD/MM/YYYY')
    },
  },
}
</script>

<style scoped>
.img-funcionario {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  margin-right: 5px;
}
.custom-head {
  font-size: 14px;
  font-family: 'Lato';
}
</style>
