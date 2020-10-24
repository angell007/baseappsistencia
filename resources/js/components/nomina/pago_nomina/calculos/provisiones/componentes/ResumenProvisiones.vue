<template>
  <div>
    <p class="text-center text-uppercase font-weight-bold text-muted mt-1">
      Resumen del pago
      <i class="iconsmind-Coins"></i>
    </p>
    <p class="text-center">
      <small>Total pago de provisiones: {{provisionesDatos.valor_total | moneda}}</small>
    </p>
    <table class="table table-sm table-bordered table-striped">
      <thead>
        <tr>
          <th>Concepto</th>
          <th class="text-center">Porcentaje</th>
          <th class="text-center">Base</th>
          <th class="text-center">x = Base * %</th>
          <th class="text-center">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in datosResumen" :key="`J-${index}`">
          <td>{{item.concepto}}</td>
          <td class="text-center">{{fijarPorcentaje(item.porcentaje * 100,2)}}%</td>
          <td class="text-center">{{item.base | moneda}}</td>
          <td class="text-center">{{item.base | moneda}} * {{fijarPorcentaje(item.porcentaje,4)}}</td>
          <td class="text-center">{{item.valor | moneda}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: { provisionesDatos: Object },
  data() {
    return {
      datosResumen: [],
    }
  },
  created() {
    this.organizarResumen()
  },
  methods: {
    organizarResumen() {
      for (let objeto in this.provisionesDatos.resumen) {
        this.datosResumen.push(this.provisionesDatos.resumen[objeto])
      }
    },
    fijarPorcentaje(valor, digitos) {
      return Number(valor).toFixed(digitos)
    },
  },
}
</script>

<style scoped>
p small {
  font-size: 13.5px;
  font-weight: bold;
}
table thead,
tbody {
  font-size: 0.93rem;
  font-family: 'Lato', sans-serif;
  line-height: 1.9;
}
p i {
  font-size: 26px;
}
</style>
