<template>
  <div class="container">
    <div class="row mb-3">
      <div class="col-md-12">
        <a
          href="#"
          :class="['parametro-item']"
          v-for="(tab,index) in tabs"
          :key="index"
          @click.prevent="tabActual=tab"
        >
          <template v-if="tabActual == tab">
            <i class="iconsmind-Right-4 icon-tab"></i>
          </template>
          {{tab}}
        </a>
      </div>
    </div>
    <contabilidad v-if="tabActual == 'Contabilidad'"></contabilidad>
    <nomina v-if="tabActual == 'Nómina'"></nomina>
  </div>
</template>

<script>
import Contabilidad from './contabilidad/Contabilidad'
import Nomina from './nomina/Nomina'

export default {
  components: { Contabilidad, Nomina },
  data() {
    return {
      tabs: ['Contabilidad', 'Nómina'],
      tabActual: 'Contabilidad',
    }
  },
}
</script>

<style scoped>
.parametro-item {
  color: #2a93d5;
  margin: 0px 8px;
}
.icon-tab {
  font-size: 1.2rem;
  font-weight: bold;
}
</style>
