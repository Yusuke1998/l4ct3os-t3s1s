<template>
	<form>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon4"
					>Ordeñador</span
				>
			</div>

			<p
				v-if="employees.length==0"
				class="form-control"
				aria-describedby="basic-addon4"
			>
				<b>No hay ordeñadores disponibles</b>
			</p>

			<select
				v-else
				class="form-control"
				id="exampleFormControlSelect1"
				aria-describedby="basic-addon4"
				placeholder="Seleccionar"
				v-model="form.employee_id"
				required
			>
				<option value="" selected="">Seleccionar</option>
				<option 
					v-for="employee in employees"
					:key="employee.id" 
					:value="employee.id">{{ employee.name }}</option>
			</select>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon4">Res</span>
			</div>
			<p v-if="cows.length==0"
				class="form-control"
				aria-describedby="basic-addon4">
				<b>No hay reses para ordeñar disponibles</b>
			</p>
			<select
				v-else
				class="form-control"
				id="exampleFormControlSelect1"
				aria-describedby="basic-addon4"
				placeholder="Seleccionar"
				v-model="form.cow_id"
				required>
				<option value="" selected="">Seleccionar</option>
				<option 
					v-for="cow in cows"
					:key="cow.id" 
					:value="cow.id">{{ cow.code }} - {{ cow.weight }} Kg</option
				>
			</select>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">lts</span>
			</div>
			<input
				type="text"
				class="form-control"
				placeholder="Cantidad de leche ordeñada"
				aria-label="Leche"
				aria-describedby="basic-addon1"
				v-model="form.quantity"
				required
			/>
		</div>

		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon2">Fecha</span>
			</div>

			<input
				type="date"
				class="form-control"
				placeholder="Fecha de ordeño"
				aria-label="Fecha de ordeño"
				aria-describedby="basic-addon2"
				v-model="form.date"
				required
			/>
		</div>
	</form>
</template>

<script>
import crudMixin from "@/mixins/crud.js";

export default {
	name: "FormExtraction",

	mixins: [crudMixin],

	data() {
		return {
			form: {
				id: "",
				employee_id: "",
				cow_id: "",
				quantity: "",
				date: ""
			},

			cows: [],
			employees: [],

			id: "extractions",
			deleteUrl: "/extraction/delete",
			updateUrl: "/extraction/update",
			createUrl: "/extraction/register",
			fecthEmployeesUrl: `/employees/extraccion`,
			fecthCowsUrl: `/cows/${true}`
		};
	},

	created() {
		this.fetchEmployees(this.fecthEmployeesUrl);
		this.fetchCows(this.fecthCowsUrl);
	},

	methods: {
		fetchEmployees(url) {
			axios.get(url).then(response => {
				this.employees = response.data.data;
			});
		},

		fetchCows(url) {
			axios.get(url).then(response => {
				this.cows = response.data.data;
			});
		}
	}
};
</script>

<style lang="css" scoped></style>
