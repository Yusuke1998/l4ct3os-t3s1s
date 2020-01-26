<template>
	<admin-layout>
		<template v-slot:header>
			<h3>Reses</h3>
			<button
				class="btn btn-primary"
				data-toggle="modal"
				data-target="#cows"
				@click="
					setTitle('Registrar Res'), setAccion('create'), setClear()
				"
			>
				<font-awesome-icon icon="user-plus" />
				Registrar nueva res
			</button>

			<!-- Modals -->
			<modal :title="title" idTarget="cows" :accion="accion">
				<form-cow></form-cow>
			</modal>

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
					:cache-lifetime="false"
					ref="table"
				>
					<table-column
						show="type"
						label="Tipo"
						:filterable="true"
					></table-column>
					<table-column show="weight" label="Peso"></table-column>
					<table-column
						show="year_birth"
						label="Año"
						:filterable="true"
					>
					</table-column>
					<table-column show="code" label="Codigo"> </table-column>

					<table-column show="ordeno" label="Ordeño"> </table-column>

					<table-column
						label="Accion"
						:sortable="false"
						:filterable="false"
					>
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
								data-target="#cows"
								@click="
									setTitle('Editar Res'),
										setAccion('edit'),
										setData(row)
								"
							>
								Editar
							</button>
							<button
								class="btn btn-sm btn-success"
								data-toggle="modal"
								v-if="row.ordeno == 'No'"
								@click="setChangeMilking('activar', row)"
							>
								Habilitar ordeño
							</button>
							<button
								class="btn btn-sm btn-danger"
								data-toggle="modal"
								v-else
								@click="setChangeMilking('desactivar', row)"
							>
								Deshabilitar ordeño
							</button>
							<button
								class="btn btn-sm btn-primary"
								data-toggle="modal"
								data-target="#vaccines"
								@click="
									setCowId(row.id),
										setTitle('Aplicar vacuna a res'),
										setAccion('create')
								"
							>
								<font-awesome-icon icon="syringe" />
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
import FormCow from "./FormCow";
import FormVaccine from "../vaccines/FormVaccine";
import mutatorMixin from "@/mixins/mutator.js";

export default {
	name: "CowPage",

	mixins: [mutatorMixin],

	data() {
		return {
			title: "",
			accion: "",
			fecthUrl: "/cows",
			fecthTableUrl: "/cows"
		};
	},

	components: {
		AdminLayout,
		Modal,
		FormCow,
		FormVaccine
	},

	methods: {
		setChangeMilking(title, item) {
			this.$bus.$emit("changeMilkingState", { title, item });
		},

		setCowId(id) {
			this.$bus.$emit("cow_id", { id: id });
		}
	}
};
</script>

<style lang="css" scoped></style>
