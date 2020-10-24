<template>
  <div>
    <p class="text-center text-uppercase font-weight-bold text-muted">Días trabajados</p>
    <table class="table table-bordered table-striped table-sm">
      <thead>
        <tr>
          <th style="width:80%">Concepto</th>
          <th class="text-center">Días</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td>Días del periodo</td>
          <td class="text-center">{{salarioDatos.dias_periodo}}</td>
        </tr>
        <tr v-for="(dia, index) in diasNovedades" :key="`D-${index}`">
          <td>{{dia.concepto}}</td>
          <td class="text-center">{{dia.dias}}</td>
        </tr>
        <tr class="fila-total">
          <td class="font-weight-bold">Total días trabajados</td>
          <td class="text-center font-weight-bold">{{salarioDatos.dias_trabajados}}</td>
        </tr>
      </tbody>
    </table>

    <p>
      <small>A los 30 días del período se deben descontar los días que el empleado tuvo novedad para obtener los días realmente trabajados.</small>
    </p>
  </div>
</template>

<script>
export default {
  props: { salarioDatos: Object, novedadesDatos: Object },
  data() {
    return {
      diasNovedades: [],
    }
  },
  created() {
    this.organizarDias()
  },
  methods: {
    organizarDias() {
      for (let prop in this.novedadesDatos.novedades) {
        this.diasNovedades.push({
          concepto: prop,
          dias: this.novedadesDatos.novedades[prop],
        })
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
</style>
