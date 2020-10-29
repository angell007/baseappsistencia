<template>
  <form @submit.prevent="validarAntesDeEnviar">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label class="custom-label" for="dependencia_id">Dependencia</label>
        <multiselect
          :max-height="200"
          name="dependencia_id"
          placeholder="Seleccione una opción"
          selectLabel="Enter para seleccionar"
          deselectLabel="Enter para remover"
          v-validate="'required'"
          data-vv-as="Dependencia"
          v-model="dependenciaActual"
          :options="dependenciasDatos"
          class="font-weight-bold"
          label="nombre"
          track-by="id"
          @input="getCargos(dependenciaActual)"
        >
          <template slot="noOptions">La lista está vacía</template>
          <template slot="noResult">No existen resultados!</template>
        </multiselect>
        <small
          class="invalid"
          v-if="errors.has('dependencia_id')"
        >{{errors.first('dependencia_id')}}</small>
      </div>
      <div class="form-group col-md-6">
        <label class="custom-label" for="cargo_id">Cargo</label>
        <multiselect
          :max-height="200"
          name="cargo_id"
          placeholder="Seleccione una opción"
          selectLabel="Enter para seleccionar"
          deselectLabel="Enter para remover"
          v-validate="'required'"
          data-vv-as="Cargo"
          v-model="cargoActual"
          :options="cargosDatos"
          class="font-weight-bold"
          label="nombre"
          track-by="id"
        >
          <template slot="noOptions">La lista está vacía</template>
          <template slot="noResult">No existen resultados!</template>
        </multiselect>
        <div v-if="errors.has('cargo_id')">
          <small class="invalid">{{errors.first('cargo_id')}}</small>
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label class="custom-label" for="tipo_turno">Turno</label>
        <select name="tipo_turno" v-model="turnoActual" class="form-control custom-control">
          <option
            v-for="(tipo,index) in turnosDatos"
            :key="index"
            :value="tipo.valor"
          >{{tipo.llave}}</option>
        </select>
        <small class="invalid" v-if="errors.has('tipo_turno')">{{errors.first('tipo_turno')}}</small>
      </div>
    </div>

    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary raised">Actualizar</button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    funcionarioEditar: Object,
  },
  data() {
    return {
      mostrarModal: false,
      dependenciasDatos: [],
      cargosDatos: [],
      turnosDatos: [],
      dependenciaActual: '',
      cargoActual: '',
      turnoActual: '',
    }
  },

  created() {
    this.getDependencias()
    this.getTurnos()
  },

  methods: {
    async validarAntesDeEnviar() {
      let validado = await this.$validator.validateAll()
      if (validado) {
        this.putDatosEmpresa()
        return
      }
      this.$swal.fire(
        'Oops!',
        'Debe corregir los errores antes de enviar',
        'error'
      )
    },
    putDatosEmpresa() {
      this.funcionarioEditar.cargo_id = this.cargoActual.id
      this.funcionarioEditar.dependencia_id = this.dependenciaActual.id
      this.funcionarioEditar.tipo_turno = this.turnoActual
      this.funcionarioEditar.image='';
      delete this.funcionarioEditar["image"];
      axios
        .post(
          `/api/${localStorage.getItem('tenant')}/funcionarios/${this.funcionarioEditar.id}/editar`,
          this.funcionarioEditar
        )
        .then(respuesta => {
          this.$emit('notificar', respuesta.data.message)
          this.funcionarioEditar.dependencia.nombre = this.dependenciaActual.nombre
          this.funcionarioEditar.dependencia.centro_costo.nombre = this.dependenciaActual.centro_costo.nombre
          this.funcionarioEditar.cargo.nombre = this.cargoActual.nombre
          this.funcionarioEditar.tipo_turno = this.turnoActual
          modalEmitter.$emit('cerrar', 'datosEmpresa')
        })
        .catch(error => {
          this.$swal.fire(
            'Oops!',
            'Han ocurrido errores, por favor intentar más tarde',
            'error'
          )
        })
    },
    getDependencias() {
      axios.get(`/api/${localStorage.getItem('tenant')}/dependencias/cargos/datos`).then(datos => {
        this.dependenciasDatos = datos.data
        this.dependenciaActual = this.getDependenciaAndCargoActual(
          this.dependenciasDatos,
          'dependencia_id'
        )
        this.cargoActual = this.getDependenciaAndCargoActual(
          this.dependenciaActual.cargos,
          'cargo_id'
        )
      })
    },

    getCargos(idDependencia) {
      if (idDependencia === null) {
        this.cargoActual = null
        this.cargosDatos = []
        return false
      }
      let dependenciaSeleccionada = this.dependenciasDatos.find(dependencia => {
        return dependencia.id === idDependencia.id
      })
      this.cargosDatos = dependenciaSeleccionada.cargos
      this.cargoActual = this.cargosDatos[0]
    },

    getTurnos() {
      this.turnosDatos = [
        { llave: 'Fijo', valor: 'Fijo' },
        { llave: 'Rotativo', valor: 'Rotativo' },
      ]
      this.turnoActual = this.getTurnoActual()
    },

    getTurnoActual() {
      let { valor } = this.turnosDatos.find(turno => {
        return turno.valor === this.funcionarioEditar.tipo_turno
      })
      return valor
    },

    getDependenciaAndCargoActual(arrayDatos, datoComparacion) {
      return arrayDatos.find(dato => {
        return dato.id === this.funcionarioEditar[datoComparacion]
      })
    },
  },
}
</script>
