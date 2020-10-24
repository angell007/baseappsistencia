<template>
  <div>
    <p class="text-center font-weight-bold text-uppercase text-muted mt-2">
      Cálculo IBC Salud y Pensión
      <i class="iconsmind-Stethoscope"></i>
    </p>
    <table class="table table-sm table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:89%">Concepto</th>
          <th class="text-center">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(factor, index) in ibc" :key="index">
          <td>{{factor.concepto}}</td>
          <td class="text-center">{{factor.valor | moneda}}</td>
        </tr>
        <tr>
          <td class="font-weight-bold">IBC Salud y pensión</td>
          <td class="text-center font-weight-bold">{{retenciones.IBC_seguridad | moneda}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: { retencionesDatos: Object },
  data() {
    return {
      retenciones: '',
      ibc: [],
    }
  },
  created() {
    this.retenciones = this.retencionesDatos
    this.organizarIbc()
  },
  methods: {
    organizarIbc() {
      for (let prop in this.retenciones.retenciones) {
        if (this.retenciones.retenciones[prop] > 0) {
          this.ibc.push({
            concepto: prop,
            valor: this.retenciones.retenciones[prop],
          })
        }
      }
    },
  },
}
</script>

<style scoped>
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
