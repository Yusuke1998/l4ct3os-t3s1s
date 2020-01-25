<template>
	<form>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1"
					>Trabajador</span
				>
			</div>
			<p v-if="employees.length === 0"
				class="form-control"
				aria-describedby="basic-addon4">
				<b>No hay trabajadores registrados</b>
			</p>
			<select
				v-else
				class="form-control"
				id="exampleFormControlSelect1"
				aria-describedby="basic-addon4"
				placeholder="Seleccionar"
				v-model="form.employee_id"
				@change="getAccounts"
				required>
				<option value="0" selected> Seleccionar</option>
				<option 
					v-for="employee in employees"
					:key="employee.id" 
					:value="employee.id">{{ employee.name }} {{ employee.position }}</option>
			</select>
		</div>
		<template v-show="form.employee_id>0 && form.employee_id!==''">
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1"
						>Cuenta</span
					>
				</div>
				<p v-if="accounts.length==0"
					class="form-control"
					aria-describedby="basic-addon4">
					<b>No tiene cuenta registrada</b>
				</p>
				<select v-else
					:disabled="accounts.length==0"
					class="form-control"
					id="exampleFormControlSelect2"
					aria-describedby="basic-addon4"
					placeholder="Seleccionar"
					v-model="form.account_id"
					required>
					<option value="0" selected> Seleccionar</option>
					<option 
						v-for="account in accounts" 
						:key="account.id" 
						:value="account.id">{{ account.name_bank }} {{ account.number }}</option>
				</select>

				<button 
					type="button" 
					class="btn btn-primary" 
					@click="modalMy('modalAccounts',1)">
					<font-awesome-icon prefix="fa" icon="university"/> Crear
				</button>

				<!-- Modal -->
				<div class="modal fade"
					id="modalAccounts"
					tabindex="-1"
					aria-hidden="true">
					<div class="modal-dialog" role="document">
						<form-account :employee="form.employee_id"></form-account>
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon1">Monto</span>
				</div>
				<input
					type="number"
					:disabled="form.account_id==0||form.account_id==''"
					class="form-control"
					placeholder="Monto a pagar"
					aria-label="Monto"
					aria-describedby="basic-addon1"
					v-model="form.amount"
					required
				/>
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon2">Descripcion</span>
				</div>
				<textarea 
					:disabled="form.amount==''"
					class="form-control"
					aria-label="Descripcion"
					aria-describedby="basic-addon2"
					v-model="form.description"></textarea>
			</div>
		</template>
	</form>
</template>

<script>
import crudMixin from "@/mixins/crud.js";
import mutatorMixin from "@/mixins/mutator.js";
import FormAccount from "./FormAccount";
import Modal from "@/components/Modal.vue";

export default {
	name: "FormPayment",

	mixins: [crudMixin,mutatorMixin],

	data() {
		return {
			title: "",
			accion: "",

			form: {
				id: "",
				amount: "",
				description: "",
				account_id: 0,
				employee_id: 0,
			},

			account:null,
			employee:null,
			employees: [],
			accounts: [],

			id: 'payments',
			deleteUrl: "/payment/delete",
			updateUrl: "/payment/update",
			createUrl: "/payment/register",
			fecthEmployeesUrl: `/employees`,
			fecthAccountsUrl: `/accounts/`,
		};
	},

	created() {
		this.fetchEmployees(this.fecthEmployeesUrl);
		
		this.$bus.$on('createdAccount',(bank)=>{
			if(bank){
				this.getAccounts()
			}
		})

		this.$bus.$on('data',(data)=>{
			this.getAccounts(data.data.employee_id)
		})

		this.$bus.$on('clear',(data)=>{
			this.accounts=[]
		})
	},

	methods: {

		fetchEmployees(url) {
			axios.get(url).then(response => {
				this.employees = response.data.data;
			});
		},

		getAccounts(id=0) {
			if (id>0) {
				this.fetchAccounts(id)
			}else{
				this.fetchAccounts(this.form.employee_id)
			}
		},

		fetchAccounts(id) {
			let url = this.fecthAccountsUrl+id;
			axios.get(url).then(response => {
				this.accounts = response.data.data;
			});
		},

		modalMy(id="modal",bool)
		{
			if (bool) {
				$("#"+id).modal('show')
			}else{
				$("#"+id).modal('hide')
			}
		}
	},

	components: {
		Modal,
		FormAccount
	},
};
</script>

<style lang="css" scoped></style>
