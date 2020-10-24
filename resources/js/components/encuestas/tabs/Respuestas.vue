<template>
    <div style="margin-top:25px;">
        <div class="row">
            <div class="col-md-5">
            <div class="form-group">
                <label for="fecha_inicio" class="custom-label">Fecha de Inicio</label>
                <input
                type="date"
                name="fecha_inicio"
                v-model="fecha_inicio"
                class="form-control custom-control"
                >
            </div>
            </div>
            <div class="col-md-5">
            <div class="form-group">
                <label for="fecha_fin" class="custom-label">Fecha de Fin</label>
                <input
                type="date"
                name="fecha_fin"
                v-model="fecha_fin"
                class="form-control custom-control"
                >
            </div>
            </div>
            <div class="col-md-2 pt-4 text-center">
            <button
                class="btn btn-outline-secondary default btn-xs mt-2 w-100"
                @click="cargarRespuestas(fecha_inicio,fecha_fin)"
            >
                <i class="iconsmind-Search-People"></i> Filtrar
            </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover table-stripped table-sm">
                    <thead>
                        <tr>
                            <th style="width:180px;">Fecha</th>
                            <th>Funcionario</th>
                            <th style="width:50px;">Completada</th>
                            <th style="width:50px;">Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(respuesta, index) in Respuestas" :key="`${index}-respuesta`">
                            <td>{{respuesta.fecha}}</td>
                            <td>{{respuesta.funcionario.nombres}} {{respuesta.funcionario.apellidos}}</td>
                            <td class="text-center"><i class="simple-icon-check text-success text-bold"></i></td>
                            <td class="text-center">
                                <a href="#"><i class="simple-icon-magnifier"></i></a>
                            </td>
                        </tr>
                        <tr v-if="Respuestas.length==0">
                            <td colspan="4" class="text-center text-danger"><i class="simple-icon-exclamation"></i> NO HAY RESPUESTAS REGISTRADAS EN ESTE PERÍODO DE TIEMPO</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</template>

<script>

export default {
    props: {
        encuesta: Number
    },
    data() {
        return {
            fecha_inicio: moment().format(moment.HTML5_FMT.DATE),
            fecha_fin: moment().format(moment.HTML5_FMT.DATE),
            Respuestas: []
        }
    },
    created() {
        this.cargarRespuestas(this.fecha_inicio, this.fecha_fin)
    },
    methods: {
        cargarRespuestas(fechaInicio, fechaFin) {
        axios
            .get(`/api/encuestas/respuestas/${this.encuesta}/${fechaInicio}/${fechaFin}`)
            .then(datos => {
                this.Respuestas = datos.data
            })
        }
    }

}
</script>

<style>

</style>
