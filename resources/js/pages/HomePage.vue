<template>
	<admin-layout>
		<template v-slot:header>
			<h3 class="text-center">INICIO</h3>
		</template>

		<template v-slot:body>
			<div class="row">
				<div class="col-md-6">
					<card header="Litros ordeñados del dia" title="Cantidad">
						<b>{{ milkExtratedToday }} lts</b>
					</card>
				</div>
				<div class="col-md-6">
					<card header="Numero actual de reses del hato" title="Cantidad">
						<b>{{ totalCows }}</b>
					</card>
				</div>				
			</div>
			
			<br>
			
			<div class="row">
				<div class="col-md-12">
					<card header="Vacunas aplicadas del dia" title="Cantidad">
						<b>{{ totalVaccines }}</b>
					</card>
				</div>
			</div>

		</template>
	</admin-layout>
</template>

<script>
import AdminLayout from "@/layouts/AdminLayout.vue";
import Card from "@/components/Card.vue";

export default {
	name: "HomePage",

	data: () =>({
			extractions: [],
			totalVaccines: 0,
			totalCows: 0,
			fetchExtractionsUrl: "/extractions/stadistics",
			fetchTotalCowsUrl: "/cows/total",
			fetchTotalVaccinesUrl: "/vaccines/total/today",
	}),

	components: {
		AdminLayout,
		Card,
	},

	methods: {
		fetchExtractionsStadistics(url) {
			axios.post(url,{data:'data'}).then(response => {
				this.extractions = response.data.today_extractions;
			});
		},

		fetchTotalCows(url) {
			axios.get(url).then(response => {
				this.totalCows = response.data.data;
			});
		},

		fetchTotalVaccines(url) {
			axios.get(url).then(response => {
				this.totalVaccines = response.data.data;
			});
		},
	},

	created() {
		this.fetchExtractionsStadistics(this.fetchExtractionsUrl);
		this.fetchTotalCows(this.fetchTotalCowsUrl);
		this.fetchTotalVaccines(this.fetchTotalVaccinesUrl);
	},

	computed: {
		milkExtratedToday: function() {
			let totalMilk = 0;
			this.extractions.forEach(ele => {
				totalMilk += ele.quantity;
			});
			return totalMilk;
		}
	}
};
</script>

<style lang="css" scoped></style>
