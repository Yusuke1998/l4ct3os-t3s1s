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
				if (this.account.number.length == 20) {
				// if (this.EsCCCValida(this.account.number)) {
					this.account.employee_id = this.employee
					axios.post(this.storeUrl,this.account)
					.then(resp=>{
						this.$alertify.success('Registro de cuenta Exitoso!')
						this.dataBlank()
						this.$bus.$emit('createdAccount',true)
					})
					.catch(errors => {
	                    Object.values(errors.response.data.errors).forEach((element,indx) => {
	                        this.$alertify.error(element.toString())
	                    });
					});
				}else{
					this.$alertify.error('El número de cuenta no es valido!')
				}
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
		},

		// Validar cuenta bancaria, codigo roba2
		CStr(value)	{
			return (value + "");
		},

		LTrim(str)	{
			var whitespace = new String(" \t\n\r");
			var s = new String(str);
		
			if (whitespace.indexOf(s.charAt(0)) != -1) {
				var j=0, i = s.length;
			
				while (j < i && whitespace.indexOf(s.charAt(j)) != -1) { j++; }
					s = s.substring(j, i);
				}
			return s;
		},

		EsCCCValida( cuenta ){
			var digitosVerificadoresValidos;
			var strCodBanco;
			var strCodSucursalBanco;
			var strCodTipoCta;
			var strCodNroCta;
			var intFactor, intSuma;
			var i,j;
			var strDC1, strDC2;
			var digitosVerificadoresValidos;
			var auxStrDC, auxStrdigcontrol;

			var strCCC_20digitos = new String(cuenta);

			strCodBanco					=  strCCC_20digitos.substring(0,4);
			strCodSucursalBanco =  strCCC_20digitos.substring(4,8);
			strCodTipoCta				=  strCCC_20digitos.substring(10,12);
			strCodNroCta				=  strCCC_20digitos.substring(12,20);
	    

			strDC1 = strCodBanco + strCodSucursalBanco;
			strDC2 = strCodSucursalBanco + strCodTipoCta + strCodNroCta;
			digitosVerificadoresValidos = "";

			j=1;
			while (j<=2){
				if (j==1){
					auxStrDC = strDC1
				}
				if (j==2){
					auxStrDC = strDC2
				}

				intFactor = 2;
				intSuma = 0;

				i = auxStrDC.length;
				while (i>=1)	{
					intSuma = intSuma + (auxStrDC.substring(i-1,i) * intFactor);

					if(intFactor == 7){
						intFactor = 2;
					}
					else {
						intFactor = intFactor + 1;
					}
					i = i-1;
				}

				auxStrdigcontrol = this.LTrim(this.CStr(11 - (intSuma % 11)));

				if(parseInt(auxStrdigcontrol) > 9){
					auxStrdigcontrol = auxStrdigcontrol.substring(auxStrdigcontrol.length-1,auxStrdigcontrol.length);
				}

				digitosVerificadoresValidos = digitosVerificadoresValidos + auxStrdigcontrol
				j = j + 1
			} 

			if(strCCC_20digitos.substring(8,10) == digitosVerificadoresValidos){
				return true;
			}
			else {
				return false;
			}
		} 
	}
};
</script>

<style lang="css" scoped></style>
