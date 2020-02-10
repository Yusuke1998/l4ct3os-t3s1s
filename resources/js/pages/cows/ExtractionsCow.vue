<template>
	<div class="container">
		<table v-if="cowEx !== undefined" class="table table-bordered table-hover">
            <thead class="text-center bg-info">
                <tr>
                    <th class="text-light text-capitalize">Trabajador</th>
                    <th class="text-light text-capitalize">Cantidad</th>
                    <th class="text-light text-capitalize">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="extractions.length === 0">
                    <td colspan="3" class="bg-secondary text-center text-light">No se encontraron extracciones.</td>
                </tr>
                <tr v-else 
                    v-for="(extraction,idx) in extractions" :key="idx">
                    <td v-text="extraction.name_employee"></td>
                    <td v-text="extraction.quantity+' LTS'"></td>
                    <td v-text="formDate(extraction.date)"></td>
                </tr>
            </tbody>
        </table>	                        
	</div>
</template>

<script>
import AdminLayout from "@/layouts/AdminLayout.vue";

export default {
	name: "ExtractionsCow",

	created()
	{
		this.$bus.$on("cow", ({ cow }) => {
			this.extractions = cow.extractions;
			this.cowEx = cow;
		});
	},

	data() {
		return {
			extractions:[],
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
