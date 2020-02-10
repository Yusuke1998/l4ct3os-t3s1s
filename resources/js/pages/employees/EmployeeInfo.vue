<template>
	<div class="container">
		<div class="card" v-if="employee!==null">
			<div class="card-header">
				{{employee.name}} - {{employee.cargo}}
			</div>
			<div class="card-body">
				<template v-if="extractions.length>0">
					Cantidad de Extracciones realizadas: {{extractions.length}}
				</template>
				<template v-if="vaccines.length>0">
					Cantidad de Vacunas aplicadas: {{vaccines.length}}
				</template>
			</div>
		</div>
	</div>
</template>

<script>

export default {
	name: "EmployeeInfo",

	data() {
		return {
			employee:null,
			extractions:[],
			vaccines:[]
		};
	},

	created() {
		this.$bus.$on("employee", ({ employee }) => {
			this.employee = employee;
			this.extractions = employee.extractions;
			this.vaccines = employee.vaccines;
		});
	},

	methods: {

	}
};
</script>

<style lang="css" scoped></style>
