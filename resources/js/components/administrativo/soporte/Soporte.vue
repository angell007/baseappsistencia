<template>
<div class="container" v-if="renderizarTablero">
    <div class="row icon-cards">
        <div class="col-12">
            <div class="row">
                <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                    <div class="card-body text-center">
                        <i class="iconsmind-Receipt-2"></i>
                        <p class="card-text mb-0">Tickets Generados</p>
                        <p class="lead card-item-tablero text-center">6</p>
                    </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                    <div class="card-body text-center">
                        <i class="iconsmind-Like"></i>
                        <p class="card-text mb-0">Tickets Solucionados</p>
                        <p class="lead card-item-tablero text-center">6</p>
                    </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                    <div class="card-body text-center">
                        <i class="iconsmind-Sand-watch"></i>
                        <p class="card-text mb-0">Tickets Pendientes</p>
                        <p class="lead card-item-tablero text-center">0</p>
                    </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 mb-2">
                    <div class="card">
                    <div class="card-body text-center">
                        <i class="iconsmind-Alarm-Clock"></i>
                        <p class="card-text mb-0">Cumplimiento</p>
                        <p class="lead card-item-tablero text-center">100%</p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tickets de Soporte</h5>
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer" >
                        <div class="row view-filter">
                        <div class="col-sm-12">
                            <div class="float-left"></div>
                            <div class="float-right"></div>
                            <div class="clearfix"></div>
                        </div>
                        </div>
                        <table class="data-table data-table-standard table table-hover table-bordered responsive nowrap dataTable no-footer dtr-inline collapsed" >
                        <thead>
                            <tr role="row">
                                <th>Fecha Incidencia</th>
                                <th>Tipo Incidencia</th>
                                <th>Cliente</th>
                                <th>Mensajes</th>
                                <th>Estado</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ticket,index) in tickets"  :key="index">
                                <td>{{ticket.fecha}}</td>
                                <td class="text-center"><label class="badge badge-pill mb-1"
                                v-bind:class="[ticket.tipo == 'Error' ? 'badge-danger' : 'badge-secondary']" >{{ticket.tipo}}</label></td>
                                <td>{{ticket.cliente}}</td>
                                <td class="text-center">{{ticket.mensajes_count}}</td>
                                <td class="text-center">{{ticket.estado}}</td>
                                <td class="text-center">
                                    <button @click.prevent="redireccionar(ticket.id)" class="btn btn-circle btn-sm btn-info">
                                        <i class="iconsmind-Magnifi-Glass"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!tickets.length">
                                <td colspan="7" class="text-center">No existen tickets de soporte registrados en el Sistema GeneticApp.</td>
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
import Overlay from '../../utiles/Overlay'
export default {
    components: {
        Overlay
    },
    data() {
        return {
            tickets: [],
            renderizarTablero: false,
        }
    },
    created() {
        this.getAllDatos()
    },
    methods: {
        getAllDatos() {
            axios
                .all([
                this.getTickets(),
                ])
                .then(
                axios.spread(
                    (
                    TicketsDatos,
                    ) => {

                    this.tickets = TicketsDatos.data
                    this.renderizarTablero = true
                    }
                )
                )
        },
        getTickets() {
            return axios.get('/api/administrativo/tickets')
        },
        redireccionar(id) {
            this.$router.push({
                name: 'DetalleSoporte',
                params: { id: id },
            })
        },
    }

}
</script>

<style scoped>
.icon-cards i {
  font-size: 46px;
  line-height: 66px;
  color: #4bb1f0;
}
.card-item-tablero {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.3rem;
}
.img-funcionario {
  width: 42px;
  border-radius: 50%;
}
.svg-icon {
  width: 38px;
  display: inline-block;
  padding-bottom: 10px;
  padding-left: 4px;
}
</style>
