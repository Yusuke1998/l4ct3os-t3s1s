<template>
	<admin-layout>
		<template v-slot:header>
			<h3>Pagos</h3>
			<button
				class="btn btn-primary"
				data-toggle="modal"
				data-target="#payments"
				@click="
					setTitle('Crear Pago'), setAccion('create'), setClear()
				">
				<font-awesome-icon icon="handshake" />
				Nuevo Pago
			</button>
			<!-- Modals -->
			<modal :title="title" idTarget="payments" :accion="accion">
				<form-payment></form-payment>
			</modal>
		</template>

		<template v-slot:body>
			<ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item">
			    <a class="nav-link active" id="prev-tab" data-toggle="tab" href="#prev" role="tab" aria-controls="prev" aria-selected="true">Pagos Pendientes</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" id="post-tab" data-toggle="tab" href="#post" role="tab" aria-controls="post" aria-selected="false">Pagos Realizados</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active" id="prev" role="tabpanel" aria-labelledby="prev-tab">
				<div class="row">
					<div class="col-md-8 offset-2">
						<br>
						<h5 class="text-center"> Pagos Pendientes</h5>
					</div>
				</div>
			  </div>
			  <div class="tab-pane fade" id="post" role="tabpanel" aria-labelledby="post-tab">
				<div class="row">
					<div class="col-md-8 offset-2">
						<br>
						<h5 class="text-center"> Pagos Realizados</h5>
					</div>
				</div>
			  </div>
			</div>
		</template>
	</admin-layout>
</template>

<script>
import AdminLayout from "@/layouts/AdminLayout.vue";
import Modal from "@/components/Modal.vue";
import FormPayment from "./FormPayment";
import mutatorMixin from "@/mixins/mutator.js";

export default {
	name: "PaymentPage",

	mixins: [mutatorMixin],

	data() {
		return {
			title: "",
			accion: "",
			fecthUrl: "/payments"
		};
	},

	components: {
		AdminLayout,
		Modal,
		FormPayment
	},

	methods: {}
};
</script>

<style lang="css" scoped></style>
