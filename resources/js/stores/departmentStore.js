import { defineStore } from "pinia";

export const useDepartmentStore = defineStore("categories", {
    state() {
        return {
            departments: [],
            form: {
                title: null,
                description: null,
                division: "production",
            },
        };
    },
    actions: {
        async getDepartments() {
            try {
                this.loading = true;
                const res = await axios.get("/api/department");
                this.departments = res.data.data;
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async addDepartment() {
            try {
                this.loading = true;
                await axios.post("/api/department", this.form);

                this.errors = {};
                this.getDepartments();
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async updateDepartment() {
            try {
                this.loading = true;
                await axios.put(`/api/department/${this.form.id}`, this.form);

                this.errors = {};
                this.getDepartments();
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
                title: null,
                description: null,
                division: "production",
            };
        },
    },
});
