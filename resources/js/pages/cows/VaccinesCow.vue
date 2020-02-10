<template>
	<div class="container">
		<table v-if="cowEx !== undefined" class="table table-bordered table-hover">
            <thead class="text-center bg-info">
                <tr>
                    <th class="text-light text-capitalize">Trabajador</th>
                    <th class="text-light text-capitalize">Medicina</th>
                    <th class="text-light text-capitalize">Cantidad</th>
                    <th class="text-light text-capitalize">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="vaccines.length === 0">
                    <td colspan="4" class="bg-secondary text-center text-light">No se encontraron vacunas.</td>
                </tr>
                <tr v-else 
                    v-for="(extraction,idx) in vaccines" :key="idx">
                    <td v-text="extraction.name_employee"></td>
                    <td v-text="extraction.name_medicine"></td>
                    <td v-text="extraction.quantity+' MG'"></td>
                    <td v-text="formDate(extraction.date)"></td>
                </tr>
            </tbody>
        </table>	                        
	</div>
</template>

<script>
import AdminLayout from "@/layouts/AdminLayout.vue";

export default {
	name: "VaccinesCow",

	created()
	{
		this.$bus.$on("cow", ({ cow }) => {
			this.vaccines = cow.vaccines;
			this.cowEx = cow;
		});
	},

	data() {
		return {
			vaccines:[],
			title: "",
			accion: "",
			cowEx: ""
		};
	},

	components: {
		AdminLayout,
	},

	methods: {
		formDate(date)
		{
			return date.split('-')[2]+'-'+date.split('-')[1]+'-'+date.split('-')[0]
		}
	}
};
</script>

<style lang="css" scoped></style>
