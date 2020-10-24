<template>
    <div class="container" >
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                <div class="col-md-6">
                    <h3>{{encuesta.nombre}}</h3>
                    <p><strong>Descripción:</strong> {{encuesta.descripcion}}</p>
                </div>
                <div class="col-md-3">
                    <h4><i class="simple-icon-calendar"></i> Aplicación</h4>
                    <p>Frecuencia de Aplicación: <span class="custom-label"> {{encuesta.frecuencia_aplicacion}} </span></p>
                    <p>Tipo de Aplicación: <span class="custom-label"> {{encuesta.tipo_aplicacion}} </span></p>
                </div>
                <div class="col-md-3">
                    <h4><i class="simple-icon-list"></i> Condiciones</h4>
                    <p>¿Es Restrictiva?: <span class="custom-label"> {{encuesta.restrictiva}} </span></p>
                    <p>Fecha Inicio: <span class="custom-label"> {{encuesta.fecha_inicio}} </span></p>
                    <p>Estado: <span class="custom-label"> {{encuesta.estado}} </span></p>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row mt-4 mb-2">
              <div class="col-md-8 offset-4">
                <div class="pl-3">
                  <button
                    v-for="(tab,indexTab) in tabs"
                    :key="indexTab"
                    :class="['tab-button', { active: tabActual === tab }]"
                    @click="tabActual=tab"
                  >{{tab}}</button>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-12">
                    <Preguntas
                    :encuesta="encuesta"
                    v-if="tabActual === 'Preguntas'"
                  ></Preguntas>
                  <Respuestas
                    :encuesta="encuesta.id"
                    v-if="tabActual === 'Respuestas'"
                  ></Respuestas>
                  <Indicadores
                    :encuesta="encuesta.id"
                    v-if="tabActual === 'Indicadores'"
                  ></Indicadores>




              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </div>
</template>

<script>
import Preguntas from './tabs/Preguntas'
import Respuestas from './tabs/Respuestas'
import Indicadores from './tabs/Indicadores'

export default {
    components: { Preguntas, Respuestas, Indicadores },

    data() {
        return {
            encuesta: {
                preguntas : []
            },
            tabs: ['Preguntas', 'Respuestas', 'Indicadores'],
            tabActual: 'Preguntas',
        }
    },
    created() {
        //
        this.obtenerEncuesta(this.$route.params.id);

    },
    methods: {
        obtenerEncuesta(id){
            axios.get(`/api/encuestas/${id}/mostrar`).then(datos => {
                this.encuesta = datos.data;
            })
        },

    }

}
</script>

<style>
.custom-label{
    text-transform: uppercase;
    color: #2a93d5;
}
.info-calculo-general {
  border: 1px solid #b9b3b3;
}
table {
  border: 1px solid #b9b3b3;
}
.tab-button {
  padding: 6px 10px;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
  border: 1px solid #ccc;
  cursor: pointer;
  background: #fff;
  margin-bottom: -1px;
  margin-right: -1px;
  font-weight: 600;
  color: #09151ddf;
}
.tab-button:hover {
  background: #e0e0e0;
}
.tab-button.active {
  background: #2a93d5;
  color: #f0f0f0;
  font-weight: bold;
}
.tab {
  border: 1px solid #ccc;
  padding: 10px;
}
#img-funcionario {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 1px solid #f5f4f4;
}
.cargo-funcionario {
  color: #2a93d5;
}
</style>
