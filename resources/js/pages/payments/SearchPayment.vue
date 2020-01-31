<template>
	<div class="card">
		<div class="card-header">
			<button 
				@click="searchShow=!searchShow"
				class="btn btn-info btn-sm">
				<font-awesome-icon icon="search"/>
			</button>
		</div>
		<div v-show="searchShow" class="card-header">
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<form class="form-group" @submit.prevent>
	                    <div class="input-group">
							<input 
							minlength="7"
							maxlength="8" 
							@keyup.enter="searchEmployee"
							class="form-control" 
							type="number" 
							v-model="search" 
							placeholder="Buscar trabajador por nro de cedula">
	                        <div class="input-group-prepend">
	                            <button @click.prevent="searchEmployee" type="button" class="btn btn-primary">
	                                <i class="fa fa-search mr-1"></i> Buscar
	                            </button>
	                        </div>
	                    </div>
	            	</form>
				</div>
			</div>
		</div>
		<div v-if="employee!==null" class="card-header">
			<h3 class="text-center" v-text="employee.name"></h3>
		</div>
		<div v-if="employee!==null" class="body">
			<div class="container">
				<div class="row mt-3">
					<div class="form-group col-4">
						<label>Cedula</label>
						<input 
							disabled 
							class="form-control" 
							type="text" 
							v-model="employee.identificacion_number">
					</div>
					<div class="form-group col-4">
						<label>Cargo</label>
						<input 
							disabled 
							class="form-control" 
							type="text" 
							v-model="cargo">
					</div>
					<div class="form-group col-4">
						<label>F. Nacimiento</label>
						<input 
							disabled 
							class="form-control" 
							type="text" 
							v-model="employee.date_birth">
					</div>
					<!-- tabla de pagos -->

					<div class="col-12">
						<h5 class="text-center">Pagos</h5>
						<table-component
							:data="dataPayments"
							sort-by="date"
							sort-order="desc"
							:show-filter="false"
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
										data-toggle="modal"
										data-target="#payment"
										class="btn btn-info"
										@click="showPayment(row)"
									>
										<font-awesome-icon icon="eye"/>
									</button>
								</template>
							</table-column>
						</table-component>
					</div>
				</div>
			</div>
		</div>
		<modal-payment title="Pago" idTarget="payment">
			<h4>hola vale</h4>
		</modal-payment>
	</div>
</template>

<script>
import Modal from "@/components/Modal.vue";
import ModalPayment from "./ModalPayment.vue";

export default {
	name: "SearchPayment",

	data() {
		return {
			searchShow: false,
			title: "",
			accion: "",
			payments:[],
			employee:null,
			search:'',
			fecthTableUrl: "/payments/",
			cargo:''
		};
	},

	created() {
		this.$bus.$on('dataSearch',data=>{
			this.employee = data.employee
			this.trad(this.employee.position)
			if (this.$refs.table!==null && this.$refs.table!==undefined){
				this.$refs.table.refresh();
			}
		});
	},

	methods: {	
		searchEmployee() {
			if (this.search=='') {
				this.$alertify.warning('Debes ingresar la cedula!')
			}else if(this.search.length<7 || this.search.length>9){
				this.$alertify.warning('Este numero no es valido!')
			}else{
				let url = 'employee/ci/'+this.search
				axios.get(url)
				.then(response => {
					if (response.data.data !== null) {
						this.employee = response.data.data
						this.trad(this.employee.position)
						if (this.$refs.table!==null && this.$refs.table!==undefined) {
							this.$refs.table.refresh();
						}
						this.$alertify.success('Trabajador encontrado exitosamente!')
					}else{
						this.employee = null
						if (this.$refs.table!==null && this.$refs.table!==undefined) {
							this.$refs.table.refresh();
						}
						this.$alertify.error('Trabajador no encontrado!')
					}
				});
			}
		},	
		async dataPayments({page,filter,sort}) {
            const response = await axios.post('payment/employee/'+this.employee.id, {page,filter,sort});
            return response.data;
        },
        showPayment(payment){
        	this.$bus.$emit('paymentPdf',payment);
        },
        FormDate(value, rowProperties){
			return value.split('-')[2]
					+'/'+value.split('-')[1]
					+'/'+value.split('-')[0]
		},
		FormAmount(value, rowProperties){
			return value+' Bs';
		},
		trad(data){
			switch (data) {
			case 'worker':
				this.cargo = 'Obrero';
				break;
			case 'extraccion':
				this.cargo = 'Extraccion';
				break;
			case 'vaccination':
				this.cargo = 'Vacunacion';
				break;
			case 'supplies':
				this.cargo = 'Insumos';
				break;
			}
		}
	},

	components: {
		Modal,
		ModalPayment
	},
};
</script>

<style lang="css" scoped></style>
