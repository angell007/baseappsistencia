<template>
  <div class="card">
    <div v-if="funcionarios.length" class="card-title pl-3 pt-3 mb-1 font-weight-bold">
      
      <span>Contratos por vencer</span>

      <img src="img/birthday-icon.svg" class="svg-icon" alt="Cumple-icon">
    </div>
    <div class="card-body pl-3 pr-3 pt-0 pb-3">
      <p
        class="text-center mt-4"
        v-if="!funcionarios.length"
      ><img src="/img/contratos.png" class="img-fluid" alt="sin contratos" ></p>      
      <!--<div
        class="d-flex flex-column justify-content-center align-items-center tarjeta-contrato pt-1"
        v-for="(funcionario,index) in funcionarios"
        :key="index"
        v-else
      >
        <img v-if="funcionario.image!=null" :src="`back/storage/app/public/${funcionario.image}`"  class="img-funcionario" alt="" >
        <img v-else :src="`/img/robot.jpg`" class="img-funcionario" alt="" >
        <p class="font-weight-bold mb-0">{{funcionario.nombres.split(" ")[0]}} {{funcionario.apellidos.split(" ")[0]}}</p>

        <small class="font-weight-bold">Vence el {{funcionario.fecha_retiro}}</small>
        <small class="mb-1">(En {{funcionario.dias_restantes}} días)</small>
      </div> -->
      <table v-else class="table tabla-contratos">
        <tr v-for="(funcionario,index) in funcionarios" :key="index">
          <td>
            <img v-if="funcionario.image!=null" :src="`back/storage/app/public/${funcionario.image}`"  class="img-funcionario" alt="" >
            <img v-else :src="`/img/robot.jpg`" class="img-funcionario" alt="" >
          </td>
          <td>
            <p class="font-weight-bold mb-0">{{funcionario.nombres.split(" ")[0]}}<br>{{funcionario.apellidos.split(" ")[0]}}</p>
            <small class="mb-1">(En {{funcionario.dias_restantes}} días)</small>
          </td>
          <td>
            <a href="" alt="Enviar Preaviso" class="btn-preaviso" ><i class="iconsmind-Paper-Plane"></i></a>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: { funcionarios: Array },
}
</script>

<style scoped>
.svg-icon {
  width: 38px;
  display: inline-block;
  padding-bottom: 10px;
  padding-left: 4px;
}
.btn-preaviso{
  font-size: 22px;
  color: #275c9c;
}
.tabla-contratos td, .tabla-contratos th{
  padding: 5px;
  vertical-align: middle;
}
.tarjeta-contrato{
  border-bottom: 1px dotted #ccc;
}
.img-funcionario {
  width: 42px;
  border-radius: 50%;
  border: 1px solid #ccc;
}
</style>
