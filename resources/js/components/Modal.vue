<template>
	<!-- Modal -->
	<div
		class="modal fade"
		:id="idTarget"
		tabindex="-1"
		aria-hidden="true"
	>
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						{{ title }}
					</h5>
					<button
						type="button"
						class="close"
						data-dismiss="modal"
						aria-label="Close"
					>
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<slot></slot>
				</div>
				<div class="modal-footer">
					<button
						type="button"
						class="btn btn-secondary"
						data-dismiss="modal"
						@click="clearHandler()"
					>
						Cerrar
					</button>
					<button type="button" @click.prevent.stop="registerHandler()" class="btn btn-primary" v-if="accion == 'create'">
						Guardar
					</button>
					<button type="button" @click.prevent="editHandler" class="btn btn-warning" v-if="accion == 'edit'">
						Editar
					</button>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "Modal",

	props: {

		title: {
			type: String,	
			required: true
		},

		idTarget: {

			type: String,
			required: true
		},

		accion: {
			type: String,
			required: false			
		}
	},

	methods:{

		registerHandler(){
			this.$bus.$emit('register',this.idTarget);
		},

		editHandler(){
			this.$bus.$emit('edit');
		},

		clearHandler(){
			this.$bus.$emit('clear');
		}

	}
};
</script>

<style lang="css" scoped></style>
