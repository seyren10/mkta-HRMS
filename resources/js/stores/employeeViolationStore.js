import { defineStore } from "pinia";
import { useEmployeeStore } from "./employeeStore";
import { useViolationStore } from "./violationStore";
import { usePendingViolationStore } from "./pendingViolationStore";

export const useEmployeeViolationStore = defineStore("employeeViolations", {
    state() {
        return {
            employeeViolations: [],
            form: [],
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

                return state.employeeViolations
                    .find((el) => {
                        return el.employee.id === id;
                    })
                    ?.violation.disciplinaryActions.find(
                        (a) => a.offense_no === count
                    )?.disciplinaryMeasure.title;
            };
        },

        getEmployeeDisciplinaryAction(state) {
            return (id, violationId, offset = 0) => {
                const employeeViolations = state.employeeViolations.filter(
                    (el) => {
                        return (
                            el.employee.id === id &&
                            el.violation.id === violationId
                        );
                    }
                );

                if (!employeeViolations.length) {
                    //when there's no violation found, it means
                    //it's a first attempt thus giving the first disciplinary action
                    const violationStore = useViolationStore();
                    return violationStore.violations
                        .find((e) => e.id === violationId)
                        .disciplinaryActions?.at(0).disciplinaryMeasure.title;
                }

                return employeeViolations
                    .at(0)
                    .violation.disciplinaryActions.find(
                        (a) =>
                            a.offense_no === employeeViolations.length + offset
                    ).disciplinaryMeasure.title;
            };
        },

        getEmployeeViolationAttempts(state) {
            return (id, violationId, offset = 0) => {
                const violation = state.employeeViolations.filter((el) => {
                    return (
                        el.employee.id === id && el.violation.id === violationId
                    );
                });
                if (violation.length) return violation.length + offset;

                return offset;
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
                this.errors = {};

                const pendingViolationStore = usePendingViolationStore();

                //delete the pending after it has been added
                //to employeeViolations
                await pendingViolationStore.deletePendingViolations(this.form);

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
            this.form = [];
            this.errors = {};
        },
    },
});
