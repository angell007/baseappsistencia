<template>
  <div>
    <template v-if="novedades.valor_total > 0">
      <p class="text-center text-uppercase font-weight-bold text-muted mt-2">
        Novedades
        <i class="iconsmind-Bell-2"></i>
      </p>

      <table class="table table-sm table-bordered table-striped">
        <thead>
          <tr>
            <th>Concepto</th>
            <th class="text-center">Días</th>
            <th class="text-center">Salario Promedio</th>
            <th class="text-center">Fórmula = Salario promedio * días / 30 días</th>
            <th class="text-center">Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(novedad,index) in arrayNovedades" :key="`A-${index}`">
            <td>{{novedad.concepto}}</td>
            <td class="text-center">{{novedad.dias}}</td>
            <td class="text-center">{{funcionario.salario | moneda}}</td>
            <td class="text-center">{{funcionario.salario | moneda}} * {{novedad.dias}}/ 30 días</td>
            <td class="text-center">{{novedad.valor | moneda}}</td>
          </tr>
          <tr>
            <td class="font-weight-bold">Total novedades</td>
            <td class="text-center font-weight-bold">{{novedades.total_dias}}</td>
            <td></td>
            <td></td>
            <td class="text-center font-weight-bold">{{novedades.valor_total | moneda}}</td>
          </tr>
        </tbody>
      </table>

      <p v-if="existeIncapacidad">
        <small>Tenga en cuenta que el auxilio por incapacidad no puede ser inferior al salario mínimo. Cuando el valor diario del pago de la incapacidad sea inferior al salario mínimo diario legal vigente ( $ 828.116 / 30 = $ 27.604), se aproximará automáticamente a ese valor.</small>
      </p>
    </template>
  </div>
</template>

<script>
export default {
  props: {
    novedadesDatos: Object,
    funcionario: Object,
    datosEmpresa: Object,
  },
  data() {
    return {
      novedades: '',
      arrayNovedades: [],
      existeIncapacidad: false,
    }
  },
  created() {
    this.novedades = this.novedadesDatos
    this.organizarNovedades()
  },
  methods: {
    organizarNovedades() {
      for (let prop in this.novedades.novedades_totales) {
        if (prop.split(' ')[0] == 'Incapacidad') {
          this.existeIncapacidad = true
        }
        this.arrayNovedades.push({
          concepto: prop,
          valor: this.novedades.novedades_totales[prop],
          dias: this.novedades.novedades[prop],
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
p i {
  font-size: 28px;
}
</style>
