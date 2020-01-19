const mutatorMixin = {

	methods: {
		setTitle(title) {
			this.title = title;
		},

		setAccion(accion) {
			this.accion = accion;
		},

		setData(data, event = false) {
			this.$bus.$emit("data", { data, event });
		},

		setClear() {
			this.$bus.$emit("clear");
		},

		setEventDelete(id) {
			this.$bus.$emit("delete", { id });
		},

		async fetchData() {
			const response = await axios.get(this.fecthUrl);
			return response.data;
			this.$refs.table.refresh();
		},

		async fetchDataTable({page,filter,sort}) { //revisar
			const response = await axios.post(this.fecthTableUrl,{page,filter,sort});
			return response.data;
			this.$refs.table.refresh();
		}
	}
};

export default mutatorMixin;
