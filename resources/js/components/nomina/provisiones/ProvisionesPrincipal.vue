<template>
  <div class="container">
    <div class="row">
      <h1 class="font-weight-bold">Provisiones</h1>
    </div>

    <div class="alert alert-secondary" v-if="!existenProvisiones">
      <p class="font-weight-bold">No existen provisiones registradas actualmente.</p>
    </div>

    <div v-show="renderizar">
      <div class="row icon-cards mb-5" v-if="existenProvisiones" >
        <div class="col-12">
            <div class="row">
                <card-concepto :concepto="provisiones.cesantias" icon="iconsmind-Money-2">Cesantías</card-concepto>
                <card-concepto
                :concepto="provisiones.intereses_cesantias"
                icon="iconsmind-Bag-Coins"
                >Inter. cesantías</card-concepto>
                <card-concepto :concepto="provisiones.prima" icon="iconsmind-Ambulance">Prima</card-concepto>
                <card-concepto :concepto="provisiones.vacaciones" icon="iconsmind-Mens">Vacaciones</card-concepto>
                <card-concepto
                :concepto="provisiones.total_provisiones"
                icon="iconsmind-Coins-3"
                >Tot. Provisiones</card-concepto>
                <div class="col-md-2 p-0 col-xs-12 mb-2 card-filter">
                <select
                    v-model="mesFiltro"
                    class="form-control custom-control"
                    @change="getAllData(mesFiltro)"
                >
                    <option
                    v-for="(mes, index) in meses"
                    :key="index"
                    :value="mes.numero"
                    >{{mes.nombre | capital}}</option>
                </select>
                </div>
            </div>
        </div>
      </div>

      <div class="row" v-show="existenProvisiones">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="chartdiv" ref="chartdiv"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <overlay v-show="!renderizar"></overlay>
  </div>
</template>

<script>
import CardConcepto from '../pago_nomina/reutilizables/CardConcepto'
import Overlay from '../../utiles/Overlay'
export default {
  components: { CardConcepto, Overlay },
  data() {
    return {
      provisiones: '',
      datosGrafica: [],
      meses: [],
      renderizar: false,
      //filtro
      mesFiltro: '',
    }
  },
  created() {
    this.getAllData()
  },

  methods: {
    getAllData(mes = null) {
      axios.all([this.getProvisiones(mes)]).then(
        axios.spread(provisiones => {
          this.provisiones = provisiones.data
          this.getMesesProvisiones()
        })
      )
    },

    getProvisiones(mes = null) {
      if (!mes) {
        return axios.get(`/api/${localStorage.getItem('tenant')}/nomina/provisiones/`)
      }
      return axios.get(`/api/${localStorage.getItem('tenant')}/nomina/provisiones/${mes}`)
    },
    getMesesProvisiones() {
      this.datosGrafica = []
      if (!this.meses.length) {
        axios.get(`/api/${localStorage.getItem('tenant')}/nomina/provisiones/meses`).then(datos => {
          this.makeMeses(datos.data)
          this.makeGrafica()
          this.renderizar = true
        })
      } else {
        this.makeGrafica()
      }
    },

    makeMeses(meses = []) {
      if (meses.length) {
        const newMeses = meses.forEach(mes => {
          this.meses.push({
            nombre: moment(mes, 'M').format('MMMM'),
            numero: mes,
          })
        })

        this.mesFiltro = this.meses[0].numero
        this.setMesFiltro(this.mesFiltro)
      }
    },

    setMesFiltro(numeroMes) {
      this.mesFiltro = numeroMes
    },

    makeGrafica() {
      this.makeDatosGrafica()
      let chart = am4core.create(this.$refs.chartdiv, am4charts.PieChart)
      chart.data = this.datosGrafica
      let pieSeries = chart.series.push(new am4charts.PieSeries())
      pieSeries.dataFields.value = 'valor'
      pieSeries.dataFields.category = 'concepto'
      chart.innerRadius = am4core.percent(40)
      chart.innerRadius = am4core.percent(40)
      chart.legend = new am4charts.Legend()
      chart.legend.valueLabels.template.text = '{value.value}'
      chart.legend.position = 'right'
      pieSeries.slices.template.stroke = am4core.color('#275C9C')
      let label = chart.createChild(am4core.Label)
      label.text = 'Total: ' + this.provisiones['total_provisiones']
      label.fontSize = 14
      label.align = 'center'
    },

    makeDatosGrafica() {
      this.insertIntoDatosGrafica('Cesantías', this.provisiones['cesantias'])
      this.insertIntoDatosGrafica(
        'Int. cesantías',
        this.provisiones['intereses_cesantias']
      )
      this.insertIntoDatosGrafica('Prima', this.provisiones['prima'])
      this.insertIntoDatosGrafica('Vacaciones', this.provisiones['vacaciones'])
    },

    insertIntoDatosGrafica(concepto, valor) {
      this.datosGrafica.push({
        concepto: concepto,
        valor: valor,
      })
    },
  },

  computed: {
    existenProvisiones() {
      return Object.keys(this.provisiones).length
    },
  },
}
</script>

<style scoped>
.chartdiv {
  width: 100%;
  height: 350px;
}
</style>
