<template>
  <div v-if="ingresosDatos.length">
    <p class="text-center font-weight-bold text-uppercase text-muted mt-4">
      Ingresos Adicionales
      <i class="iconsmind-Financial"></i>
    </p>
    <template v-if="constitutivos.length > 0">
      <p class="text-center font-weight-bold mt-2">Constitutivos de Salario</p>
      <table class="table table-bordered table-striped table-sm">
        <thead>
          <tr>
            <th style="width:89%">Concepto</th>
            <th class="text-center">Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(constitutivo, index) in constitutivos" :key="`D-${index}`">
            <td>{{constitutivo.concepto}}</td>
            <td class="text-center">{{constitutivo.valor | moneda}}</td>
          </tr>
        </tbody>
      </table>
    </template>

    <template v-if="noConstitutivos.length > 0">
      <p class="text-center font-weight-bold mt-2">No Constitutivos de Salario</p>
      <table class="table table-bordered table-striped table-sm">
        <thead>
          <tr>
            <th style="width:89%">Concepto</th>
            <th class="text-center">Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(noConstitutivo, index) in noConstitutivos" :key="`D-${index}`">
            <td>{{noConstitutivo.concepto}}</td>
            <td class="text-center">{{noConstitutivo.valor | moneda}}</td>
          </tr>
        </tbody>
      </table>
    </template>
  </div>
</template>

<script>
export default {
  props: { ingresosDatos: Object },
  data() {
    return {
      ingresos: '',
      constitutivos: [],
      noConstitutivos: [],
    }
  },
  created() {
    this.ingresos = this.ingresosDatos
    this.ordenarIngresos()
  },
  methods: {
    ordenarIngresos() {
      for (let propiedad in this.ingresos.constitutivos) {
        this.constitutivos.push({
          concepto: propiedad,
          valor: this.ingresos.constitutivos[propiedad],
        })
      }
      for (let propiedad in this.ingresos.no_constitutivos) {
        this.noConstitutivos.push({
          concepto: propiedad,
          valor: this.ingresos.no_constitutivos[propiedad],
        })
      }
    },
  },
}
</script>

<style scoped>
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
