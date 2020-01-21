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
			let dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
	        this.weekData = {
	          labels: dias,
	          datasets: [
	            {
	              label: "Litros de la semana",
	              backgroundColor: 'green',
	              data: [
	              	((data[dias[0]]))?(data[dias[0]]):0,
	              	((data[dias[1]]))?(data[dias[1]]):0,
	              	((data[dias[2]]))?(data[dias[2]]):0,
	              	((data[dias[3]]))?(data[dias[3]]):0,
	              	((data[dias[4]]))?(data[dias[4]]):0,
	              	((data[dias[5]]))?(data[dias[5]]):0,
	              	((data[dias[6]]))?(data[dias[6]]):0
	              ]
	            }
	          ]
	        };
	    },

		setMonthData(data) {
			let semanas = ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5'];
	        this.monthData = {
	          labels: semanas,
	          datasets: [
	            {
	              label: "Litros de la semana",
	              backgroundColor: 'blue',
	              data: [
					((data[semanas[0]]))?(data[semanas[0]]):0,
					((data[semanas[1]]))?(data[semanas[1]]):0,
					((data[semanas[2]]))?(data[semanas[2]]):0,
					((data[semanas[3]]))?(data[semanas[3]]):0,
					((data[semanas[4]]))?(data[semanas[4]]):0
	              ]
	            }
	          ]
	        };
		},

		setRangeData(data) {
			let meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
			this.rangeData={
				labels:meses,
				datasets:[]
			}
			let obj = JSON.parse(data);
			Object.keys(obj).forEach((year,key)=>{
				this.rangeData.datasets.push({
			        label: 'Extracciones del '+year,
			    	data: [
		    			(obj[year][meses[0]])?(obj[year][meses[0]]):0,
		    			(obj[year][meses[1]])?(obj[year][meses[1]]):0,
		    			(obj[year][meses[2]])?(obj[year][meses[2]]):0,
		    			(obj[year][meses[3]])?(obj[year][meses[3]]):0,
		    			(obj[year][meses[4]])?(obj[year][meses[4]]):0,
		    			(obj[year][meses[5]])?(obj[year][meses[5]]):0,
		    			(obj[year][meses[6]])?(obj[year][meses[6]]):0,
		    			(obj[year][meses[7]])?(obj[year][meses[7]]):0,
		    			(obj[year][meses[8]])?(obj[year][meses[8]]):0,
		    			(obj[year][meses[9]])?(obj[year][meses[9]]):0,
		    			(obj[year][meses[10]])?(obj[year][meses[10]]):0,
		    			(obj[year][meses[11]])?(obj[year][meses[11]]):0
			    	]
			    })
			});
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
				this.$alertify.success('Cargando grafica con exito!')
	    	}else{
				this.$alertify.warning('Debes definir un rango!')
	    	}
	    },

	    setDate(){
	    	let moment = require('moment');
			this.range.to = moment().format("YYYY-MM-DD");
			this.range.from = moment().subtract(3, 'months').format("YYYY-MM-DD");
	    }
	},

	created() {
		this.setDate()
		this.fetchExtractionsStadistics(this.fetchExtractionsUrl);
	}
	
};
</script>

<style lang="css" scoped></style>
