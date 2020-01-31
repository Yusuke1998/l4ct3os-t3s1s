<template>
	<!-- Modal -->
	<div
		:id="idTarget"
		class="modal fade"
		tabindex="-1"
		aria-hidden="true"
	>
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">
						{{ title }}
					</h5>
					<button
						type="button"
						class="close"
						data-dismiss="modal"
						aria-label="Close"
					>
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row" v-if="payment!==null">
						<!-- col-12 -->
						<div class="form-group col-4">
							<label>Codigo</label>
							<input 
								disabled 
								class="form-control" 
								type="text" 
								v-model="payment.code">
						</div>
						<div class="form-group col-4">
							<label>Fecha</label>
							<input 
								disabled 
								class="form-control" 
								type="text" 
								v-model="payment.date">
						</div>
						<div class="form-group col-4">
							<label>Monto (Bs)</label>
							<input 
								disabled 
								class="form-control" 
								type="text" 
								v-model="payment.amount">
						</div>
						<!-- col-12 -->
						<template v-if="payment.method==='transferencia'">
							<div class="form-group col-6">
								<label>Banco</label>
								<input 
									disabled 
									class="form-control" 
									type="text" 
									v-model="payment.account.name_bank">
							</div>
							<div class="form-group col-6">
								<label>Nro. de Cuenta</label>
								<input 
									disabled 
									class="form-control" 
									type="text" 
									v-model="payment.account.number">
							</div>
							
						</template>
						<!-- col-12 -->
						<div class="form-group col-6">
							<label>Metodo de Pago</label>
							<input 
								disabled 
								class="form-control" 
								type="text" 
								v-model="payment.method">
						</div>
						<div class="form-group col-6">
							<label>Estado</label>
							<input 
								disabled 
								class="form-control" 
								type="text" 
								v-model="payment.status">
						</div>
						<!-- col-12 -->
						<div class="form-group col-12">
							<label>Descripción</label>
							<textarea
								disabled 
								class="form-control" 
								type="text" 
								v-model="payment.description"></textarea>
						</div>
						<!-- col-12 -->
					</div>
				</div>
				<div class="modal-footer">
					<button
						type="button"
						class="btn btn-secondary"
						data-dismiss="modal"
					>
						Cerrar
					</button>
					<button type="button" @click="pdf()" class="btn btn-warning"> Imprimir
					</button>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";

export default {
	name: "ModalPayment",

	data(){
		return {
			payment:null,
			today:''
		}
	},

	created(){
		this.$bus.$on('paymentPdf',(payment)=>{
			this.payment = payment;
		});
		this.dateToday();
	},

	props: {

		title: {
			type: String,	
			required: true
		},

		idTarget: {

			type: String,
			required: true
		},

	},

	methods:{
		dateToday(){
			let date = new Date().toISOString().slice(0,10)
			this.today = date.split('-')[2]+'-'+date.split('-')[1]+'-'+date.split('-')[0]
		},
		pdf(){
			pdfMake.vfs = pdfFonts.pdfMake.vfs;
			if (this.payment!==null) {
				if (this.payment.method == 'transferencia') {
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
					        	text: 'Datos de trabajador',
					        	style: 'subheader'
					        },
					        {
					        	table: {
						        	widths: [200, '*'],
						            body: [
										[
											'Cedula', 'Nombre y Apellido'
										],
										[
											{
												text:this.payment.employee.identificacion_number,
												italics: true, 
												color: 'gray'
											},
											{
												text:this.payment.employee.name,
												italics: true, 
												color: 'gray'
											}
										]
									]
								},
					        },
					        {
					        	width: '*',
								alignment: 'left',
					        	text: 'Datos de Pago',
					        	style: 'subheader'
					        },
					        {
					        	table: {
						        	widths: [100, 100, 100, '*'],
						            headerRows: 1,
						            body: [
										[
											'Codigo', 'Fecha', 'Metodo de Pago', 'Monto'
										],
										[
											{
												text: this.payment.code, 
												italics: true, 
												color: 'gray'
											},
											{
												text: 
												this.payment.date.split('-')[2]+'-'
												+this.payment.date.split('-')[1]+'-'
												+this.payment.date.split('-')[0], 
												italics: true, 
												color: 'gray'
											},
											{
												text: this.payment.method, 
												italics: true, 
												color: 'gray'
											},
											{
												text: this.payment.amount+' Bs', 
												italics: true, 
												color: 'gray'
											}
										]
									]
						        }
					        },
					        {
					        	table: {
						        	widths: [200, '*'],
						            body: [
										[
											'Banco','Nro. de Cuenta'
										],
										[
											{
												text: this.payment.account.name_bank, 
												italics: true, 
												color: 'gray'
											},
											{
												text: this.payment.account.number, 
												italics: true, 
												color: 'gray'
											}
										]
									]
								},
					        },
					        {
								table: {
						        	widths: ['*'],
						            headerRows: 1,
						            body: [
										[
											'Descripción'
										],
										[
											{
												text: this.payment.description, 
												italics: true, 
												color: 'gray'
											}
										]
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

				}else{
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
				        	text: 'Datos de trabajador',
				        	style: 'subheader'
				        },
				        {
				        	table: {
					        	widths: [200, '*'],
					            body: [
									[
										'Cedula', 'Nombre y Apellido'
									],
									[
										{
											text:this.payment.employee.identificacion_number,
											italics: true, 
											color: 'gray'
										},
										{
											text:this.payment.employee.name,
											italics: true, 
											color: 'gray'
										}
									]
								]
							},
				        },
				        {
				        	width: '*',
							alignment: 'left',
				        	text: 'Datos de Pago',
				        	style: 'subheader'
				        },
				        {
				        	table: {
					        	widths: [100, 100, 100, '*'],
					            headerRows: 1,
					            body: [
									[
										'Codigo', 'Fecha', 'Metodo de Pago', 'Monto'
									],
									[
										{
											text: this.payment.code, 
											italics: true, 
											color: 'gray'
										},
										{
											text: 
											this.payment.date.split('-')[2]+'-'
											+this.payment.date.split('-')[1]+'-'
											+this.payment.date.split('-')[0], 
											italics: true, 
											color: 'gray'
										},
										{
											text: this.payment.method, 
											italics: true, 
											color: 'gray'
										},
										{
											text: this.payment.amount+' Bs', 
											italics: true, 
											color: 'gray'
										}
									]
								]
					        }
				        },
				        {
							table: {
					        	widths: ['*'],
					            headerRows: 1,
					            body: [
									[
										'Descripción'
									],
									[
										{
											text: this.payment.description, 
											italics: true, 
											color: 'gray'
										}
									]
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
				}
				pdfMake.createPdf(dPaDtFa).open();
			}
		},
	}
};
</script>

<style lang="css" scoped></style>
