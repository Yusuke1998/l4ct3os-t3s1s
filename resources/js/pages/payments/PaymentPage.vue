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
								<a class="dropdown-item" @click="pdf('day')" href="#">Dia</a>
								<a class="dropdown-item" @click="pdf('week')" href="#">Semana</a>
								<a class="dropdown-item" @click="pdf('month')" href="#">Mes</a>
								<a class="dropdown-item" @click="pdf('year')" href="#">Año</a>
								<a class="dropdown-item" @click="pdf('')" href="#">Todo</a>
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
								show="method" 
								label="Metodo de Pago"
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
								show="employee.identificacion_number" 
								label="Cedula"
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
		this.dateToday();
	},

	data() {
		return {
			title: "",
			accion: "",
			fecthUrl: "/payments/",
			fecthTableUrl: "/payments/",
			active: true,
			today: ''
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
		dateToday(){
			let date = new Date().toISOString().slice(0,10)
			this.today = date.split('-')[2]+'-'+date.split('-')[1]+'-'+date.split('-')[0]
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
		// Generando tabla y pdf
		cantWidths(columns) {
			let widths = [];
			columns.forEach(() => {
				widths.push('auto')
			});
			return widths;
		},
		buildTableBody(data, columns) {
		    var body = [];
		    body.push(columns);
		    data.forEach(function(row) {
		        var dataRow = [];
		        columns.forEach(function(column) {
		            dataRow.push(row[column].toString());
		        })
		        body.push(dataRow);
		    });
		    return body;
		},
		table(data, columns) {
		    return {
		        table: {
		        	widths: this.cantWidths(columns),
		            headerRows: 1,
		            body: this.buildTableBody(data, columns)
		        }
		    };
		},
		print(data, item) {
			var dPaDtFa = {
			    content: [
		    		{
						text: this.today,
						width: '*',
						alignment: 'right',
						style: 'small'
					},
			    	{
						text: 'Hatos Lecheros',
						width: '*',
						alignment: 'center',
						style: 'header'
					},
			        { 
						width: '*',
						alignment: 'left',
						style: 'subheader',
			        	text: 'Registro de todos los pagos '+item
			        },
			        this.table(data, ['codigo','fecha','monto','estado','metodo','trabajador','cedula'])
			    ],
			    styles: {
					header: {
						fontSize: 18,
						bold: true,
						margin: [0, 0, 0, 10]
					},
					subheader: {
						fontSize: 14,
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
					},
					small:{
						fontSize: 8,
					}
				}
			}
			pdfMake.createPdf(dPaDtFa).open();
		},
		trad(item){
			let ite=''
			switch(item) {
			  case 'day':
			    ite = 'del dia'
			    break;
			  case 'week':
			    ite = 'de la semana'
			    break;
			  case 'month':
			    ite = 'del mes'
			    break;
			  case 'year':
			    ite = 'del año'
			    break;
			}
			return ite;
		},
		pdf(item)
		{
			pdfMake.vfs = pdfFonts.pdfMake.vfs;
			axios.get('/payments/pdf/'+item)
			.then(response => {
				this.print(response.data.data,this.trad(item));
			});
		}
		// Generando tabla y pdf
	}
}
</script>

<style lang="css" scoped></style>
