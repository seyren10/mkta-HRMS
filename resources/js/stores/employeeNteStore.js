import { defineStore } from "pinia";

export const useEmployeeNteStore = defineStore("employeeNtes", {
    state() {
        return {
            ntes: [],
            form: {
                offense_type: null,
                offense_length: 5,
            },
        };
    },
    actions: {
        async getNtes() {
            try {
                this.loading = true;
                const res = await axios.get("/api/employee-nte");
                this.ntes = res.data.data;
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async addNte() {
            try {
                this.loading = true;
                await axios.post("/api/employee-nte", this.form);

                this.errors = {};
                await this.getNtes();
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async updateNte() {
            try {
                this.loading = true;
                await axios.put(`/api/employee-nte/${this.form.id}`, this.form);

                this.errors = {};
                await this.getNtes();
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },

        setForm(data) {
            this.form = data;
        },
        clearForm() {
            this.form = {
                offense_type: null,
                offense_length: null,
            };
        },
    },
});
