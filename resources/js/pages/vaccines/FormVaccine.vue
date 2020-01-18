<template>
	<form>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1"
					>Nombre de la vacuna</span
				>
			</div>
			<p v-if="medicines.length === 0"
				class="form-control"
				aria-describedby="basic-addon4">
				<b>No hay vacuna disponibles</b>
			</p>

			<select v-else
				class="form-control"
				id="exampleFormControlSelect1"
				aria-describedby="basic-addon4"
				placeholder="Seleccionar"
				v-model="form.medicine_id"
				required
			>
				<option selected>Seleccionar</option>
				<option 
					v-for="medicine in medicines" 
					:key="medicine.id" 
					:value="medicine.id">{{ medicine.name_medicine }}</option>
			</select>
		</div>

		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">mg</span>
			</div>
			<input
				type="text"
				class="form-control"
				placeholder="Cantidad aplicada"
				aria-label="Nombre"
				aria-describedby="basic-addon1"
				v-model="form.quantity"
				required
			/>
		</div>

		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon3"
					>Fecha de aplicación</span
				>
			</div>
			<input
				type="date"
				class="form-control"
				placeholder="Fecha de aplicación"
				aria-label="Fecha de aplicación"
				aria-describedby="basic-addon3"
				v-model="form.date"
				required
			/>
		</div>
		
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon4"
					>Vacunador</span
				>
			</div>

			<p v-if="employees.length === 0"
				class="form-control"
				aria-describedby="basic-addon4">
				<b>No hay vacunadores disponibles</b>
			</p>

			<select v-else
				class="form-control"
				id="exampleFormControlSelect1"
				aria-describedby="basic-addon4"
				placeholder="Seleccionar"
				v-model="form.employee_id"
				required
			>
				<option selected>Seleccionar</option>
				<option 
					v-for="employee in employees" 
					:key="employee.id" 
					:value="employee.id">{{ employee.name }}</option>
			</select>
		</div>
	</form>
</template>

<script>
import crudMixin from "@/mixins/crud.js";

export default {
	name: "FormVaccine",

	mixins: [crudMixin],

	data() {
		return {
			form: {
				id: "",
				employee_id: "",
				cow_id: "",
				medicine_id: "",
				date: "",
				quantity: ""
			},

			employees: [],
			medicines: [],

			deleteUrl: "/vaccine/delete",
			updateUrl: "/vaccine/update",
			createUrl: "/vaccine/register",
			id: "vaccines",
			fecthEmployeesUrl: `/employees/vaccination`,
			fecthMedicinesUrl: `/medicines`
		};
	},

	created() {
		this.$bus.$on("cow_id", ({ id }) => {
			this.form.cow_id = id;
		});

		this.fetchEmployees(this.fecthEmployeesUrl);
		this.fetchMedicines(this.fecthMedicinesUrl);
	},

	methods: {
		fetchEmployees(url) {
			axios.get(url).then(response => {
				this.employees = response.data.data;
			});
		},
		fetchMedicines(url) {
			axios.get(url).then(response => {
				this.medicines = response.data.data;
			});
		}
	},

};
</script>

<style lang="css" scoped></style>
