<template>
  <div class="card">
    <div class="card-title pl-3 pt-3 mb-1 font-weight-bold">Contratos por vencer</div>
    <div class="card-body">
      <p
        v-if="!funcionarios.length"
      >En este apartado se mostrarán los funcionarios con contratos próximos a vencer. Actualmente no hay nungún contrato próximo a vencer.</p>
      <div
        class="d-flex flex-column justify-content-center align-items-center"
        v-for="(funcionario,index) in funcionarios"
        :key="index"
        v-else
      >
        <p class="font-weight-bold mb-0">{{funcionario.fecha}}</p>
        <img
          :src="`back/storage/app/public/${funcionario.image}`"
          class="img-funcionario"
          alt="Imagen funcionario"
        >
        <p class="font-weight-bold mb-0">{{funcionario.nombres}} {{funcionario.apellidos}}</p>

        <span class="custom-label">({{funcionario.contrato.nombre}})</span>
        <small class="font-weight-bold">Vence el {{funcionario.fecha_retiro}}</small>
        <small class="mb-3">(En {{funcionario.dias_restantes}} días)</small>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: { funcionarios: Array },
}
</script>

<style scoped>
.img-funcionario {
  width: 42px;
  border-radius: 50%;
}
</style>
