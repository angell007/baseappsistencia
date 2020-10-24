<template>
  <div class="container">
    <h1 class="mt-2 ml-1 mb-2">
      Información de la Compañía
      <i class="iconsmind-Building"></i>
    </h1>
    <div class="card" v-if="renderizarContenido">
      <div class="card-body">
        <form @submit.prevent="validarAntesDeEnviar">
          <div class="row">
            <div class="col-md-6">
              <fieldset>
                <legend class="text-left">Datos básicos</legend>
                <div class="separator mt-2 mb-5"></div>
                <div class="form-row">
                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="razon_social"
                        class="col-md-4 col-form-label text-right"
                      >Razón social</label>
                      <input
                        type="text"
                        v-validate="'required'"
                        data-vv-as="Razón social"
                        name="razon_social"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.razon_social"
                        placeholder="Razón social de la compañía"
                      >
                      <small
                        v-if="errors.has('razon_social')"
                        class="invalid col-md-7 offset-4"
                      >{{errors.first('razon_social')}}</small>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="tipo_documento"
                        class="col-md-4 col-form-label text-right"
                      >Tipo de documento.</label>
                      <select
                        name="tipo documento"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.tipo_documento"
                      >
                        <option value="NIT">NIT</option>
                        <option value="Cédula de ciudadanía">Cédula de ciudadanía</option>
                        <option value="Cédula de extranjería">Cédula de extranjería</option>
                        <option value="Tarjeta de identidad">Tarjeta de identidad</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="numero_documento"
                        class="col-md-4 col-form-label text-right"
                      >Número de documento</label>
                      <input
                        type="text"
                        v-validate="'required|min:5|max:12'"
                        data-vv-as="Número de documento"
                        name="numero_documento"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.numero_documento"
                        placeholder="Número de documento"
                      >
                      <small class="invalid col-md-7 offset-4">{{errors.first('numero_documento')}}</small>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="fecha_constitucion"
                        class="col-md-4 col-form-label text-right"
                      >Fecha de constitución</label>

                      <calendario ref="calendario"></calendario>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="email_contacto"
                        class="col-md-4 col-form-label text-right"
                      >Email de contacto</label>
                      <input
                        v-validate="'required|email'"
                        data-vv-as="Email de contacto"
                        type="email"
                        name="email_contacto"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.email_contacto"
                        placeholder="Correo electrónico"
                      >
                      <small class="invalid col-md-7 offset-4">{{ errors.first('email_contacto') }}</small>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="telefono_contacto"
                        class="col-md-4 col-form-label text-right"
                      >Teléfono</label>
                      <input
                        type="text"
                        v-validate="'required|numeric|max:10'"
                        data-vv-as="Teléfono"
                        name="telefono_contacto"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.telefono_contacto"
                        placeholder="Número de teléfono"
                      >
                      <small class="invalid col-md-7 offset-4">{{errors.first('telefono_contacto')}}</small>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>

            <div class="col-md-6">
              <fieldset>
                <legend class="text-right">Datos de nómina</legend>
                <div class="separator mt-2 mb-5"></div>
                <div class="form-row">
                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="max_horas_extras"
                        class="col-md-4 col-form-label text-right"
                      >Máx. núm. horas extras</label>
                      <input
                        type="text"
                        step="1"
                        v-validate="'required:true|numeric|max_value:48|min_value:0'"
                        name="max_horas_extras"
                        data-vv-as="Máximo numero de horas extras"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.max_horas_extras"
                        placeholder="48"
                        value="48"
                      >
                      <small class="invalid col-md-7 offset-4">{{errors.first('max_horas_extras')}}</small>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="max_festivos_legales"
                        class="col-md-4 col-form-label text-right"
                      >Máx. núm. fest. legales</label>
                      <input
                        type="text"
                        v-validate="'required:true|numeric|max_value:20|min_value:0'"
                        name="max_festivos_legales"
                        data-vv-as="Máximo número de festivo legales"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.max_festivos_legales"
                        placeholder="0"
                        value="5"
                      >
                      <small
                        class="invalid col-md-7 offset-4"
                      >{{errors.first('max_festivos_legales')}}</small>
                    </div>
                  </div>

                  <div class="col-md-12 px-2">
                    <div class="form-group row">
                      <label
                        for="max_llegadas_tarde"
                        class="col-md-4 col-form-label text-right"
                      >Máx. núm. lleg. tarde</label>
                      <input
                        type="text"
                        v-validate="'required|numeric|max_value:20|min_value:0'"
                        name="max_llegadas_tarde"
                        data-vv-as="Máximo número de llegadas tarde"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.max_llegadas_tarde"
                        placeholder="3"
                      >
                      <small
                        class="invalid col-md-7 offset-4"
                      >{{errors.first('max_llegadas_tarde')}}</small>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="salario_base"
                        class="col-md-4 col-form-label text-right"
                      >Salario base</label>
                      <input
                        type="text"
                        name="salario_base"
                        v-validate="'required|numeric'"
                        data-vv-as="Salario base"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.salario_base"
                        placeholder="Salario base o salario mínimo 2020 $877.803"
                      >
                      <small
                        v-if="errors.has('salario_base')"
                        class="invalid col-md-7 offset-4"
                      >{{errors.first('salario_base')}}</small>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="auxilio_transporte"
                        class="col-md-4 col-form-label text-right"
                      >Aux. transporte</label>
                      <input
                        type="number"
                        v-validate="'required|numeric'"
                        data-vv-as="Auxilio de transporte"
                        name="auxilio_transporte"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.auxilio_transporte"
                        placeholder="Valor de auxilio de transporte 2020 $102.854"
                      >
                      <small
                        v-if="errors.has('auxilio_transporte')"
                        class="invalid col-md-7 offset-4"
                      >{{errors.first('auxilio_transporte')}}</small>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="hora_inicio_noche"
                        class="col-md-4 col-form-label text-right"
                      >Hora inicio noche</label>

                      <calendario-hora default="21:00:00" ref="horaInicioNoche"></calendario-hora>
                      <small
                        v-if="errors.has('date')"
                        class="invalid col-md-7 offset-4"
                      >{{errors.first('date')}}</small>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="hora_fin_noche"
                        class="col-md-4 col-form-label text-right"
                      >Hora fin noche</label>
                      <calendario-hora default="06:00:00" ref="horaFinNoche"></calendario-hora>
                      <small
                        v-if="errors.has('hora_fin_noche')"
                        class="invalid col-md-7 offset-4"
                      >{{errors.first('hora_fin_noche')}}</small>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>

            <div class="col-md-6 mt-4">
              <fieldset>
                <legend>Pago de nómina</legend>
                <div class="separator mt-2 mb-5"></div>
                <div class="form-row">
                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="frecuencia_pago"
                        class="col-md-4 col-form-label text-right"
                      >Frecuencia de Pago</label>
                      <select
                        name="frecuencia_pago"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.frecuencia_pago"
                      >
                        <option value="Mensual">Mensual</option>>
                        <option value="Quincenal">Quincenal</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="medio_pago"
                        class="col-md-4 col-form-label text-right"
                      >Medio de Pago</label>
                      <select
                        type="text"
                        name="medio_pago"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.medio_pago"
                      >
                        <option value="Transferencia Bancaria">Transferencia Bancaria</option>>
                        <option value="Efectivo">Efectivo</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="col-md-12 px-3">
                    <div class="form-group row mb-0">
                      <label
                        for="banco_id"
                        class="col-md-4 col-form-label text-right"
                      >Banco del pago</label>

                      <multiselect
                        :max-height="200"
                        name="banco_id"
                        placeholder="Seleccione una opción"
                        selectLabel="Enter para seleccionar"
                        deselectLabel="Enter para remover"
                        v-validate="'required'"
                        data-vv-as="Banco del pago"
                        v-model="empresa.banco_id"
                        :options="bancosDatos"
                        class="col-md-7 multiselect-custom font-weight-bold"
                        label="nombre"
                        track-by="id"
                      ></multiselect>
                      <small
                        v-if="errors.has('banco_id')"
                        class="invalid col-md-7 offset-4"
                      >{{errors.first('banco_id')}}</small>
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="tipo_cuenta"
                        class="col-md-4 col-form-label text-right"
                      >Tipo de cuenta</label>
                      <select
                        name="tipo_cuenta"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.tipo_cuenta"
                      >
                        >
                        <option value="Cuenta de Ahorros">Cuenta de Ahorros</option>>
                        <option value="Cuenta Corriente">Cuenta Corriente</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="numero_cuenta"
                        class="col-md-4 col-form-label text-right"
                      >Nro. de cuenta</label>
                      <input
                        v-validate="'required|min:10|max:23'"
                        data-vv-as="Número de cuenta"
                        type="text"
                        name="numero_cuenta"
                        class="form-control custom-control col-md-7"
                        v-model="empresa.numero_cuenta"
                      >
                      <small
                        class="invalid col-md-7 offset-4"
                        v-if="errors.has('numero_cuenta')"
                      >{{errors.first('numero_cuenta')}}</small>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>

            <div class="col-md-6 mt-4">
              <fieldset>
                <legend class="text-right">Pila</legend>
                <div class="separator mt-2 mb-5"></div>
                <div class="form-row">
                  <div class="col-md-12 px-3">
                    <div class="form-group row">
                      <label
                        for="operador_pago"
                        class="col-md-5 col-form-label text-right"
                      >Operador de Pago utilizado</label>
                      <select
                        name="operador_pago"
                        class="form-control custom-control col-md-6"
                        v-model="empresa.operador_pago"
                      >
                        <option
                          v-for="(operador, index) in operadoresPago"
                          :key="index"
                          :value="operador.valor"
                        >{{operador.llave}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group row">
                      <label
                        for="arl"
                        class="col-md-5 col-form-label text-right"
                      >Compañía ARL utilizada</label>
                      <multiselect
                        v-model="empresa.arl_id"
                        name="arl_id"
                        v-validate="'required'"
                        data-vv-as="Compañía arl"
                        :options="arlDatos"
                        class="col-md-6 multiselect-custom font-weight-bold"
                        placeholder="Seleccione una opción"
                        deselectLabel="Enter para remover"
                        selectLabel="Enter para seleccionar"
                        label="nombre"
                      ></multiselect>
                      <small
                        class="invalid col-md-6 offset-5"
                        v-if="errors.has('arl_id')"
                      >{{errors.first('arl_id')}}</small>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label
                    for="ley_1429"
                    class="col-sm-5 col-md-5 col-form-label text-right"
                  >Aplica Ley 1429 de 2010?</label>
                  <div class="col-md-6">
                    <div class="custom-control custom-checkbox">
                      <input
                        type="checkbox"
                        v-model="empresa.ley_1429"
                        name="ley_1429"
                        id="custom1429"
                        class="custom-control-input"
                      >
                      <label
                        class="custom-control-label"
                        for="custom1429"
                        v-if="empresa.ley_1429"
                      >Si</label>
                      <label class="custom-control-label" for="custom1429" v-else>No</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label
                    for="ley_590"
                    class="col-sm-5 col-md-5 col-form-label text-right"
                  >Aplica Ley 590 de 2000?</label>
                  <div class="col-md-6">
                    <div class="custom-control custom-checkbox">
                      <input
                        type="checkbox"
                        v-model="empresa.ley_590"
                        name="ley_590"
                        id="custom590"
                        class="custom-control-input"
                      >
                      <label class="custom-control-label" for="custom590" v-if="empresa.ley_590">Si</label>
                      <label class="custom-control-label" for="custom590" v-else>No</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label
                    for="ley_1607"
                    class="col-sm-5 col-md-5 col-form-label text-right"
                  >Aplica Ley 1607 de 2012?</label>
                  <div class="col-md-6">
                    <div class="custom-control custom-checkbox">
                      <input
                        type="checkbox"
                        v-model="empresa.ley_1607"
                        name="ley_1607"
                        id="custom1607"
                        class="custom-control-input"
                      >
                      <label
                        class="custom-control-label"
                        for="custom1607"
                        v-if="empresa.ley_1607"
                      >Si</label>
                      <label class="custom-control-label" for="custom1607" v-else>No</label>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
          <div class="text-center mt-2">
            <button class="btn btn-secondary raised" type="submit">
              <i class="simple-icon-check font-weight-bold"></i> Registrar
            </button>
          </div>
        </form>
      </div>
    </div>
    <overlay v-else></overlay>
  </div>
</template>

<script>
import OperadoresPago from './datos/operadoresPago.js'
import Calendario from '../../utiles/Calendario'
import CalendarioHora from '../../utiles/CalendarioHora'
import Overlay from '../../utiles/Overlay'

export default {
  components: { Calendario, CalendarioHora, Overlay },
  data() {
    return {
      empresa: {
        id: '',
        razon_social: '',
        tipo_documento: 'NIT',
        numero_documento: '',
        fecha_constitucion: '',
        email_contacto: '',
        telefono_contacto: '',
        max_horas_extras: '48',
        max_festivos_legales: '5',
        max_llegadas_tarde: '3',
        salario_base: '877803',
        auxilio_transporte: '102854',
        hora_inicio_noche: '',
        hora_fin_noche: '',
        frecuencia_pago: 'Mensual',
        medio_pago: 'Transferencia Bancaria',
        banco_id: '',
        tipo_cuenta: 'Cuenta de Ahorros',
        numero_cuenta: '',
        operador_pago: '',
        arl_id: '',
        ley_1429: false,
        ley_590: false,
        ley_1607: false,
      },
      operadoresPago: [],
      arlDatos: [],
      bancosDatos: [],
      //Bandera
      renderizarContenido: false,
    }
  },
  created() {
    this.comprobarRegistro()
    this.operadoresPago = OperadoresPago.operadoresPago
    this.empresa.operador_pago = this.operadoresPago[0].llave
    this.getAllData()
  },
  methods: {
    getAllData() {
      axios.all([this.getArlDatos(), this.getBancosDatos()]).then(
        axios.spread((arlDatos, bancosDatos) => {
          this.arlDatos = arlDatos.data
          this.bancosDatos = bancosDatos.data
          this.renderizarContenido = true
        })
      )
    },
    comprobarRegistro() {
      axios.get('/api/general/empresa/datos').then(datos => {
        if (datos.data.length > 0) {
          this.$swal.fire(
            'Hecho!',
            'Ya ha registrado la empresa antes',
            'success'
          )
          this.$router.push({ name: 'General' })
        }
      })
    },
    validarAntesDeEnviar() {
      this.empresa.banco_id = this.empresa.banco_id.id
      this.empresa.arl_id = this.empresa.arl_id.id
      this.empresa.fecha_constitucion = moment(
        this.$refs.calendario.fechaSeleccionada
      ).format('YYYY-MM-DD')
      this.empresa.hora_inicio_noche = moment(
        this.$refs.horaInicioNoche.horaSeleccionada
      ).format('HH:mm:ss')
      this.empresa.hora_fin_noche = moment(
        this.$refs.horaFinNoche.horaSeleccionada
      ).format('HH:mm:ss')

      this.$validator.validateAll().then(resultado => {
        if (resultado) {
          this.postEmpresaFormulario()
          return
        }
        this.$swal.fire(
          'Error al Registrar',
          'Debe llenar los campos marcados como obligatorios',
          'error'
        )
      })
    },
    postEmpresaFormulario() {
      axios
        .post('/api/general/empresa/crear', this.$data.empresa)
        .then(respuesta => {
          this.$swal('Excelente!', respuesta.data.message, 'success').then(
            () => {
              this.$router.push({ name: 'General' })
            }
          )
          this.limpiarFormulario()
          this.$validator.reset()
        })
        .catch(error => {
          console.log(error.data)
        })
    },
    getArlDatos() {
      return axios.get('/api/arl/datos')
    },
    getBancosDatos() {
      return axios.get('/api/bancos/datos')
    },
    limpiarFormulario() {
      for (let prop in this.$data.empresa) {
        this.$data.empresa[prop] = ''
      }
    },
  },
  watch: {
    'empresa.numero_cuenta': function() {
      if (this.empresa.numero_cuenta.split('-').join('').length % 3 == 0) {
        this.empresa.numero_cuenta = this.empresa.numero_cuenta
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, '-')
      }
    },
    'empresa.numero_documento': function() {
      if (this.empresa.numero_documento.split('-').join('').length % 3 == 0) {
        this.empresa.numero_documento = this.empresa.numero_documento
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, '-')
      }
    },
  },
}
</script>

<style scoped>
label {
  font-weight: bolder;
  font-size: 0.88rem;
  color: rgb(88, 88, 88);
}
.separator {
  border-bottom: 1px solid #2a93d5;
}
h1 {
  color: #2a93d5;
  font-family: 'Montserrat', sans-serif;
  font-weight: 600;
}
fieldset > legend {
  font-family: 'Montserrat', sans-serif;
  font-weight: 600;
  color: rgb(88, 88, 88);
}
.form-row {
  padding-top: 1rem;
  background-color: rgb(247, 247, 247);
}
.multiselect-custom {
  padding-left: 0;
}
</style>
