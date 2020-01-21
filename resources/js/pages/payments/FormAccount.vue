<template>
	<form>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">Banco</span>
			</div>
			<input
				type="text"
				class="form-control"
				placeholder="Nombre del Banco"
				aria-label="Banco"
				aria-describedby="basic-addon1"
				required/>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">Numero</span>
			</div>
			<input
				type="number"
				class="form-control"
				placeholder="Numero de Cuenta"
				aria-label="Numero"
				aria-describedby="basic-addon1"
				required/>
		</div>
	</form>
</template>

<script>

export default {
	name: "FormAccount",

	data() {
		return {
			account: {
				id: 0,
				name_bank:'',
				number:'',
				employee_id:0
			},
		};
	},

	created() {
	},

	methods: {
	}
};
</script>

<style lang="css" scoped></style>
