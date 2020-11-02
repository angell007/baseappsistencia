<template>
  <div class="card mb-4 card-cumple">
    <div v-if="funcionarios.length" class="card-title pl-3 pt-3 mb-1 font-weight-bold text-white">
      <span>Próximos cumpleaños</span>
      <img src="img/birthday-icon.svg" class="svg-icon" alt="Cumple-icon">
    </div>
    <p
      class="text-center pl-3 pr-3 pt-4"
      v-if="!funcionarios.length"
    ><img src="/img/cumple.png" class="img-fluid" alt="sin cumpleanos" ></p>
    <div class="card-body pl-3 pr-3 pb-3 pt-0" v-else>
        <table class="table tabla-cumple">
            <tr v-for="(funcionario,index) in funcionarios" :key="index">
                <td>
                  <img v-if="funcionario.image!=null" :src="`/back/storage/app/public/${funcionario.image}`" class="img-funcionario" alt="" >
                  <img v-else :src="`/img/robot.jpg`" class="img-funcionario" alt="" >
                </td>
                <td><p class="font-weight-bold mb-0 text-white">{{funcionario.fecha}}</p></td>
                <td class="text-white">{{funcionario.nombres.split(" ")[0]}} {{funcionario.apellidos.split(" ")[0]}}</td>
            </tr>
        </table>
      <!-- <div
        class="d-flex flex-column justify-content-center align-items-center"
        v-for="(funcionario,index) in funcionarios"
        :key="index"
      >
        <p class="font-weight-bold mb-0 text-primary">{{funcionario.fecha}}</p>
        <img
          :src="`back/storage/app/public/${funcionario.image}`"
          class="img-funcionario"
          alt="Imagen funcionario"
        >
        <p class="font-weight-bold mb-0">{{funcionario.nombres.split(" ")[0]}} {{funcionario.apellidos}}</p>

        <span class="mb-3 custom-label">({{funcionario.anios}} años)</span>
      </div> -->
    </div>
  </div>
</template>

<script>
export default {
  props: {
    funcionarios: Array,
  },
}
</script>

<style scoped>
.card-cumple{
  background: #8bc6ea;
}
.tabla-cumple td, .tabla-cumple th{
  padding: 5px;
  vertical-align: middle;
}
.img-funcionario {
  width: 38px;
  border-radius: 50%;
}
.svg-icon {
  width: 38px;
  display: inline-block;
  padding-bottom: 10px;
  padding-left: 4px;
}
span.custom-label,
p.text-primary {
  font-family: 'Lato', sans-serif;
}
</style>
