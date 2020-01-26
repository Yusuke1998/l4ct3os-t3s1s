<template>
	<admin-layout>
		<template v-slot:header>
			<h3>Extracciones de leche</h3>
			<button
				class="btn btn-primary"
				data-toggle="modal"
				data-target="#extractions"
				@click="
					setTitle('Registrar nueva extraccion'),
						setAccion('create'),
						setClear()
				"
			>
				<font-awesome-icon icon="plus" />
				Registrar nueva extraccion
			</button>

			<!-- Modals -->
			<modal :title="title" idTarget="extractions" :accion="accion">
				<form-extraction></form-extraction>
			</modal>
		</template>

		<template v-slot:body>
			<div class="col-lg-12 col-md-10">
				<table-component
					:data="fetchDataTable"
					sort-by="date"
					sort-order="desc"
					:cache-lifetime="false"
					ref="table">
					<table-column
						show="date"
						label="Fecha de ordeño"
						:filterable="true"
						:sortable="true"
					>
					</table-column>
					<table-column
						show="quantity"
						label="Leche ordeñada LTS"
						:filterable="true"
						:sortable="true"
					>
					</table-column>
					<table-column
						show="name_employee"
						label="Nombre del ordeñador"
						:filterable="true"
						:sortable="false"
					></table-column>
					<table-column
						show="code_cow"
						label="Codigo de la res ordeñada"
						:filterable="true"
						:sortable="false"
					></table-column>
					<table-column
						label="Accion"
						:sortable="false"
						:filterable="false">
						<template slot-scope="row">
							<button
								class="btn btn-sm btn-danger"
								@click="setData(row, true)"
							>
								Eliminar
							</button>
							<button
								class="btn btn-sm btn-warning"
								data-toggle="modal"
								data-target="#extractions"
								@click="
									setTitle('Editar Extraccion'),
										setAccion('edit'),
										setData(row)">
								Editar
							</button>
						</template>
					</table-column>
					<template slot="tfoot" slot-scope="{ rows }">
				        <tr>
				            <th>&nbsp;</th>
				            <th>&nbsp;</th>
				            <th>Total Lts:</th>
				            <th>{{ rows.reduce((sum, value) => { return sum + value.data.quantity; }, 0) }}</th>
				            <th>&nbsp;</th>
				        </tr>
				    </template>
				</table-component>
			</div>
		</template>
	</admin-layout>
</template>

<script>
import AdminLayout from "@/layouts/AdminLayout.vue";
import Modal from "@/components/Modal.vue";
import FormExtraction from "./FormExtraction";
import mutatorMixin from "@/mixins/mutator.js";

export default {
	name: "ExtractionPage",

	mixins: [mutatorMixin],

	data() {
		return {
			title: "",
			accion: "",
			fecthUrl: "/extractions",
			fecthTableUrl: "/extractions"
		};
	},

	components: {
		AdminLayout,
		Modal,
		FormExtraction,
	},

	methods: {

	}
};
</script>

<style lang="css" scoped></style>
