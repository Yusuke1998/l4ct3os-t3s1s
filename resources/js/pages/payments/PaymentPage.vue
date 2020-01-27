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
			<!-- <div class="dropdown float-rigth">
				<button
					type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
					<font-awesome-icon icon="file"/>PDF
				</button>
			  <div class="dropdown-menu">
			    <a class="dropdown-item" @click="pdf('payment/day')" href="#">Dia</a>
			    <a class="dropdown-item" @click="pdf('payment/week')" href="#">Semana</a>
			    <a class="dropdown-item" @click="pdf('payment/month')" href="#">Mes</a>
			    <a class="dropdown-item" @click="pdf('payment/year')" href="#">Año</a>
			  </div>
			</div> -->
			<!-- Modals -->
			<modal :title="title" idTarget="payments" :accion="accion">
				<form-payment></form-payment>
			</modal>
		</template>

		<template v-slot:body>
			<ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item" @click="active=true">
			    <a :class="active?'active':''" class="nav-link" id="prev-tab" data-toggle="tab" href="#prev" role="tab" aria-controls="prev" aria-selected="true">Todos los Pagos</a>
			  </li>
			  <li class="nav-item" @click="active=false">
			    <a :class="!active?'active':''" class="nav-link" id="post-tab" data-toggle="tab" href="#post" role="tab" aria-controls="post" aria-selected="false">Pagos Hechos</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  <div :class="active?'show active':''" class="tab-pane fade" id="prev" role="tabpanel" aria-labelledby="prev-tab">
				<div class="row">
					<div class="col-12">
						<div class="dropdown">
							<button
								type="button" class="float-right btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
								<font-awesome-icon icon="file"/>  PDF
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" @click="pdf('payment/day')" href="#">Dia</a>
								<a class="dropdown-item" @click="pdf('payment/week')" href="#">Semana</a>
								<a class="dropdown-item" @click="pdf('payment/month')" href="#">Mes</a>
								<a class="dropdown-item" @click="pdf('payment/year')" href="#">Año</a>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-10">
						<table-component
							:data="fetchDataTable"
							sort-by="status"
							sort-order="desc"
							ref="table"
							:cache-lifetime="false"
						>
							<table-column
								show="code"
								label="Codigo"
							></table-column>
							<table-column 
								:formatter="FormDate"
								show="date" 
								label="Fecha"
							></table-column>
							<table-column 
								:formatter="FormAmount"
								show="amount" 
								label="Monto"
							></table-column>
							<table-column 
								:sortable="false"
								:filterable="false"
								show="employee.name" 
								label="Empleado"
							></table-column>
							<table-column 
								:sortable="false"
								:filterable="false"
								show="account.name_bank" 
								label="Banco"
							></table-column>
							<table-column 
								:sortable="false"
								:filterable="false"
								show="account.number" 
								label="Nro. Cuenta"
							></table-column>
							<table-column
								show="status"
								label="Estado"
								:filterable="false"
								:sortable="false"
							></table-column>
							<table-column
								label="Accion"
								:sortable="false"
								:filterable="false"
							>
								<template slot-scope="row">
									<button
										class="btn btn-info"
										@click="searchPay(row)"
									>
										Historial
									</button>
									<button
										class="btn btn-warning"
										data-toggle="modal"
										data-target="#payments"
										@click="
											setTitle('Editar Pago'),
												setAccion('edit'),
												setData(row)
										"
									>
										Editar
									</button>
									<button
										class="btn btn-danger"
										@click="setData(row, true)"
									>
										Eliminar
									</button>
									<button
										v-if="row.status!=='realizado'"
										class="btn btn-success"
										@click="setStatus(row)"
									>
										Realizar
									</button>
								</template>
							</table-column>
						</table-component>
					</div>
				</div>
			  </div>
			  <div :class="!active?'show active':''" class="tab-pane fade" id="post" role="tabpanel" aria-labelledby="post-tab">
				<div class="row">
					<div class="col-lg-12 col-md-10">
						<search-payment></search-payment>
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
import SearchPayment from "./SearchPayment";
import mutatorMixin from "@/mixins/mutator.js";
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";

export default {
	name: "PaymentPage",

	mixins: [mutatorMixin],

	created(){
	},

	data() {
		return {
			title: "",
			accion: "",
			fecthUrl: "/payments/",
			fecthTableUrl: "/payments/",
			active: true,
			dPayment: [],
			arrData: []
		};
	},

	components: {
		AdminLayout,
		Modal,
		FormPayment,
		SearchPayment
	},

	methods: {
		searchPay(data){
			this.$bus.$emit('dataSearch',data)
			this.active=false;
		},
		FormDate(value, rowProperties){
			return value.split('-')[2]
					+'/'+value.split('-')[1]
					+'/'+value.split('-')[0]
		},
		FormAmount(value, rowProperties){
			return value+' Bs';
		},
		setStatus(data){
			let endpoint = 'payment/status/'+data.id;
			swal({
				title: "Seguro de realizar pago?",
				text: "una vez aceptado, cambiara el estado!",
				icon: "warning",
				buttons: true,
				dangerMode: true
			}).then(willState => {
				if (willState) {
					axios.put(endpoint, data)
						.then(() => {
							swal("El estado ha sido modificado!", {
								icon: "success"
							});
							utils.reload();
						})
						.catch(error => {
							swal("El pago no pudo ser modificado!", {
								icon: "error"
							});
						});
				} else {
					return;
				}
			});
		},
		pdf(item)
		{
			pdfMake.vfs = pdfFonts.pdfMake.vfs;

			let model = item.split('/')[0];
			let time = item.split('/')[1];

			axios.post('/reports/pdf/'+model)
			.then(response => {
				this.dPayment = response.data.data
			});

			switch (time) {
				case 'day':
					if(this.dPayment.day!=undefined){
						this.arrData = this.dPayment.day.forEach(element => {
							console.log(Object.keys(element));
							console.log(Object.values(element));
						});
					}
					break;
				case 'week':
					console.log(this.dPayment.week);
					break;
				case 'month':
					console.log(this.dPayment.month);
					break;
				case 'year':
					console.log(this.dPayment.year);
					break;
			}

			var docDefinition = {
				content: [
					{ text: 'Tables', style: 'header' },
					'Official documentation is in progress, this document is just a glimpse of what is possible with pdfmake and its layout engine.',
					{ text: 'A simple table (no headers, no width specified, no spans, no styling)', style: 'subheader' },
					'The following table has nothing more than a body array',
					{
						style: 'tableExample',
						table: {
							widths: [100, '*', 200, '*'],
							body: [
								['Column 1', 'Column 2', 'Column 3'],
								['One value goes here', 'Another one here', 'OK?']
							]
						}
					}
				],
				styles: {
					header: {
						fontSize: 18,
						bold: true,
						margin: [0, 0, 0, 10]
					},
					subheader: {
						fontSize: 16,
						bold: true,
						margin: [0, 10, 0, 5]
					},
					tableExample: {
						margin: [0, 5, 0, 15]
					},
					tableHeader: {
						bold: true,
						fontSize: 13,
						color: 'black'
					}
				},
				defaultStyle: {
					// alignment: 'justify'
				}
			};
			pdfMake.createPdf(docDefinition).open();
		}
	}
}
</script>

<style lang="css" scoped></style>
