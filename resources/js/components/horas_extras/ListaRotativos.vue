<template>
  <div v-show="mostrarLista">
    <div
      v-for="(diario,indexD) in funcionario.diarios_turno_rotativo"
      :key="indexD"
      class="row pl-3"
    >
      <rotativo :ref="'rotativo' + funcionario.id" :funcionario="funcionario" :diario="diario"></rotativo>
    </div>
  </div>
</template>

<script>
import Rotativo from './Rotativo'

export default {
  props: { funcionario: Object },
  components: { Rotativo },
  data() {
    return {
      mostrarLista: false,
    }
  },
}
</script>

<style>
</style>
