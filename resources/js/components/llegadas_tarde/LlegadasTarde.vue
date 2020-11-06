<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 class="font-weight-bold">Informe de Llegadas Tarde</h1>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-8">
        <div class="card">
          <div class="card-title m-0 p-0">
            <h3 class="pt-3 pl-4 font-weight-bold">Filtros de búsqueda</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="fecha_inicio" class="custom-label">Fecha de Inicio</label>
                  <input
                    type="date"
                    name="fecha_inicio"
                    v-model="fecha_inicio"
                    class="form-control custom-control"
                  >
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label for="fecha_fin" class="custom-label">Fecha de Fin</label>
                  <input
                    type="date"
                    name="fecha_fin"
                    v-model="fecha_fin"
                    class="form-control custom-control"
                  >
                </div>
              </div>
              <div class="col-md-2 pt-4">
                <button
                  class="btn btn-secondary btn-xs default mt-1"
                  @click="filtrarPorFecha(fecha_inicio,fecha_fin)"
                >Filtrar</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="filtroCentroCosto" class="custom-label">Centro de costos</label>
                  <select
                    name="filtroCentroCosto"
                    v-model="filtroCentroCosto"
                    class="form-control custom-control"
                    @change="filtrarCentroCosto(filtroCentroCosto)"
                  >
                    <option value="todos">Todos</option>
                    <option
                      v-for="(centro,index) in llegadasTardeDatos"
                      :key="index"
                      :value="centro.id"
                    >{{centro.nombre}}</option>
                  </select>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label for="filtroDependencia" class="custom-label">Dependencia</label>
                  <select
                    name="filtroDependencia"
                    v-model="filtroDependencia"
                    class="form-control custom-control"
                    :disabled="filtroCentroCosto == 'todos'"
                  >
                    <option
                      v-for="(dependencia,index) in filtroDependencias"
                      :key="index"
                      :value="dependencia.id"
                    >{{dependencia.nombre}}</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 pt-4">
                <button
                  class="btn btn-secondary default btn-xs mt-1"
                  @click="filtrar(filtroDependencia,filtroCentroCosto)"
                >Filtrar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-title mb-0">
            <h4 class="font-weight-bold mt-3 ml-3">Reportes</h4>
          </div>
          <div class="card-body text-center reportes">
            <div class="row">
              <div>
                <i class="iconsmind-File-Excel excel"></i>
                <p class="font-weight-bold mb-0">Reporte en Excel</p>
                <download-excel
                  :data="reportesExcelDatos"
                  :fields="columnasReporteExcel"
                  class="btn btn-link default"
                  worksheet="Reporte"
                  name="reporte_llegadas_tarde.xls"
                >Descargar</download-excel>
              </div>
              <div>
                <i class="iconsmind-File-Download pdf"></i>
                <p class="font-weight-bold mb-0">Reporte en PDF</p>
                <a :href="pdfUrl" class="btn btn-link default" download>Descargar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <grafica ref="grafica" :fechaInicio="fecha_inicio" :fechaFin="fecha_fin"></grafica>

    <div class="row mt-4">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 pl-4 text-center">
                <i class="iconsmind-Sand-watch2"></i>
              </div>
              <div class="col-md-6">
                <p class="text-center font-weight-bold">Cantidad de llegadas tarde :</p>
                <p
                  class="text-center font-weight-bold calculo"
                >{{totalLlegadasTarde(llegadasTardeDatos)}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-5 text-center">
                <i class="iconsmind-Timer-2"></i>
              </div>
              <div class="col-md-7">
                <p class="text-center font-weight-bold">Tiempo acumulado llegadas tarde:</p>
                <p
                  class="text-center font-weight-bold calculo"
                >{{tiempoAcumuladoLlegadas(llegadasTardeDatos)}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <template v-if="llegadasTardeDatos.length > 0">
              <div
                class="row centro ml-1 mr-1"
                v-for="(centro, index) in llegadasTardeDatos"
                :key="index"
              >
                <div class="col-12" :class="{'mt-3': index > 0}">
                  <p class="ml-4 pl-2 mt-1 nombre-centro">{{centro.nombre}}</p>
                </div>
                <div
                  class="col-12"
                  v-for="(dependencia,indexD) in centro.dependencias"
                  :key="indexD"
                >
                  <div class="row pl-5 mt-2">
                    <p class="mt-1 font-weight-bold">{{dependencia.nombre}}</p>
                  </div>

                  <div
                    class="row pl-4"
                    v-for="(funcionario, indexF) in dependencia.funcionarios"
                    :key="indexF"
                  >
                    <div
                      class="col-12 align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center"
                    >
                      <p class="w-40 w-xs-100 mb-0">
                        <img :src="funcionario.image" alt="Imagen funcionario">
                        <span class="custom-label">{{funcionario.nombres}} {{funcionario.apellidos}}</span>
                      </p>

                      <p class="mb-1 font-weight-bold w-15 w-xs-100">
                        <i class="simple-icon-clock font-weight-bold"></i>
                        {{numeroLlegadasTarde(funcionario.llegadas_tarde)}}
                      </p>

                      <p
                        class="mb-1 custom-label w-15 w-xs-100"
                      >Promedio: {{tiempoPromedio(funcionario.llegadas_tarde) || '0'}}</p>

                      <div class="w-xs-100">
                        <button
                          class="btn btn-link"
                          @click="mostrarDetalles(funcionario.id)"
                        >Detalles</button>
                      </div>
                    </div>

                    <detalles-llegadas
                      :ref="`detalles-funcionario-${funcionario.id}`"
                      :llegadas_tarde="funcionario.llegadas_tarde"
                    ></detalles-llegadas>
                  </div>
                  <div class="separator ml-3 mt-2"></div>
                </div>
              </div>
            </template>
            <template class="row mt-4 pl-5" v-else>
              <div class="col-12">
                <p class="font-weight-bold text-muted">No existen llegadas tarde para esta fecha.</p>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
import DetallesLlegadas from './DetallesLlegadas'
import Grafica from './Grafica'
export default {
  components: { DetallesLlegadas, Grafica },
  data() {
    return {
      fecha_inicio: moment()
        .startOf('month')
        .format(moment.HTML5_FMT.DATE),
      fecha_fin: moment()
        .endOf('month')
        .format(moment.HTML5_FMT.DATE),

      //Datos
      llegadasTardeDatos: [],
      /*   graficaDatos: [], */
      reportesExcelDatos: [],

      // Filtros
      filtroCentroCosto: 'todos',
      filtroLlegadasTardeDatos: [],
      filtroDependencias: [],
      filtroDependencia: 'todos',

      //Reportes
      columnasReporteExcel: {
        Fecha: 'fecha',
        'Entrada Turno': 'entrada_turno',
        'Entrada Real': 'entrada_real',
        'Nombre del Funcionario': 'funcionario',
        'Dependencia': 'dependencia',
        'Centro de Costo': 'centro_costo',
      },
      pdfUrl: '',
      itemSeleccionado: '',
    }
  },

  created() {
    this.cargarLlegadasTarde(this.fecha_inicio, this.fecha_fin)
    this.cargarDatosReporteExcel(this.fecha_inicio, this.fecha_fin)
    this.pdfUrl = `/api/${localStorage.getItem('tenant')}/llegadas_tarde/reporte_pdf/${this.fecha_inicio}/${
      this.fecha_fin
    }`
  },
  methods: {
    cargarLlegadasTarde(fechaInicio, fechaFin) {
      axios
        .get(`/api/${localStorage.getItem('tenant')}/llegadas_tarde/datos/${fechaInicio}/${fechaFin}`)
        .then(datos => {
          this.llegadasTardeDatos = this.filtroLlegadasTardeDatos = datos.data
        })
    },

    cargarDatosReporteExcel(fechaInicio, fechaFin) {
      axios
        .get(`/api/${localStorage.getItem('tenant')}/llegadas_tarde/reporte/${fechaInicio}/${fechaFin}`)
        .then(datos => {
          //this.reportesExcelDatos = datos.data
          this.reportesExcelDatos = this.formatearDatosReportes(
            datos.data
          )
        })
    },

    formatearDatosReportes(datos = []) {
      let datosNuevos = []
      datos.forEach(dato => {
        datosNuevos.push({
          fecha: dato.fecha,
          entrada_turno: dato.entrada_turno,
          entrada_real: dato.entrada_real,
          funcionario: dato.funcionario.nombres+" "+dato.funcionario.apellidos,
          dependencia: dato.funcionario.dependencia.nombre,
          centro_costo: dato.funcionario.dependencia.centro_costo.nombre,
        })
      })
      datosNuevos.sort((a, b) => {
        return new Date(a.fecha) - new Date(b.fecha)
      })
      return datosNuevos
    },

    descargarReportePdf(fechaInicio, fechaFin) {
      axios
        .post(`/api/${localStorage.getItem('tenant')}/llegadas_tarde/reporte_pdf/${fechaInicio}/${fechaFin}`)
        .then(respuesta => {
          window.open('data:application/pdf,' + encodeURI(respuesta.data))
        })
    },

    mostrarDetalles(funcionarioId) {
      let elemento = `detalles-funcionario-${funcionarioId}`

      this.$refs[elemento][0].mostrar = !this.$refs[elemento][0].mostrar
    },

    numeroLlegadasTarde(arrayLlegadas = []) {
      return arrayLlegadas.length
    },

    totalLlegadasTarde(centros) {
      let total = 0
      centros.forEach(centro => {
        centro.dependencias.forEach(dependencia => {
          dependencia.funcionarios.forEach(funcionario => {
            total += funcionario.llegadas_tarde.length
          })
        })
      })
      return total
    },

    tiempoEnMilisegundos(horaUno, horaDos) {
      let horaInicial = moment.utc(horaUno, 'HH:mm:ss')
      let horaFinal = moment.utc(horaDos, 'HH:mm:ss')

      if (horaFinal.isBefore(horaInicial)) {
        horaFinal.add(1, 'd')
      }

      let duracion = moment.duration(horaFinal.diff(horaInicial))

      return duracion.as('milliseconds')
    },

    tiempoPromedio(llegadasTarde = []) {
      let total = llegadasTarde.length
      let suma = 0
      let promedio = 0

      llegadasTarde.forEach(llegada => {
        suma += this.tiempoEnMilisegundos(
          llegada.entrada_turno,
          llegada.entrada_real
        )
      })
      promedio = suma / total
      return moment.utc(promedio).format('HH:mm:ss')
    },

    tiempoAcumuladoLlegadas(centros) {
      let tiempoAcumulado = 0
      centros.forEach(centro => {
        centro.dependencias.forEach(dependencia => {
          dependencia.funcionarios.forEach(funcionario => {
            funcionario.llegadas_tarde.forEach(llegada => {
              tiempoAcumulado += this.tiempoEnMilisegundos(
                llegada.entrada_turno,
                llegada.entrada_real
              )
            })
          })
        })
      })
      return moment.utc(tiempoAcumulado).format('HH:mm:ss')
    },

    filtrarCentroCosto(centroCostoId) {
      if (centroCostoId == 'todos') {
        this.filtroDependencias = []
        return false
      }
      let centroCosto = this.llegadasTardeDatos.find(
        centro => centro.id === centroCostoId
      )

      let dependencias = centroCosto.dependencias.filter(
        dependencia => dependencia.funcionarios.length > 0
      )
      this.filtroDependencias = dependencias
      this.filtroDependencia = this.filtroDependencias[0].id
    },

    filtrar(dependenciaId, centroCostoId) {
      if (centroCostoId == 'todos') return this.restablecerDatos()

      let centroCosto = this.filtroLlegadasTardeDatos.find(
        centroCosto => centroCosto.id === centroCostoId
      )

      let dependencia = centroCosto.dependencias.find(
        dependencia => dependencia.id === dependenciaId
      )

      let objetoCentroCosto = {
        id: centroCostoId,
        nombre: centroCosto.nombre,
        dependencias: [dependencia],
        llegadas_tarde: centroCosto.llegadas_tarde,
      }

      let llegadasTarde = [objetoCentroCosto]
      this.llegadasTardeDatos = llegadasTarde
    },

    restablecerDatos() {
      this.llegadasTardeDatos = this.filtroLlegadasTardeDatos
      return false
    },

    filtrarPorFecha(fechaInicio, fechaFin) {
      if (fechaFin < fechaInicio) {
        this.$swal.fire(
          'Error de Fechas!',
          'La fecha de inicio debe ser menor que la fecha de fin',
          'error'
        )
      } else {
        this.cargarLlegadasTarde(fechaInicio, fechaFin)
        this.cargarDatosReporteExcel(fechaInicio, fechaFin)
        this.$refs.grafica.cargarDatosGrafica(fechaInicio, fechaFin)
        this.pdfUrl = `/api/${localStorage.getItem('tenant')}/llegadas_tarde/reporte_pdf/${this.fecha_inicio}/${
          this.fecha_fin
        }`
      }
    },

    obtenerLlegadasTarde() {
      let llegadasTarde = []
      this.llegadasTardeDatos.forEach(centro => {
        centro.llegadas_tarde.forEach(llegada => {
          llegadasTarde.push(llegada)
        })
      })
      return llegadasTarde
    },
  },
}
</script>

<style scoped>
img {
  width: 38px;
  border-radius: 50%;
}
.col-md-6 i {
  font-size: 46px;
  line-height: 66px;
  color: #2a93d5;
}
.calculo {
  font-size: 1.3rem;
}
.reportes {
  display: flex;
  justify-content: center;
  align-items: center;
}
.reportes div p {
  padding: 5px 10px;
}
.reportes div .excel {
  font-size: 30px;
  line-height: 66px;
  color: rgb(17, 141, 73);
}
.reportes div .pdf {
  font-size: 32px;
  line-height: 66px;
  color: rgb(168, 53, 53);
}
.nombre-centro {
  font-family: 'Montserrat';
  font-size: 0.75rem;
  font-weight: bold;
  text-transform: uppercase;
}
</style>
