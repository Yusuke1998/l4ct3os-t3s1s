<template>
	<admin-layout>
		<template v-slot:header>
			<h3>Pagos</h3>
			<button
				class="btn btn-primary"
				data-toggle="modal"
				data-target="#payments"
				type="button"
				@click="
					setTitle('Crear Pago'), setAccion('create'), setClear()
				">
				<font-awesome-icon icon="handshake" />
				Nuevo Pago
			</button>
			<!-- Modals -->
			<modal :title="title" idTarget="payments" :accion="accion">
				<form-payment></form-payment>
			</modal>
		</template>

		<template v-slot:body>
			<ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item" @click="getData('pendiente')">
			    <a class="nav-link active" id="prev-tab" data-toggle="tab" href="#prev" role="tab" aria-controls="prev" aria-selected="true">Pagos Pendientes</a>
			  </li>
			  <li class="nav-item" @click="getData('realizado')">
			    <a class="nav-link" id="post-tab" data-toggle="tab" href="#post" role="tab" aria-controls="post" aria-selected="false">Pagos Realizados</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active" id="prev" role="tabpanel" aria-labelledby="prev-tab">
				<div class="row">
					<div class="col-md-12">
						<br>
						<h5 class="text-center"> Pagos Pendientes</h5>
						<div class="table-responsive">
			                <table class="table table-hover table-bordered">
			                    <thead class="text-center bg-primary text-white">
			                        <tr>
			                            <th>Código</th>
			                            <th>Monto</th>
			                            <th>Cuenta</th>
			                            <th>Trabajador</th>
			                            <th>Estado</th>
			                            <th class="text-light text-capitalize">Acciones</th>
			                        </tr>
			                        </thead>
			                        <tbody>
			                            <tr v-if="payments.length == 0">
			                                <td colspan="6" class="bg-secondary text-center text-light">No se encontraron datos.</td>
			                            </tr>
			                            <tr v-else v-for="(payment, payment_index) in payments_list" :key="payment_index">
			                                <td v-text="payment.code"></td>
			                                <td v-text="payment.amount"></td>
			                                <td v-text="payment.account.name_bank"></td>
			                                <td v-text="payment.employee.name"></td>
			                                <td v-text="payment.status"></td>
			                                <td class="text-center">
			                                    <button
			                                        class="btn btn-icon btn-info" 
			                                        data-toggle="tooltip" title="Ver y Aprobar Cotización">
			                                        Eliminar
			                                    </button>
			                                </td>
			                            </tr>
			                        </tbody>
			                </table>
            			</div>
            			<!-- PAGINACION -->
			            <div v-if="payments.length >= 1" class="container">
			                <div class="row mt-4">
			                    <div class="col-lg-3">
			                        <span>Pagina {{ currentPage }} De {{ totalPage }}</span>
			                    </div>
			                    <div class="col-lg-6 text-center">
			                        <div class="btn-group" role="group" aria-label="Basic example">
			                            <button 
			                                type="button" 
			                                :class="[(currentPage <= 1) ? 'disabled' : '', 'btn btn-outline-primary']"
			                                @click="previousPage">
			                                Anterior   
			                            </button>
			                            <template v-for="np in totalPage">
			                                <button 
			                                    v-show="(currentPage == 1 && np <= 5) || (np >= (currentPage-2) && np <= (currentPage+2)) || (currentPage == 2 && np == 5)"
			                                    type="button" 
			                                    :class="[(currentPage == np) ? 'active' : '', 'btn btn-outline-primary']"
			                                    @click="changePage(np)">
			                                    {{ np }}
			                                </button>
			                            </template>
			                            <button 
			                                type="button" 
			                                :class="[(totalPage <= 1 || currentPage == totalPage) ? 'disabled' : '', 'btn btn-outline-primary']"
			                                @click="nextPage">
			                                Siguiente
			                            </button>
			                        </div>
			                    </div>
			                    <div class="col-lg-3 text-right">
			                        {{payments.length}} Registros Encontrados.
			                    </div>
			                </div>
			            </div>
					</div>
				</div>
			  </div>
			  <div class="tab-pane fade" id="post" role="tabpanel" aria-labelledby="post-tab">
				<div class="row">
					<div class="col-md-12">
						<br>
						<h5 class="text-center"> Pagos Realizados</h5>
						<div class="table-responsive">
			                <table class="table table-hover table-bordered">
			                    <thead class="text-center bg-primary text-white">
			                        <tr>
			                            <th>Código</th>
			                            <th>Monto</th>
			                            <th>Cuenta</th>
			                            <th>Trabajador</th>
			                            <th>Estado</th>
			                            <th class="text-light text-capitalize">Acciones</th>
			                        </tr>
			                        </thead>
			                        <tbody>
			                            <tr v-if="payments.length == 0">
			                                <td colspan="6" class="bg-secondary text-center text-light">No se encontraron datos.</td>
			                            </tr>
			                            <tr v-else v-for="(payment, payment_index) in payments_list" :key="payment_index">
			                                <td v-text="payment.code"></td>
			                                <td v-text="payment.amount"></td>
			                                <td v-text="payment.account.name_bank"></td>
			                                <td v-text="payment.employee.name"></td>
			                                <td v-text="payment.status"></td>
			                                <td class="text-center">
			                                    <button
			                                        class="btn btn-icon btn-info" 
			                                        data-toggle="tooltip" title="Ver y Aprobar Cotización">
			                                        Eliminar
			                                    </button>
			                                </td>
			                            </tr>
			                        </tbody>
			                </table>
            			</div>
            			<!-- PAGINACION -->
			            <div v-if="payments.length >= 1" class="container">
			                <div class="row mt-4">
			                    <div class="col-lg-3">
			                        <span>Pagina {{ currentPage }} De {{ totalPage }}</span>
			                    </div>
			                    <div class="col-lg-6 text-center">
			                        <div class="btn-group" role="group" aria-label="Basic example">
			                            <button 
			                                type="button" 
			                                :class="[(currentPage <= 1) ? 'disabled' : '', 'btn btn-outline-primary']"
			                                @click="previousPage">
			                                Anterior   
			                            </button>
			                            <template v-for="np in totalPage">
			                                <button 
			                                    v-show="(currentPage == 1 && np <= 5) || (np >= (currentPage-2) && np <= (currentPage+2)) || (currentPage == 2 && np == 5)"
			                                    type="button" 
			                                    :class="[(currentPage == np) ? 'active' : '', 'btn btn-outline-primary']"
			                                    @click="changePage(np)">
			                                    {{ np }}
			                                </button>
			                            </template>
			                            <button 
			                                type="button" 
			                                :class="[(totalPage <= 1 || currentPage == totalPage) ? 'disabled' : '', 'btn btn-outline-primary']"
			                                @click="nextPage">
			                                Siguiente
			                            </button>
			                        </div>
			                    </div>
			                    <div class="col-lg-3 text-right">
			                        {{payments.length}} Registros Encontrados.
			                    </div>
			                </div>
			            </div>
					</div>
				</div>
			  </div>
			</div>
		</template>
	</admin-layout>
</template>

<script>
import AdminLayout from "@/layouts/AdminLayout.vue";
import Modal from "@/components/Modal.vue";
import FormPayment from "./FormPayment";
import mutatorMixin from "@/mixins/mutator.js";

export default {
	name: "PaymentPage",

	mixins: [mutatorMixin],

	created(){
		this.getData('pendiente')
	},

	data() {
		return {
			payments:[],

			/* Datatable */
            search: '',
            select_payments: [],
            m_selected: false,
            pageSize: 10,   // Cantidad de registros por vista
            currentPage: 1, // Pagina Actual
            totalPage: 0,   // Cantidad de Paginas totales
            showUpto: 10,   // Cantidad de Reg que se van a mostrar a la der
            showFromto: 0,  // Cantidad de Reg que se van a mostrar a la izq
            sortedData: [],

			title: "",
			accion: "",
			fecthUrl: "/payments/",
		};
	},

	components: {
		AdminLayout,
		Modal,
		FormPayment
	},

	methods: {
		getData(status=null){
			axios.get(this.fecthUrl+status)
			.then(response => {
                this.payments = response.data.data
            }).catch(errors => {
            })
		},
        previousPage(){
            if (this.currentPage != 1){
                this.showFromto = ((this.currentPage - 2) * this.pageSize)
                this.currentPage =  this.currentPage - 1
                this.showUpto = (this.currentPage * this.pageSize)
            }
        },
        nextPage(){
            if (this.currentPage != this.totalPage){
                this.showFromto = (this.currentPage * this.pageSize) ;
                this.currentPage =  this.currentPage + 1;
                this.showUpto = (this.currentPage * this.pageSize);
            }
        },
        changePage(n_page){
            this.currentPage = n_page
            this.showFromto = (n_page -1) * this.pageSize
            this.showUpto = parseInt(this.showFromto) + parseInt(this.pageSize)
        }
	},
	computed:{
		payments_list(){
            this.totalPage = Math.ceil(this.payments.length / this.pageSize);
            let search = this.search.toLowerCase()
            this.sortedData = this.payments.filter((payment) => {
                return payment.code.toLowerCase().indexOf(search) !== -1
            }).slice(this.showFromto, this.showUpto)
            return this.sortedData
        }
	}
};
</script>

<style lang="css" scoped></style>
