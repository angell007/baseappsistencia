<template>
  <div>
    <p class="text-center font-weight-bold text-uppercase text-muted mt-2">
      Cálculo IBC Riesgos
      <i class="iconsmind-Suitcase"></i>
    </p>
    <table class="table table-bordered table-striped table-sm">
      <thead>
        <tr>
          <th style="width:90%">Concepto</th>
          <th class="text-center">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in ibc" :key="`F-${index}`">
          <td :class="{bold: index === ibc.length -1 }">{{item.concepto}}</td>
          <td class="text-center" :class="{bold: index === ibc.length -1 }">{{item.valor | moneda}}</td>
        </tr>
      </tbody>
    </table>
    <p>
      <small>Tenga en cuenta que la base de cotización mensual a riesgos no puede ser inferior a 1 SMMLV. En tal caso, se tomará como IBC Seguridad Social {{datosEmpresa.salario_base | moneda}}</small>
    </p>
  </div>
</template>

<script>
export default {
  props: { ibcRiesgos: Object, datosEmpresa: Object },
  data() {
    return {
      riesgos: [],
      ibc: [],
      //CSS
      bold: 'bold',
    }
  },
  created() {
    this.riesgos = this.ibcRiesgos
    this.organizarRiesgos()
  },
  methods: {
    organizarRiesgos() {
      for (let prop in this.riesgos) {
        if (this.riesgos[prop] > 0) {
          this.ibc.push({ concepto: prop, valor: this.riesgos[prop] })
        }
      }
    },
  },
}
</script>

<style scoped>
p small {
  font-size: 12.5px;
}
p small,
.bold {
  font-weight: bold;
}
table thead,
tbody {
  font-size: 0.93rem;
  line-height: 1.9;
  font-family: 'Lato', sans-serif;
}
p i {
  font-size: 28px;
}
</style>
