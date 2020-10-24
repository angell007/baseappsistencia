<template>
  <div class="overlay">
    <div class="container-spinner">
      <semipolar-spinner :animation-duration="800" :size="70" color="#fff"/>
      <p class="text-center font-weight-bold text-spinner">Cargando módulo...</p>
    </div>
  </div>
</template>

<script>
import { SemipolarSpinner } from 'epic-spinners'

export default {
  components: { SemipolarSpinner },
}
</script>

<style>
</style>
