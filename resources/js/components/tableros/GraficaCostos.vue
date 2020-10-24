<template>
  <div class="card">
    <div class="card-title pl-3 pt-3 mb-0">
      <slot></slot>
    </div>
    <div class="card-body">
      <div class="chartdivCostos" ref="chartdivCostos" v-if="datos.length"></div>
      <p class="font-weight-bold text-center" v-else>No existen costos en los últimos seis meses.</p>
    </div>
  </div>
</template>

<script>
am4core.useTheme(am4themes_animated)
import datosPrueba from './datosPrueba.js'
export default {
  data() {
    return {
      datos: datosPrueba.datos,
    }
  },
  mounted() {
    setTimeout(() => {
      this.crearGrafica()
    }, 500)
  },
  methods: {
    crearGrafica() {
      // Create chart instance
      var chart = am4core.create(this.$refs.chartdivCostos, am4charts.XYChart)

      chart.marginRight = 400

      // Add data
      chart.data = this.datos

      // Create axes
      let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis())
      categoryAxis.dataFields.category = 'mes'
      categoryAxis.title.text = 'Últimos 6 meses'
      categoryAxis.renderer.grid.template.location = 0
      categoryAxis.renderer.minGridDistance = 20

      let valueAxis = chart.yAxes.push(new am4charts.ValueAxis())
      valueAxis.title.text = 'Millones (M)'

      // Create series
      let series = chart.series.push(new am4charts.ColumnSeries())
      series.dataFields.valueY = 'salarios'
      series.dataFields.categoryX = 'mes'
      series.name = 'Salarios'
      series.tooltipText = '{name}: [bold]{valueY}[/]'
      series.stacked = true

      let series2 = chart.series.push(new am4charts.ColumnSeries())
      series2.dataFields.valueY = 'provisiones'
      series2.dataFields.categoryX = 'mes'
      series2.name = 'Provisiones'
      series2.tooltipText = '{name}: [bold]{valueY}[/]'
      series2.stacked = true

      let series3 = chart.series.push(new am4charts.ColumnSeries())
      series3.dataFields.valueY = 'seguridad'
      series3.dataFields.categoryX = 'mes'
      series3.name = 'Seguridad social'
      series3.tooltipText = '{name}: [bold]{valueY}[/]'
      series3.stacked = true

      // Add cursor
      chart.cursor = new am4charts.XYCursor()

      this.chart = chart
    },
  },
}
</script>

<style scoped>
.chartdivCostos {
  width: 100%;
  height: 350px;
}
</style>
