<template>
  <div class="row mt-4" >
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h5>{{pregunta}}</h5></div>
            <div class="card-body">
                <div class="chartdiv" ref="chartdiv" v-show="datos.length"></div>
                <div v-show="datos.length==0" class="sin-datos"><h3>No Hay Datos en este momento para esta Pregunta</h3></div>
            </div>
        </div>


    </div>
  </div>
</template>

<script>
export default {
  props: { datos: Array, graficaCategoria: String, graficaValor: String, pregunta: String },
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
  watch: {
    datos: function () {
      this.datosGrafica = this.datos
        setTimeout(() => {
        this.crearGrafica()
        }, 300)
    }
  },
  methods: {
    crearGrafica() {
      if (this.datos.length) {
        let chart = am4core.create(this.$refs.chartdiv, am4charts.PieChart)
        chart.data = this.datosGrafica
        let pieSeries = chart.series.push(new am4charts.PieSeries())
        pieSeries.dataFields.value = this.graficaValor
        pieSeries.dataFields.category = this.graficaCategoria
        chart.innerRadius = am4core.percent(0)
        chart.legend = new am4charts.Legend()
        chart.legend.valueLabels.template.text = '{value.value}'
        chart.legend.position = 'right'
        //pieSeries.slices.template.stroke = am4core.color('#275C9C')
        //pieSeries.slices.template.strokeWidth = 2
        //pieSeries.slices.template.strokeOpacity = 1
        pieSeries.labels.template.disabled = true;
        pieSeries.ticks.template.disabled = true;

        let label = chart.createChild(am4core.Label)
        const totalDatos = this.totalRespuestas(
          this.datosGrafica,
          this.graficaValor
        )
        label.text = 'Total: ' + totalDatos
        label.fontSize = 14
        label.align = 'center'
      }
    },
    totalRespuestas(novedades = [], objectKey = null) {
      return novedades.reduce((anterior, actual) => {
        var ant = parseInt(anterior[objectKey]);
        var act = parseInt(actual[objectKey]);
        if(isNaN(ant)) ant = 0;
        if(isNaN(act)) act = 0;
        return Object.values({
          objectKey: ant + act,
        })[0]
      })
    },
  },
}
</script>

<style scoped>
.chartdiv {
  width: 100%;
  height: 300px;
}
.card{
    background: #f9f9f9;
    box-shadow: none !important;
}
h5{
    font-size: 14px;
    margin-top:5px;
}
.sin-datos{
    height: 300px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.sin-datos h3{
    font-size: 14px;
    color: red;
    padding: 5px;
    background: #ffe0e0;
    width: 100%;
    text-align: center;
}
</style>

