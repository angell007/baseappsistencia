<template>
  <div>
    <p class="text-center text-uppercase font-weight-bold text-muted mt-1">
      <slot></slot>
    </p>
    <table class="table table-sm table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:84%">Concepto</th>
          <th class="text-center">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in conceptos" :key="index">
          <td :class="{cssBold: index == conceptos.length-1 }">{{item.concepto}}</td>
          <td
            class="text-center"
            :class="{cssBold: index === conceptos.length -1 }"
          >{{item.valor | moneda}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: { funcionario: Object, base: Object },
  data() {
    return {
      conceptos: [],
      cssBold: 'cssBold',
    }
  },
  created() {
    this.organizarConceptos()
  },
  methods: {
    organizarConceptos() {
      for (let prop in this.base) {
        if (typeof this.base[prop] == 'object') {
          for (let novedad in this.base[prop]) {
            if (this.base[prop][novedad] > 0) {
              this.conceptos.push({
                concepto: novedad,
                valor: this.base[prop][novedad],
              })
            }
          }
          continue
        }
        if (this.base[prop] > 0) {
          this.conceptos.push({ concepto: prop, valor: this.base[prop] })
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
.cssBold {
  font-weight: bold;
}
table thead,
tbody {
  font-size: 0.93rem;
  font-family: 'Lato', sans-serif;
  line-height: 1.9;
}
</style>
