import { defineStore } from "pinia";

export const useEmployeeViolationStore = defineStore("employeeViolations", {
    state() {
        return {
            employeeViolations: [],
            form: {
                employee_id: null,
                violation_id: null,
            },
        };
    },
    actions: {
        async getEmployeeViolations() {
            try {
                this.loading = true;
                const res = await axios.get("/api/employee-violation", {
                    params: {
                        includeViolations: true,
                    },
                });
                this.employeeViolations = res.data.data;
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async addEmployeeViolation() {
            try {
                this.loading = true;
                await axios.post("/api/employee-violation", this.form);

                this.errors = {};
                await this.getEmployeeViolations();
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async updateEmployeeViolation() {
            try {
                this.loading = true;
                await axios.put(
                    `/api/employee-violation/${this.form.id}`,
                    this.form
                );

                this.errors = {};
                await this.getEmployeeViolations();
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
                employee_id: null,
                violation_id: null,
            };
            this.errors = {};
        },
    },
});
