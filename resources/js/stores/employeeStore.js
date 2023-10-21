import { defineStore } from "pinia";
import { useEmployeeViolationStore } from "./employeeViolationStore";
import { useViolationStore } from "./violationStore";

export const useEmployeeStore = defineStore("employees", {
    state() {
        return {
            employees: [],
            employee: {},
            form: {
                employee_id: null,
                first_name: null,
                last_name: null,
                position: null,
                is_active: true,
                department_id: null,
                hired_date: new Date().toISOString().split("T")[0],
            },
        };
    },
    getters: {
        getViolationAttemptsByEmployeeId(state) {
            return (id) => {
                const employeeViolationStore = useEmployeeViolationStore();

                return state.employees
                    .find((el) => el.id === id)
                    .employeeViolations.reduce((acc, curr) => {
                        if (
                            curr.violation.id ===
                            employeeViolationStore.form.violation_id
                        )
                            acc++;
                        return acc;
                    }, 0);
            };
        },
        getViolationAttempts(state) {
            return (id, violationId) => {
                return state.employees
                    .find((el) => el.id === id)
                    .employeeViolations.reduce((acc, curr) => {
                        if (curr.violation.id === violationId) acc++;
                        return acc;
                    }, 0);
            };
        },

        
    },
    actions: {
        async getEmployees(params = {}) {
            try {
                this.loading = true;
                const res = await axios.get("/api/employee", { params });
                this.employees = res.data.data;
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async getEmployee(id) {
            try {
                this.loading = true;
                const res = await axios.get(`/api/employee/${id}`);
                this.employee = res.data.employee;
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async addEmployee() {
            try {
                this.loading = true;
                await axios.post("/api/employee", this.form);

                this.errors = {};
                await this.getEmployees();
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async updateEmployee(data) {
            try {
                this.loading = true;
                await axios.put(`/api/employee/${data.id}`, data);

                this.errors = {};
                await this.getEmployees();
                await this.getEmployee(data.id);
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async searchEmployees(data) {
            try {
                this.loading = true;
                const res = await axios.get(`/api/employee`, {
                    params: { q: data },
                });
                console.log(res);
                this.employees = res.data.data;
                this.errors = {};
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
                first_name: null,
                last_name: null,
                position: null,
                is_active: true,
                department_id: null,
                hired_date: new Date().toISOString().split("T")[0],
                is_active: true,
            };
        },
    },
});
