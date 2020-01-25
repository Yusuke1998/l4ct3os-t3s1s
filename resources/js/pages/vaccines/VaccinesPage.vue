<template>
	<admin-layout>
		<template v-slot:header>
			<h3>Todas las vacunas aplicadas</h3>

			<!-- Modals -->
			<modal :title="title" idTarget="vaccines" :accion="accion">
				<form-vaccine></form-vaccine>
			</modal>
		</template>

		<template v-slot:body>
			<div class="col-lg-12 col-md-10">
				<table-component
					:data="fetchDataTable"
					sort-by="id"
					sort-order="asc"
					ref="table"
				>
					<table-column
						show="name_employee"
						label="Nombre del vacunador"
						:filterable="true"
					></table-column>
					<table-column
						show="code_cow"
						label="Codigo de la res vacunada"
					></table-column>
					<table-column
						show="name_medicine"
						label="Vacuna"
						:filterable="true"
					>
					</table-column>
					<table-column
						:formatter="FormDate" 
						show="date" 
						label="Fecha aplicada">
					</table-column>
					<table-column label="Cantidad"> 
						<template slot-scope="row">
							{{row.quantity}} mg
						</template>
					</table-column>
					

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
								data-target="#vaccines"
								@click="
									setTitle('Editar Vacuna aplicada'),
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
import FormVaccine from "./FormVaccine";
import mutatorMixin from "@/mixins/mutator.js";

export default {
	name: "VaccinesPage",

	mixins: [mutatorMixin],

	data() {
		return {
			title: "",
			accion: "",
			fecthUrl: "/vaccines",
			fecthTableUrl: "/vaccines"
		};
	},

	components: {
		AdminLayout,
		Modal,
		FormVaccine
	},

	methods: {
		FormDate(value, rowProperties){
			return value.split('-')[2]
					+'/'+value.split('-')[1]
					+'/'+value.split('-')[0]
		}
	}
};
</script>

<style lang="css" scoped></style>
