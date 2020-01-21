<template>
	<nav class="col-md-2 d-none d-md-block bg-light sidebar">
		<div class="sidebar-sticky">
			<ul class="nav flex-column">
				<li class="nav-item">
					<router-link
						tag="a"
						:to="{ name: 'Employees' }"
						class="nav-link"
					>
						<font-awesome-icon icon="user-tie" />

						Empleados
					</router-link>
				</li>
				<li class="nav-item">
					<router-link
						tag="a"
						:to="{ name: 'Payments' }"
						class="nav-link"
					>
						<font-awesome-icon icon="handshake" />

						Pagos
					</router-link>
				</li>
				<li class="nav-item">
					<router-link
						tag="a"
						:to="{ name: 'Cows' }"
						class="nav-link"
					>
						<font-awesome-icon icon="democrat" />

						Reses
					</router-link>
				</li>
				<li class="nav-item">
					<router-link
						tag="a"
						:to="{ name: 'Extractions' }"
						class="nav-link"
					>
						<font-awesome-icon icon="arrow-alt-circle-down" />

						Extraccion de leche
					</router-link>
				</li>
				<li class="nav-item">
					<router-link
						tag="a"
						:to="{ name: 'Medicines' }"
						class="nav-link"
					>
						<font-awesome-icon icon="medkit" />

						Medicinas existentes
					</router-link>
				</li>
				<li class="nav-item">
					<router-link
						tag="a"
						:to="{ name: 'Vaccines' }"
						class="nav-link"
					>
						<font-awesome-icon icon="syringe" />

						Vacunas aplicadas
					</router-link>
				</li>
				<li class="nav-item" v-if="$auth.user().rol == 'admin'">
					<router-link
						tag="a"
						:to="{ name: 'Users' }"
						class="nav-link"
					>
						<font-awesome-icon icon="users" />

						Usuarios
					</router-link>
				</li>
			</ul>
			<h6
				class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"
			>
				<span>Estadisticas</span>
			</h6>
			<ul class="nav flex-column mb-2">
				<li class="nav-item">
					<router-link
						tag="a"
						:to="{ name: 'Stadistics' }"
						class="nav-link"
					>
						<font-awesome-icon icon="chart-pie" />

						Extraccion de leche
					</router-link>
				</li>
				<li class="nav-item">
				</li>
				<li class="nav-item">
				</li>
				<li class="nav-item">
				</li>
			</ul>
		</div>
	</nav>
</template>

<script>
export default {
	name: "AsidePartial",

	data() {
		return {};
	}
};
</script>

<style lang="css" scoped>
	.fade-enter-active, .fade-leave-active {
  transition: opacity .5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0
}
</style>
