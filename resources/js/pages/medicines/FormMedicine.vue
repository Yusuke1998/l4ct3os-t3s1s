<template>
	<form>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1"
					>Nombre de la medicina</span
				>
			</div>
			<input
				type="text"
				class="form-control"
				placeholder="Nombre"
				aria-label="Nombre"
				aria-describedby="basic-addon1"
				v-model="form.name_medicine"
				required
			/>
		</div>

		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon3"
					>Fecha de vencimiento</span
				>
			</div>
			<input
				type="date"
				class="form-control"
				placeholder="Fecha de vencimiento"
				aria-label="Fecha de vencimiento"
				aria-describedby="basic-addon3"
				v-model="form.date"
				required
			/>
		</div>
	</form>
</template>

<script>
import crudMixin from "@/mixins/crud.js";

export default {
	name: "FormMedicine",

	mixins: [crudMixin],

	data() {
		return {
			form: {
				id: "",
				name_medicine: "",
				date: ""
			},

			employees: [],

			deleteUrl: "/medicine/delete",
			updateUrl: "/medicine/update",
			createUrl: "/medicine/register",
			id: "medicines",
		};
	},

	methods: {

	},

};
</script>

<style lang="css" scoped></style>
