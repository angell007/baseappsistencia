<template>
  <div>
    <p class="text-center font-weight-bold text-uppercase text-muted mt-2">
      Cálculo IBC Aportes Parafiscales
      <i class="iconsmind-Notepad"></i>
    </p>
    <table class="table table-bordered table-striped table-sm">
      <thead>
        <tr>
          <th style="width:90%">Concepto</th>
          <th class="text-center">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in ibc" :key="`G-${index}`">
          <td :class="{bold: index === ibc.length -1 }">{{item.concepto}}</td>
          <td class="text-center" :class="{bold: index === ibc.length -1 }">{{item.valor | moneda}}</td>
        </tr>
      </tbody>
    </table>
    <p>
      <small>Tenga en cuenta que durante el periodo de licencia remunerada, maternidad o paternidad, no hay lugar al pago de Aportes Parafiscales</small>
    </p>
  </div>
</template>

<script>
export default {
  props: { ibcParafiscales: Object },
  data() {
    return {
      parafiscales: '',
      ibc: [],
      bold: 'bold',
    }
  },
  created() {
    this.parafiscales = this.ibcParafiscales
    this.organizarParafiscales()
  },
  methods: {
    organizarParafiscales() {
      for (let propiedad in this.parafiscales) {
        if (this.parafiscales[propiedad] > 0) {
          this.ibc.push({
            concepto: propiedad,
            valor: this.parafiscales[propiedad],
          })
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
.bold {
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
