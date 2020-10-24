<template>
  <div>
    <p class="text-center font-weight-bold text-uppercase text-muted mt-2">
      Retenciones
      <i class="iconsmind-Token-"></i>
    </p>
    <table class="table table-sm table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:89%">Factores constitutivos de salario</th>
          <th class="text-center">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(factor, index) in factorRetenciones" :key="index">
          <td>{{factor.concepto}}</td>
          <td class="text-center">{{factor.valor | moneda}}</td>
        </tr>
        <tr>
          <td class="font-weight-bold">IBC Seguridad social</td>
          <td class="text-center font-weight-bold">{{retenciones.IBC_seguridad | moneda}}</td>
        </tr>
      </tbody>
    </table>

    <p class="mb-2">
      <small>Para el cálculo del IBC Seguridad Social no se tiene en cuenta: subsidio de transporte, valor de vacaciones compensadas ni demás ingresos no constitutivos de salario.</small>
    </p>

    <table class="table table-sm table-bordered table-striped">
      <thead>
        <tr>
          <th>Concepto</th>
          <th class="text-center">%</th>
          <th class="text-center">IBC Seguridad Social</th>
          <th class="text-center">Fórmula = IBC Seguriddad Social * %</th>
          <th class="text-center">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(retencion, index) in totalRetenciones" :key="index">
          <td>{{retencion.concepto}}</td>
          <td class="text-center">%</td>
          <td class="text-center">{{retenciones.IBC_seguridad | moneda}}</td>
          <td class="text-center">{{retenciones.IBC_seguridad | moneda}} * %</td>
          <td class="text-center">{{retencion.valor | moneda}}</td>
        </tr>
        <tr>
          <td class="font-weight-bold">Total retenciones</td>
          <td></td>
          <td></td>
          <td></td>
          <td class="text-center font-weight-bold">{{retenciones.valor_total | moneda}}</td>
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
      factorRetenciones: [],
      totalRetenciones: [],
    }
  },
  created() {
    this.retenciones = this.retencionesDatos
    this.organizarDatos(this.retenciones.retenciones, this.factorRetenciones)
    this.organizarDatos(
      this.retenciones.total_retenciones,
      this.totalRetenciones
    )
  },
  methods: {
    organizarDatos(objeto, arrayAllenar) {
      for (let prop in objeto) {
        if (objeto[prop] > 0) {
          arrayAllenar.push({ concepto: prop, valor: objeto[prop] })
        }
      }
    },
  },
}
</script>

<style scoped>
p small {
  font-size: 12.5px;
  font-weight: bold;
}
table thead,
tbody {
  font-size: 0.95rem;
  font-family: 'Lato', sans-serif;
  line-height: 1.9;
}

p i {
  font-size: 28px;
}
</style>
