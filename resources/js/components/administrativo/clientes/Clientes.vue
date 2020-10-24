<template>
<div class="container" v-if="renderizarTablero">
    <div class="row">
        <div class="col-md-12">
            <div class="mt-4">
                <grafica-clientes :datos="graficaClientes">
                    <h4 class>Empleados Activos por Clientes Mensuales</h4>
                </grafica-clientes>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Clientes Activos</h5>
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer" >
                        <div class="row view-filter">
                        <div class="col-sm-12">
                            <div class="float-left"></div>
                            <div class="float-right"></div>
                            <div class="clearfix"></div>
                        </div>
                        </div>
                        <table class="data-table data-table-standard responsive nowrap dataTable no-footer dtr-inline collapsed" >
                        <thead>
                            <tr role="row">
                                <th>Fecha Renovación</th>
                                <th>Nombre Empresa</th>
                                <th>Empleados Activos</th>
                                <th>Tipo Licencia</th>
                                <th>Valor Contrato</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>


                            <tr v-for="(cliente,index) in clientes"  :key="index">
                                <td>{{cliente.fecha_renovacion}}</td>
                                <td>{{cliente.nombre}}</td>
                                <td class="text-center">{{cliente.empleados_activos}}</td>
                                <td class="text-center">{{cliente.tipo_negocio}}</td>
                                <td class="text-center">{{cliente.valor_contrato | moneda}}<br>{{cliente.tipo_pago}}</td>
                                <td><button @click="inactivar(cliente.nombre)" class="btn btn-round btn-sm btn-danger"><i class="iconsmind-Power-2"></i> Inactivar</button></td>
                            </tr>
                            <tr v-if="!clientes.length">
                                <td colspan="6">No existen clientes registrados en el Sistema GeneticApp.</td>
                            </tr>
                        </tbody>
                        </table>
                        <div class="row view-pager">
                        <div class="col-sm-12">
                            <div class="text-center">
                            <div  class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate" >
                                <ul class="pagination pagination-sm">
                                <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous" >
                                    <a href="#" aria-controls="DataTables_Table_0" class="page-link prev" >
                                        <i class="simple-icon-arrow-left"></i>
                                    </a>
                                </li>
                                <li class="paginate_button page-item active">
                                    <a href="#"  class="page-link" >1</a>
                                </li>
                                <li class="paginate_button page-item next disabled" id="DataTables_Table_0_next">
                                    <a href="#" class="page-link next"  >
                                    <i class="simple-icon-arrow-right"></i>
                                    </a>
                                </li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
            </div>

        </div>
    </div>

  </div>
  <overlay v-else></overlay>
</template>

<script>
import GraficaClientes from './GraficaClientes'
import Overlay from '../../utiles/Overlay'
export default {
    components: {
        GraficaClientes,
        Overlay
    },
    data() {
        return {
            renderizarTablero: false,
            graficaClientes: [],
            clientes: [],
        }
    },
    created() {
        this.getAllDatos()
    },
    methods: {
        getAllDatos() {
            axios
                .all([
                this.getClientes(),
                this.getGraficaClientes(),
                ])
                .then(
                axios.spread(
                    (
                    ClientesDatos,
                    graficaClientesDatos,
                    ) => {

                    this.clientes = ClientesDatos.data
                    this.graficaClientes = graficaClientesDatos.data
                    this.renderizarTablero = true
                    }
                )
                )
        },
        getClientes() {
            return axios.get('/api/administrativo/clientes')
        },
        getGraficaClientes() {
            return axios.get('/api/administrativo/graficaClientes')
        },
        getErrorServidor(error) {
            if (error.response) {
                this.$swal.fire(
                'Error!',
                'Han ocurrido errores, por favor intentar más tarde',
                'error'
                )
            }
        },
        inactivar(nombre){
            this.$swal.fire(
                'Error!',
                'No Puede inactivar el Cliente '+nombre+', porque usted inició sesión con permisos DEMO',
                'error'
                )
        }
    }
}
</script>

<style>

</style>
