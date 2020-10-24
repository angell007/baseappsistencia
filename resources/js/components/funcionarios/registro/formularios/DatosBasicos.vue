<template>
  <div class="row">
    <div class="col-12">
      <form @submit.prevent>
        <fieldset>
          <legend class="text-right">Datos básicos</legend>

          <div class="separator mb-3"></div>
          <div class="form-row mt-3">
            <div class="form-group col-md-2 text-center">
              <img
                id="imageOutput"
                src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&size=100"
                alt="Imagen del funcionario"
                class="d-block m-auto"
              >
              <label for="image" class="subir-archivo mt-2">
                Cargar imagen
                <i class="simple-icon-doc"></i>
              </label>

              <input
                type="file"
                accept="image/*"
                name="image"
                v-validate="'required|size:800'"
                data-vv-as="Imagen"
                class="form-control-file"
                id="image"
                placeholder="Imagen"
                @change="vistaPreviaImagen"
              >

              <div class="col-md-12 text-center" v-if="errors.has('image')">
                <small class="invalid">{{errors.first('image')}}</small>
              </div>
            </div>

            <div class="col-md-6 text-left">
              <div class="form-group row mt-3">
                <label
                  for="identidad"
                  class="col-md-4 col-form-label custom-label text-right"
                >Doc. de identidad</label>
                <input
                  type="text"
                  name="identidad"
                  v-validate="'required'"
                  data-vv-as="Documento de identidad"
                  class="form-control custom-control col-md-7"
                  placeholder="Documento de identidad"
                  v-model="datosBasicos.identidad"
                >

                <div class="col-md-7 offset-4" v-if="errors.has('identidad')">
                  <small class="invalid">{{errors.first('identidad')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label for="nombres" class="col-md-4 col-form-label custom-label text-right">Nombres</label>
                <input
                  type="text"
                  name="nombres"
                  v-validate="'required'"
                  data-vv-as="Nombres"
                  class="form-control custom-control col-md-7"
                  placeholder="Nombres"
                  v-model="datosBasicos.nombres"
                >
                <div class="col-md-7 offset-4" v-if="errors.has('nombres')">
                  <small class="invalid">{{errors.first('nombres')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="apellidos"
                  class="col-md-4 col-form-label custom-label text-right"
                >Apellidos</label>
                <input
                  type="text"
                  name="apellidos"
                  v-validate="'required'"
                  data-vv-as="Apellidos"
                  class="form-control custom-control col-md-7"
                  placeholder="Apellidos"
                  v-model="datosBasicos.apellidos"
                >
                <div class="col-md-7 offset-4" v-if="errors.has('apellidos')">
                  <small class="invalid">{{errors.first('apellidos')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="email"
                  class="col-md-4 col-form-label custom-label text-right"
                >Correo electrónico</label>
                <input
                  type="email"
                  name="email"
                  v-validate="'required|email'"
                  class="form-control custom-control col-md-7"
                  v-model="datosBasicos.email"
                  placeholder="Ej: genetic@example.com"
                >
                <div class="col-md-7 offset-4" v-if="errors.has('email')">
                  <small class="invalid">{{errors.first('email')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="fecha_nacimiento"
                  class="col-md-4 col-form-label custom-label text-right"
                >Fecha de nacimiento</label>
                <calendario ref="fechaNacimiento"></calendario>
                <div class="col-md-12" v-if="errors.has('fecha_nacimiento')">
                  <small class="invalid">{{errors.first('fecha_nacimiento')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="lugar_nacimiento"
                  class="col-md-4 col-form-label custom-label text-right"
                >Lugar de nacimiento</label>
                <input
                  type="text"
                  v-validate="'required'"
                  data-vv-as="Lugar de nacimiento"
                  class="form-control custom-control col-md-7"
                  name="lugar_nacimiento"
                  v-model="datosBasicos.lugar_nacimiento"
                >
                <div class="col-md-7 offset-4" v-if="errors.has('lugar_nacimiento')">
                  <small class="invalid">{{errors.first('lugar_nacimiento')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="direccion_residencia"
                  class="col-md-4 col-form-label custom-label text-right"
                >Dirección residencia</label>
                <input
                  type="text"
                  v-validate="'required'"
                  data-vv-as="Dirección de residencia"
                  name="direccion_residencia"
                  class="form-control custom-control col-md-7"
                  v-model="datosBasicos.direccion_residencia"
                >
                <div class="col-md-7 offset-4" v-if="errors.has('direccion_residencia')">
                  <small class="invalid">{{errors.first('direccion_residencia')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="telefono"
                  class="col-md-4 col-form-label custom-label text-right"
                >Teléfono</label>
                <input
                  type="text"
                  v-validate="'numeric'"
                  name="telefono"
                  class="form-control custom-control col-md-7"
                  v-model="datosBasicos.telefono"
                >
                <small
                  class="invalid col-md-7 offset-4"
                  v-if="errors.has('telefono')"
                >{{errors.first('telefono')}}</small>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group row mt-3">
                <label for="sexo" class="col-md-3 col-form-label custom-label text-right">Género</label>
                <select
                  class="form-control custom-control col-md-7"
                  v-model="datosBasicos.sexo"
                  name="sexo"
                >
                  <option selected value="Masculino">Masculino</option>
                  <option value="Femenino">Femenino</option>
                </select>
                <div class="col-md-12" v-if="errors.has('sexo')">
                  <small class="invalid">{{errors.first('sexo')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="tipo_sangre"
                  class="col-md-3 col-form-label custom-label text-right"
                >T. Sangre</label>
                <select
                  class="form-control custom-control col-md-7"
                  name="tipo_sangre"
                  v-model="datosBasicos.tipo_sangre"
                >
                  <option
                    v-for="(tipo,index) in datos.tipoSangre"
                    :key="index"
                    :value="tipo.valor"
                  >{{tipo.clave}}</option>
                </select>
                <div class="col-md-12" v-if="errors.has('tipo_sangre')">
                  <small class="invalid">{{errors.first('tipo_sangre')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label for="celular" class="col-md-3 col-form-label custom-label text-right">Celular</label>
                <input
                  type="text"
                  v-validate="'required|numeric|min:10|max:15'"
                  data-vv-as="Celular"
                  name="celular"
                  class="form-control custom-control col-md-7"
                  v-model="datosBasicos.celular"
                >
                <small
                  class="invalid col-md-7 offset-3"
                  v-if="errors.has('celular')"
                >{{errors.first('celular')}}</small>
              </div>

              <div class="form-group row">
                <label
                  for="estado_civil"
                  class="col-md-3 col-form-label custom-label text-right"
                >Est. Civil</label>
                <select
                  name="estado_civil"
                  class="form-control custom-control col-md-7"
                  v-model="datosBasicos.estado_civil"
                >
                  <option
                    v-for="(estado,index) in datos.estados"
                    :key="`A-${index}`"
                    :value="estado.valor"
                  >{{estado.clave}}</option>
                </select>
                <div class="col-md-12" v-if="errors.has('estado_civil')">
                  <small class="invalid">{{errors.first('estado_civil')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="numero_hijos"
                  class="col-md-3 col-form-label custom-label text-right"
                ># Hijos</label>
                <input
                  type="number"
                  name="numero_hijos"
                  class="form-control custom-control col-md-7"
                  v-model="datosBasicos.numero_hijos"
                >
                <div class="col-md-12" v-if="errors.has('numero_hijos')">
                  <small class="invalid">{{errors.first('numero_hijos')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="grado_instruccion"
                  class="col-md-3 col-form-label custom-label text-right"
                >Grado</label>
                <select
                  name="grado_instruccion"
                  class="form-control custom-control col-md-7"
                  v-model="datosBasicos.grado_instruccion"
                >
                  <option
                    v-for="(grado,index) in datos.instruccion"
                    :key="`B-${index}`"
                    :value="grado.valor"
                  >{{grado.clave}}</option>
                </select>
                <div class="col-md-12" v-if="errors.has('grado_instruccion')">
                  <small class="invalid">{{errors.first('grado_instruccion')}}</small>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="titulo_estudio"
                  class="col-md-3 col-form-label custom-label text-right"
                >Título</label>
                <input
                  type="text"
                  v-validate="'alpha_spaces'"
                  data-vv-as="Título"
                  name="titulo_estudio"
                  class="form-control custom-control col-md-7"
                  v-model="datosBasicos.titulo_estudio"
                >
                <div class="col-md-7 offset-3" v-if="errors.has('titulo_estudio')">
                  <small class="invalid">{{errors.first('titulo_estudio')}}</small>
                </div>
              </div>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</template>

<script>
import atributos from './datos/atributosFuncionario'
import Calendario from '../../../utiles/Calendario'
export default {
  components: { Calendario },
  data() {
    return {
      datosBasicos: '',
      datos: '',
      imagenTemporal: '',
    }
  },
  created() {
    this.datosBasicos = atributos.funcionario.datosBasicos

    this.datos = atributos.datos
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (!validado) {
        this.$swal.fire('Oops!', 'Corrige los errores antes de enviar', 'error')
        return false
      }
      return true
    },
    async guardarDatosBasicos() {
      let validado = await this.validarAntesDeEnviar()

      if (validado) {
        this.datosBasicos.fecha_nacimiento = this.$refs.fechaNacimiento.formatearFecha()

        return true
      }
    },

    vistaPreviaImagen(event) {
      const image = document.getElementById('imageOutput')
      image.src = URL.createObjectURL(event.target.files[0])
      if (event.target.files.length > 0) {
        this.imagenTemporal = event.target.files[0]
      }
    },

    limpiarDatos() {
      const excepciones = [
        'liquidado',
        'tipo_sangre',
        'estado_civil',
        'grado_instruccion',
        'personId',
        'persistedFaceId',
        'numero_hijos',
        'sexo',
      ]
      for (let propiedad in this.datosBasicos) {
        if (excepciones.includes(propiedad)) {
          continue
        }
        this.datosBasicos[propiedad] = ''
      }
    },
  },
}
</script>

<style scoped>
input[type='file'] {
  display: none;
}
.subir-archivo {
  border: 1px solid #ccc;
  display: inline-block;
  padding: 6px 12px;
  font-weight: bold;
  cursor: pointer;
}
.subir-archivo {
  font-family: 'Lato';
  color: #7a7e7e;
}
fieldset legend {
  font-size: 1.2rem;
}
#imageOutput {
  width: 100px;
  height: 100px;
  border-radius: 50%;
}
</style>
