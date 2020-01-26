<template>
	<form>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon4"
					>Tipo</span
				>
			</div>
			<select class="form-control" id="exampleFormControlSelect1" aria-describedby="basic-addon4" placeholder="Seleccionar" v-model="form.type" required>
				<option value="" selected>Seleccionar</option>
				<option value="girolando">Girolando</option>
				<option value="holstein">Holstein</option>
				<option value="brahman">Brahman</option>
				<option value="pardo_suizo">Pardo Suizo</option>
			</select>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1">Kg</span>
			</div>
			<input
				type="text"
				class="form-control"
				placeholder="Peso"
				aria-label="Peso"
				aria-describedby="basic-addon1"
				v-model="form.weight"
				required
			/>
		</div>

		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon2">2000</span>
			</div>

			<input
				type="number"
				min="4"
				max="4"
				class="form-control"
				placeholder="Año"
				aria-label="Año"
				aria-describedby="basic-addon2"
				v-model="form.year_birth"
				required
			/>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon3"
					>Codigo</span
				>
			</div>
			<input
				type="text"
				class="form-control"
				placeholder="Codigo"
				aria-label="Codigo"
				aria-describedby="basic-addon3"
				v-model="form.code"
				required
			/>
		</div>
	</form>
</template>

<script>
import crudMixin from "@/mixins/crud.js";

export default {
	name: "FormCow",

	mixins: [crudMixin],

	data() {
		return {
			form: {
				id: "",
				type: "",
				weight: "",
				year_birth: "",
				code: ""
			},

			id: 'cows',
			deleteUrl: "/cow/delete",
			updateUrl: "/cow/update",
			createUrl: "/cow/register"
		};
	},

	created() {
		this.$bus.$on("changeMilkingState", ({title, item}) => {
			this.changeMilkingState(this.updateUrl, title, item);
		});
	},


	methods: {

		changeMilkingState(url ,title, item) {
			item.milking = !item.milking;
			delete item.ordeno; 
			delete item.vueTableComponentInternalRowId;
			let id = item.id;
			let endpoint = `${url}/${id}`;

			swal({
				title: "Seguro deseas "+ title + " el ordeño de esta res ?",
				text: "una vez aceptado, cambiara el estado de ordeños de la misma!",
				icon: "warning",
				buttons: true,
				dangerMode: true
			}).then(willState => {
				if (willState) {
					axios.put(endpoint, item)
						.then(() => {
							swal("El estado ha sido modificada!", {
								icon: "success"
							});
							utils.reload();
						})
						.catch(error => {
							swal("Tu res no pudo ser modificado!", {
								icon: "error"
							});
						});
				} else {
					return;
				}
			});
		},
	}
};
</script>

<style lang="css" scoped></style>
