<template>
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="chartdiv" ref="chartdiv"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
am4core.useTheme(am4themes_animated)

export default {
  props: {
    fechaInicio: String,
    fechaFin: String,
  },
  data() {
    return {
      graficaDatos: '',
    }
  },
  created() {
    this.cargarDatosGrafica(this.fechaInicio, this.fechaFin)
  },
  methods: {
    cargarDatosGrafica(fechaInicio, fechaFin) {
      axios
        .get(`/api/${localStorage.getItem('tenant')}/llegadas_tarde/fecha/${fechaInicio}/${fechaFin}`)
        .then(datos => {
          this.graficaDatos = datos.data
          this.crearGrafica()
        })
    },
    crearGrafica() {
      setTimeout(() => {
        let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart)
        chart.paddingRight = 20
        let datos = []

        for (let propiedad in this.graficaDatos) {
          datos.push({
            date: propiedad,
            value: this.graficaDatos[propiedad].length,
          })
        }
        chart.data = datos

        chart.dateFormatter.inputDateFormat = 'yyyy-MM-dd'

        let dateAxis = chart.xAxes.push(new am4charts.DateAxis())
        let valueAxis = chart.yAxes.push(new am4charts.ValueAxis())

        let series = chart.series.push(new am4charts.LineSeries())
        series.dataFields.valueY = 'value'
        series.dataFields.dateX = 'date'
        series.tooltipText = '{value}'
        series.strokeWidth = 2
        series.minBulletDistance = 15

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20
        series.tooltip.background.strokeOpacity = 0
        series.tooltip.pointerOrientation = 'vertical'
        series.tooltip.label.minWidth = 40
        series.tooltip.label.minHeight = 40
        series.tooltip.label.textAlign = 'middle'
        series.tooltip.label.textValign = 'middle'

        // Make bullets grow on hover
        let bullet = series.bullets.push(new am4charts.CircleBullet())
        bullet.circle.strokeWidth = 2
        bullet.circle.radius = 4
        bullet.circle.fill = am4core.color('#fff')

        let bullethover = bullet.states.create('hover')
        bullethover.properties.scale = 1.3

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor()
        chart.cursor.behavior = 'panXY'
        chart.cursor.xAxis = dateAxis
        chart.cursor.snapToSeries = series

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar()
        chart.scrollbarY.parent = chart.leftAxesContainer
        chart.scrollbarY.toBack()

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar()
        chart.scrollbarX.series.push(series)
        chart.scrollbarX.parent = chart.bottomAxesContainer

        this.chart = chart
      }, 1000)
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
