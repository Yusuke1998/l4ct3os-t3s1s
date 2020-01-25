<template>
	<div class="card">
		<div v-if="employee!==null" class="card-header">
			<h3 class="text-center" v-text="employee.name"></h3>
		</div>
		<div v-else class="card-header">
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<input 
					class="form-control" 
					type="text" 
					name="search" 
					placeholder="Buscar">
				</div>
			</div>
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
							v-model="employee.position">
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
								show="date" 
								label="Fecha"
							></table-column>
							<table-column 
								show="amount" 
								label="Monto"
							></table-column>
							<table-column 
								show="employee.name" 
								label="Empleado"
							></table-column>
							<table-column 
								show="account.name_bank" 
								label="Banco"
							></table-column>
							<table-column 
								show="account.number" 
								label="Nro. Cuenta"
							></table-column>
							<table-column
								show="status"
								label="Estado"
								:filterable="false"
								:sortable="false"
							></table-column>
						</table-component>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Modal from "@/components/Modal.vue";

export default {
	name: "SearchPayment",

	data() {
		return {
			title: "",
			accion: "",
			payments:[],
			employee:null,
			fecthTableUrl: "/payments/",
		};
	},

	created() {
		this.$bus.$on('dataSearch',data=>{
			this.employee = data.employee
			this.$refs.table.refresh();
		});
	},

	methods: {		
		async dataPayments({page,filter,sort}) {
            const response = await axios.post('payment/employee/'+this.employee.id, {page,filter,sort});
            return response.data;
        }
	},

	components: {
		Modal
	},
};
</script>

<style lang="css" scoped></style>
