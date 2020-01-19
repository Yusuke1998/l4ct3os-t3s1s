<template>
	<admin-layout>
		<template v-slot:header>
			<h3 class="text-center">ESTADISTICAS</h3>
		</template>

		<template v-slot:body>
			<ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item">
			    <a class="nav-link active" id="week-tab" data-toggle="tab" href="#week" role="tab" aria-controls="week" aria-selected="true">Extraccion de la semana</a>
			  </li>
			  <li class="nav-item" @click.once="refreshChart('2')">
			    <a class="nav-link" id="month-tab" data-toggle="tab" href="#month" role="tab" aria-controls="month" aria-selected="false">Extraccion del mes</a>
			  </li>
			  <li class="nav-item" @click.once="refreshChart('3')">
				<a class="nav-link" id="range-tab" data-toggle="tab" href="#range" role="tab" aria-controls="range" aria-selected="false">Extraccion por rango de Fecha</a>
			  </li>
			</ul>

			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active" id="week" role="tabpanel" aria-labelledby="week-tab">
				<div class="row">
					<div class="col-md-8 offset-2">
						<br>
						<h5 class="text-center"> Extraccion de leche de esta semana por litro</h5>
						<chart 
							:chart-data="weekData" 
							:options="options"></chart>
					</div>
				</div>
			  </div>

			  <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
				<div class="row">
					<div class="col-md-8 offset-2">
						<br>
						<h5 class="text-center"> Extraccion de leche de este mes por litro</h5>
						<chart 
							ref="chart2" 
							:chart-data="monthData" 
							:options="options"></chart>
					</div>
				</div>
			  </div>

			  <div class="tab-pane fade" id="range" role="tabpanel" aria-labelledby="range-tab">
				<div class="row">
					<div class="col-md-8 offset-2">
						<br>
						<h5 class="text-center"> Extraccion de leche por litro, rango de fecha.</h5>
						<div class="row">
							<div class="offset-1 col-md-4">
								<input 
									type="date" 
									class="form-control" 
									v-model="range.from">
							</div>
							<div class="col-md-4">
								<input 
									:disabled="range.from===null" 
									type="date" 
									class="form-control" 
									v-model="range.to">
							</div>
							<div class="col-md-1">
								<a @click="searchRange" class="text-white btn btn-info">
									<font-awesome-icon icon="search"/>
								</a>
							</div>
						</div>
						<chart 
							ref="chart3" 
							:chart-data="rangeData" 
							:options="options"></chart>
					</div>
				</div>
			  </div>
			</div>								
			
		</template>
	</admin-layout>
</template>

<script>
import AdminLayout from "@/layouts/AdminLayout.vue";
import Chart from "@/components/Chart.vue";

export default {
	name: "StadisticsPage",

	data: () =>({

			weekData: null,
			monthData: null,
			rangeData: null,
			range:{
				from:null,
				to:null
			},
		    options: { responsive: true, maintainAspectRatio: false },
			fetchExtractionsUrl: "/extractions/stadistics",
	}),

	components: {
		AdminLayout,
		Chart,
	},

	methods: {
		fetchExtractionsStadistics(url) {
			axios.post(url,{range:this.range}).then(response => {
				this.setWeekData(response.data.week_extractions);
				this.setMonthData(response.data.month_extractions);
				this.setRangeData(response.data.range_extractions);
			});
		},

		setWeekData(data) {
	        this.weekData = {
	          labels: Object.keys(data),
	          datasets: [
	            {
	              label: "Litros de la semana",
	              backgroundColor: 'green',
	              data: Object.values(data)
	            }
	          ]
	        };
	    },

		setMonthData(data) {
	        this.monthData = {
	          labels: Object.keys(data),
	          datasets: [
	            {
	              label: "Litros de la semana",
	              backgroundColor: 'blue',
	              data: Object.values(data)
	            }
	          ]
	        };
		},

		setRangeData(data) {
	        this.rangeData = {
	          labels: Object.keys(data),
	          datasets: [
	            {
	              label: "Litros del mes",
	              backgroundColor: 'yellow',
	              data: Object.values(data)
	            }
	          ]
	        };
		},

	    refreshChart(id){
	    	if(id==='2'){
	    		this.$refs.chart2.refresh();
	    	}else{
	    		this.$refs.chart3.refresh();
	    	}
	    },

	    searchRange(){
	    	if (this.range.from!==null && this.range.from!=="" && this.range.to!==null && this.range.to!=="") {
				this.fetchExtractionsStadistics(this.fetchExtractionsUrl);
	    	}else{
	    		swal("Rango no definido!", {
					icon: "warning"
				}).then(value => {
	    			this.$refs.chart3.refresh();
				});;
	    	}
	    }
	},

	created() {
		this.fetchExtractionsStadistics(this.fetchExtractionsUrl);
	},

	computed: {
	}
};
</script>

<style lang="css" scoped></style>
