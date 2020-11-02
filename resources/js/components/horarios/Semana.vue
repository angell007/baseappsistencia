<template>
  <div>
    <div class="form-group col-4 offset-4 pl-0 d-flex">
      <turnos :turnos="turnos" ref="horarioAsignacion"></turnos>
      <button class="btn btn-link" @click="asignarHorariosMasivo">Asignar</button>
    </div>
    <table class="table-bordered table-sm table-responsive">
      <thead>
        <tr>
          <th class="text-center">Funcionario</th>
          <th
            class="text-center"
            v-for="(dia) in diasSemana"
            :key="dia.dia"
          >{{dia.dia}} {{formatFecha(dia.fecha)}}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="funcionario in funcionarios" :key="funcionario.id">
          <td class="funcionario-td">

            <img v-if="funcionario.image!=null" :src="`/back/storage/app/public/${funcionario.image}`" alt="" class="img-funcionario" >
            <img v-else :src="`/img/robot.jpg`" class="img-funcionario mr-1" alt="" >

            <span>{{funcionario.nombres.split(" ")[0] }} {{funcionario.apellidos.split(" ")[0] }}</span>
          </td>
          <td class="text-center custom-label" v-for="dia in diasSemana" :key="dia.dia">
            <turnos :turnos="turnos" :ref="'turnos' + funcionario.id" ></turnos>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="form-group col-12 mt-3">
      <button class="btn btn-secondary default btn-xs btn-block" @click="makeHorario">Guardar</button>
    </div>
  </div>
</template>

<script>
import Turnos from './Turnos'
export default {
  components: { Turnos },
  props: {
    funcionarios: Array,
    turnosRotativos: Array,
    diaInicial: Object,
    diaFinal: Object,
  },

  data() {
    return {
      diasSemana: [],
      turnos: this.turnosRotativos,
      horarios: [],
      horariosExistentes: [],
      diaInicialSemana: this.diaInicial,
    }
  },

  created() {
    this.fillDiasSemana()
  },

  mounted() {
    this.asignarHorariosExistentes()
  },

  methods: {
    fillDiasSemana() {
      while (this.diaInicialSemana < this.diaFinal) {
        this.diasSemana.push({
          dia: this.diaInicialSemana.format('dddd'),
          fecha: this.diaInicialSemana.format('YYYY-MM-DD'),
        })
        this.diaInicialSemana = moment(this.diaInicialSemana).add(1, 'd')
      }
    },
    asignarHorariosExistentes() {
     this.funcionarios.forEach(funcionario => {
      if (funcionario.horarios_turno_rotativo.length) {
        this.horariosExistentes = this.diasSemana.map(dia => {
          return funcionario.horarios_turno_rotativo.find(horario => {
            return dia.fecha == horario.fecha
          })
        })

        this.horariosExistentes.forEach(dia => {
          let index = null
          if (dia !== undefined) {
            index = this.horariosExistentes.indexOf(dia)
            let id="turnos"+funcionario.id;
            this.$refs[id][index].turno = dia.turno_rotativo_id
            let { color } = this.turnos.find(turno => {
              return turno.id === dia.turno_rotativo_id
            })
            this.$refs[id][index].withColor = color
          }
        })
      }
      })
    },

    makeHorario() {
      let index = null
      this.horarios = []
      this.funcionarios.forEach(funcionario => {
        this.diasSemana.forEach(dia => {
            index = this.diasSemana.indexOf(dia)
            let id="turnos"+funcionario.id;
            if (this.$refs[id][index].turno !== 'seleccione') {
            this.horarios.push({
                funcionario_id: funcionario.id,
                turno_rotativo_id: this.$refs[id][index].turno,
                fecha: dia.fecha,
                numero_semana: moment().format('ww'),
            })
            }
        })
      })
      if (this.horarios.length) {
        this.$emit('asignados', this.horarios)
      }
    },

    asignarHorariosMasivo() {
      this.$children.forEach(child => {
        child.turno = this.$refs.horarioAsignacion.turno
        child.withColor = this.$refs.horarioAsignacion.withColor
      })
    },

    formatFecha(fecha) {
      return moment(fecha).format('DD/MM/YYYY')
    },
  },
}
</script>

<style scoped>
table thead th {
  font-size: 14px;
  width: 200px;
}

table thead th:first-child {
  width: 200px;
}
.funcionario-td {
  padding: 7px;
  font-size: 12px;
}

.img-funcionario {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  margin-right: 5px;
  float: left;
  border:1px solid #ccc;
}
</style>
