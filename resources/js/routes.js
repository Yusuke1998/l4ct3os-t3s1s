import HomePage from "./pages/HomePage.vue";
import LoginPage from "./pages/auth/LoginPage.vue";
import UsersPage from "./pages/users/UsersPage";
import EmployeesPage from "./pages/employees/EmployeesPage";
import PaymentPage from './pages/payments/PaymentPage';
import CowsPage from "./pages/cows/CowsPage";
import MedicinesPage from "./pages/medicines/MedicinesPage";
import VaccinesPage from "./pages/vaccines/VaccinesPage";
import ExtractionsPage from "./pages/extractions/ExtractionsPage";
import StadisticsPage from './pages/stadistics/StadisticsPage';

const domain = window.location.host;
let routes = null;

if(domain == 'localhost'){
	 routes = [
	{
		path: "/hatos-lecheros/public",
		redirect: "/login"
	},

	{
		path: "/hatos-lecheros/public/login",
		name: "Login",
		component: LoginPage,
		meta: {
			auth: false
		}
	},

	{
		path: "/hatos-lecheros/public/home",
		name: "Dashboard",
		component: HomePage,
		meta: {
			auth: true
		}
	},

	{
		path: "/hatos-lecheros/public/users",
		name: "Users",
		component: UsersPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/hatos-lecheros/public/employees",
		name: "Employees",
		component: EmployeesPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/hatos-lecheros/public/payments",
		name: "Payments",
		component: PaymentPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/hatos-lecheros/public/cows",
		name: "Cows",
		component: CowsPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/hatos-lecheros/public/medicines",
		name: "Medicines",
		component: MedicinesPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/hatos-lecheros/public/vaccines",
		name: "Vaccines",
		component: VaccinesPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/hatos-lecheros/public/extractions",
		name: "Extractions",
		component: ExtractionsPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/hatos-lecheros/public/stadistics",
		name: "Stadistics",
		component: StadisticsPage,
		meta: {
			auth: true
		}
	}


	];

}else{
	 routes = [
	{
		path: "/",
		redirect: "/login"
	},

	{
		path: "/login",
		name: "Login",
		component: LoginPage,
		meta: {
			auth: false
		}
	},

	{
		path: "/home",
		name: "Dashboard",
		component: HomePage,
		meta: {
			auth: true
		}
	},

	{
		path: "/users",
		name: "Users",
		component: UsersPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/employees",
		name: "Employees",
		component: EmployeesPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/payments",
		name: "Payments",
		component: PaymentPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/cows",
		name: "Cows",
		component: CowsPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/medicines",
		name: "Medicines",
		component: MedicinesPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/vaccines",
		name: "Vaccines",
		component: VaccinesPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/extractions",
		name: "Extractions",
		component: ExtractionsPage,
		meta: {
			auth: true
		}
	},

	{
		path: "/stadistics",
		name: "Stadistics",
		component: StadisticsPage,
		meta: {
			auth: true
		}
	}


	];
}


export default routes;
