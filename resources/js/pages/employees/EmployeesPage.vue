<template>
	<admin-layout>
		<template v-slot:header>
			<h3>Empleados</h3>
			<button
				class="btn btn-primary"
				data-toggle="modal"
				data-target="#employees"
				@click="
					setTitle('Crear Empleado'), setAccion('create'), setClear()
				"
			>
				<font-awesome-icon icon="user-plus" />
				Crear nuevo empleado
			</button>

			<!-- Modals -->
			<modal :title="title" idTarget="employees" :accion="accion">
				<form-employee></form-employee>
			</modal>
		</template>

		<template v-slot:body>
			<div class="col-lg-12 col-md-10">
				<table-component
					:data="fetchDataTable"
					sort-by="id"
					sort-order="asc"
					:cache-lifetime="false"
					ref="table"
				>
					<table-column
						show="name"
						label="Nombre"
						:filterable="true"
					></table-column>
					<table-column
						show="identificacion_number"
						label="Cedula"
					></table-column>
					<table-column
						show="age"
						label="Edad"
						:filterable="true"
					>
					</table-column>
					<table-column show="cargo" label="Cargo"> </table-column>

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
								data-target="#employees"
								@click="
									setTitle('Editar Empleado'),
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
import FormEmployee from "./FormEmployee";
import mutatorMixin from "@/mixins/mutator.js";

export default {
	name: "EmployeesPage",

	mixins: [mutatorMixin],

	data() {
		return {
			title: "",
			accion: "",
			fecthUrl: "/employees",
			fecthTableUrl: "/employees"
		};
	},

	components: {
		AdminLayout,
		Modal,
		FormEmployee
	},

	methods: {}
};
</script>

<style lang="css" scoped></style>
