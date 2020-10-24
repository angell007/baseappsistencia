<template>
  <div class="row" v-show="datos.length">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="chartdiv" ref="chartdiv"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: { datos: Array, graficaCategoria: String, graficaValor: String },
  data() {
    return {
      datosGrafica: [],
    }
  },
  created() {
    this.datosGrafica = this.datos
    setTimeout(() => {
      this.crearGrafica()
    }, 500)
  },
  methods: {
    crearGrafica() {
      if (this.datos.length) {
        let chart = am4core.create(this.$refs.chartdiv, am4charts.PieChart)
        chart.data = this.datosGrafica
        let pieSeries = chart.series.push(new am4charts.PieSeries())
        pieSeries.dataFields.value = this.graficaValor
        pieSeries.dataFields.category = this.graficaCategoria
        chart.innerRadius = am4core.percent(40)
        chart.legend = new am4charts.Legend()
        chart.legend.valueLabels.template.text = '{value.value}'
        chart.legend.position = 'right'
        pieSeries.slices.template.stroke = am4core.color('#275C9C')
        pieSeries.slices.template.strokeWidth = 2
        pieSeries.slices.template.strokeOpacity = 1

        let label = chart.createChild(am4core.Label)
        const totalDatos = this.totalNovedades(
          this.datosGrafica,
          this.graficaValor
        )
        label.text = 'Total: ' + totalDatos
        label.fontSize = 14
        label.align = 'center'
      }
    },
    totalNovedades(novedades = [], objectKey = null) {
      return novedades.reduce((anterior, actual) => {
        return Object.values({
          objectKey: anterior[objectKey] + actual[objectKey],
        })[0]
      })
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
