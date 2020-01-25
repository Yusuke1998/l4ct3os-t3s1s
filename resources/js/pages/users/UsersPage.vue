<template>
	<admin-layout>
		<template v-slot:header>
			<h3>Usuarios</h3>
			<button
				class="btn btn-primary"
				data-toggle="modal"
				data-target="#users"
				@click="
					setTitle('Crear Usuario'), setAccion('create'), setClear()
				"
			>
				<font-awesome-icon icon="user-plus" />
				Crear nuevo usuario
			</button>

			<!-- Modals -->
			<modal :title="title" idTarget="users" :accion="accion">
				<form-user></form-user>
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
					<table-column show="name" label="Nombre"></table-column>
					<table-column
						show="email"
						label="Correo"
					></table-column>
					<table-column
						show="rol_user"
						label="Rol"
						:filterable="false"
						:sortable="false"
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
								data-target="#users"
								@click="
									setTitle('Editar Usuario'),
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
import FormUser from "./FormUser";
import mutatorMixin from '@/mixins/mutator.js'

export default {
	name: "UsersPage",

	mixins: [mutatorMixin],

	data() {
		return {
			title: "",
			accion: "",
			fecthUrl: '/users',
			fecthTableUrl: "/users"
		};
	},

	components: {
		AdminLayout,
		Modal,
		FormUser
	},

	methods: {
		
	}
};
</script>

<style lang="css" scoped></style>
