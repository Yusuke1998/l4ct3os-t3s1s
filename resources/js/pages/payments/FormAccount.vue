<template>
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				Crear Cuenta
			</h5>
			<button
				type="button"
				class="close"
				@click="modalMy('modalAccounts',0)"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Banco</span>
					</div>
					<input
						v-model="account.name_bank"
						type="text"
						class="form-control"
						placeholder="Nombre del Banco"
						aria-label="Banco"
						aria-describedby="basic-addon1"
						required/>
				</div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Numero</span>
					</div>
					<input
						v-model="account.number"
						type="number"
						class="form-control"
						placeholder="Numero de Cuenta"
						aria-label="Numero"
						aria-describedby="basic-addon1"
						required/>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button
				type="button"
				class="btn btn-secondary"
				@click="modalMy('modalAccounts',0)">
				Cerrar
			</button>
			<button 
				@click="saveAccount()"
				type="button" 
				class="btn btn-primary">
				Guardar
			</button>
		</div>
	</div>
</template>

<script>

export default {
	name: "FormAccount",

	data() {
		return {
			account: {
				number:'',
				name_bank:'',
				employee_id:0
			},
			storeUrl:'/account/register'
		};
	},

	props:{
		employee: {
			required: true
		}
	},

	methods: {
		saveAccount()
		{
			if (this.employee==0) {
				this.$alertify.warning('Debes seleccionar una trabajador!')
			}else{
				this.account.employee_id = this.employee

				axios.post(this.storeUrl,this.account)
				.then(resp=>{
					this.$alertify.warning('Registro Exitoso!')
					this.dataBlank()
					this.$bus.$emit('createdAccount',true)
				})
				.catch(errors => {
                    Object.values(errors.response.data.errors).forEach((element,indx) => {
                        this.$alertify.error(element.toString())
                    });
				});
			}
		},
		modalMy(id="modal",bool)
		{
			if (bool) {
				$("#"+id).modal('show')
			}else{
				$("#"+id).modal('hide')
			}
		},

		dataBlank()
		{
			this.account={
				number:'',
				name_bank:'',
				employee_id:0
			}
			this.modalMy('modalAccounts',0)
		}
	}
};
</script>

<style lang="css" scoped></style>
