<template>
  <div class="container">
    <!-- Dotación - inicio -->
    <fieldset>
      <legend class="text-right">Dotación</legend>
      <div class="separator mb-5"></div>
      <div class="form-row">
        <div class="col-md-5 offset-1">
          <div class="form-group row mt-3">
            <label
              for="talla_camisa"
              class="col-md-4 col-form-label custom-label text-right"
            >Talla de camisa</label>
            <select class="form-control custom-control col-md-7" v-model="dotacion.talla_camisa">
              <option
                v-for="(talla,index) in datos.tallaCamisa"
                :key="`C-${index}`"
                :value="talla.valor"
              >{{talla.clave}}</option>
            </select>
            <div class="col-md-12 text-center" v-if="errors.has('talla_camisa')">
              <small class="invalid">{{errors.first('talla_camisa')}}</small>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group row mt-3">
            <label
              for="talla_pantalon"
              class="col-md-4 col-form-label custom-label text-right"
            >Tall de pantalón</label>
            <select class="form-control custom-control col-md-7" v-model="dotacion.talla_pantalon">
              <option
                v-for="(talla, index) in datos.tallaPantalon"
                :key="`D-${index}`"
                :value="talla.valor"
              >{{talla.clave}}</option>
            </select>
            <div class="col-md-12 text-center" v-if="errors.has('talla_pantalon')">
              <small class="invalid">{{errors.first('talla_pantalon')}}</small>
            </div>
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-5 offset-1">
          <div class="form-group row mt-3">
            <label
              for="talla_botas"
              class="col-md-4 col-form-label custom-label text-right"
            >Tall de calzado</label>
            <select class="form-control custom-control col-md-7" v-model="dotacion.talla_botas">
              <option
                v-for="(talla,index) in datos.tallaCalzado"
                :key="`E-${index}`"
                :value="talla.valor"
              >{{talla.clave}}</option>
            </select>
            <div class="col-md-12 text-center" v-if="errors.has('talla_botas')">
              <small class="invalid">{{errors.first('talla_botas')}}</small>
            </div>
          </div>
        </div>
      </div>
    </fieldset>
    <!-- Dotación - fin -->
  </div>
</template>

<script>
import datos from './datos/atributosFuncionario'
export default {
  data() {
    return {
      datos: '',
      dotacion: '',
    }
  },
  created() {
    this.datos = datos.datos
    this.dotacion = datos.funcionario.dotacion
    this.dotacion.talla_camisa = this.datos.tallaCamisa[0].valor
    this.dotacion.talla_pantalon = this.datos.tallaPantalon[0].valor
    this.dotacion.talla_botas = this.datos.tallaCalzado[0].valor
  },
  methods: {
    guardarDotacion() {
      return true
    },
    limpiarDatos() {
      this.dotacion.talla_camisa = this.datos.tallaCamisa[0].valor
      this.dotacion.talla_pantalon = this.datos.tallaPantalon[0].valor
      this.dotacion.talla_botas = this.datos.tallaCalzado[0].valor
    },
  },
}
</script>

<style>
</style>
