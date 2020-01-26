<template>
	<admin-layout>
		<template v-slot:header>
			<h3>Listado de Medicinas</h3>
			<button
				class="btn btn-primary"
				data-toggle="modal"
				data-target="#medicines"
				@click="
					setTitle('Registrar nueva medicina'),
						setAccion('create'),
						setClear()">
				<font-awesome-icon icon="plus" />
				Registrar nueva medicina
			</button>
			<!-- Modals -->
			<modal :title="title" idTarget="medicines" :accion="accion">
				<form-medicine></form-medicine>
			</modal>
		</template>

		<template v-slot:body>
			<div class="col-lg-12 col-md-10">
				<table-component
					:data="fetchDataTable"
					sort-by="id"
					sort-order="asc"
					ref="table"
					:cache-lifetime="false"
				>
					<table-column
						show="name_medicine"
						label="Nombre"
						:filterable="true"
					></table-column>
					<table-column
						:formatter="FormDate"
						show="date"
						label="Fecha de Vencimiento"
						:filterable="true"
					></table-column>
					<table-column
						:formatter="Defeated"
						label="Estatus"
						:filterable="true"
					></table-column>
					<table-column
						label="Accion"
						:sortable="false"
						:filterable="false"
					>
						<template slot-scope="row">
							<button
								class="btn btn-danger"
								@click="setData(row, true)"
							>
								Eliminar
							</button>
							<button
								class="btn btn-warning"
								data-toggle="modal"
								data-target="#medicines"
								@click="
									setTitle('Editar Medicina'),
										setAccion('edit'),
										setData(row)
								"
							>
								Editar
							</button>
						</template>
					</table-column>
				</table-component>
			</div>
		</template>
	</admin-layout>
</template>

<script>
import AdminLayout from "@/layouts/AdminLayout.vue";
import Modal from "@/components/Modal.vue";
import FormMedicine from "./FormMedicine";
import mutatorMixin from "@/mixins/mutator.js";

export default {
	name: "MedicinesPage",

	mixins: [mutatorMixin],

	data() {
		return {
			title: "",
			accion: "",
			fecthUrl: "/medicines",
			fecthTableUrl: "/medicines"
		};
	},

	components: {
		AdminLayout,
		Modal,
		FormMedicine
	},

	methods: {
		FormDate(value, rowProperties){
			return value.split('-')[2]
					+'/'+value.split('-')[1]
					+'/'+value.split('-')[0]
		},
		Defeated(value, rowProperties){
			let moment = require('moment')
			let defeated = moment(value.date).format("YYYY-MM-DD");
			let current = moment().format("YYYY-MM-DD");
			return defeated<=current?'Vencida':'Disponible';
		}
	}
};
</script>

<style lang="css" scoped></style>
