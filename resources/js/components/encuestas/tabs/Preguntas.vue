<template>
    <div style="margin-top:25px;">
        <div class="row mb-2" v-for="(pregunta, index) in encuesta.preguntas" :key="`${index}-pregunta`">
          <div class="col-12">
              <strong class="text-primary pregunta">{{index+1}}.) {{pregunta.pregunta}}</strong>
          </div>
          <div class="col-1">
          </div>
          <div class="col-2">
              <h6>¿Requerido?</h6> Si
          </div>
          <div class="col-2">
              <h6>Tipo Pregunta</h6> {{ pregunta.tipo_pregunta }}
          </div>
          <div class="col-4">
              <h6>Opciones</h6>
              <div v-if="pregunta.tipo_pregunta=='simple'">
                  <ul>
                      <li>Sí</li>
                      <li>No</li>
                  </ul>
              </div>
              <div v-if="pregunta.tipo_pregunta=='simple-dos'||pregunta.tipo_pregunta=='multiple'">
                  <ul>
                      <li v-for="(opcion, i) in pregunta.opciones" :key="`${i}-opcion`">{{opcion.opcion}}</li>
                  </ul>
              </div>
          </div>
          <div class="col-12"><hr></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        encuesta: Object
    },

}
</script>

<style>
    h6{
        font-size:12px;
        text-decoration: underline;
    }
    .pregunta{
        font-size: 13px;
    }
    li{
        font-size: 12px;
        padding: 0;
        line-height: 13px;
    }
</style>
