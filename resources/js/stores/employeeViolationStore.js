import { defineStore } from "pinia";
import { useEmployeeStore } from "./employeeStore";
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
    getters: {
        getDisciplinaryActionByEmployeeId(state) {
            const employeeStore = useEmployeeStore();

            return (id) => {
                const count =
                    employeeStore.getViolationAttemptsByEmployeeId(id);
                console.log("count:", count);

                return state.employeeViolations
                    .find((el) => {
                        return el.employee.id === id;
                    })
                    ?.violation.disciplinaryActions.find(
                        (a) => a.offense_no === count
                    )?.disciplinaryMeasure.title;
            };
        },
        getDisciplinaryAction(state) {
            const employeeStore = useEmployeeStore();

            return (id, violationId) => {
                const count = employeeStore.getViolationAttempts(
                    id,
                    violationId
                );
                console.log("count:", count);

                return state.employeeViolations
                    .find((el) => {
                        return el.employee.id === id;
                    })
                    ?.violation.disciplinaryActions.find(
                        (a) => a.offense_no === count
                    )?.disciplinaryMeasure.title;
            };
        },
    },

    actions: {
        async getEmployeeViolations(params = {}) {
            try {
                this.loading = true;
                const res = await axios.get("/api/employee-violation", {
                    params,
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

                await this.getEmployeeViolations({ includeEmployee: true });

                //fetch employees
                const employeeStore = useEmployeeStore();
                await employeeStore.getEmployees({
                    includeEmployeeViolations: true,
                });

                this.errors = {};
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
