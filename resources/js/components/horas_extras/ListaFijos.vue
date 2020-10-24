<template>
  <div v-show="mostrarLista">
    <div v-for="(diario,indexD) in funcionario.diarios_turno_fijo" :key="indexD" class="row pl-3">
      <fijo :ref="'fijo' + funcionario.id" :funcionario="funcionario" :diario="diario"></fijo>
    </div>
  </div>
</template>

<script>
import Fijo from './Fijo'

export default {
  props: { funcionario: Object },
  components: { Fijo },
  data() {
    return {
      mostrarLista: false,
    }
  },
}
</script>