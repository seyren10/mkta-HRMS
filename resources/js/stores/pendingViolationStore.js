import { defineStore } from "pinia";
export const usePendingViolationStore = defineStore("pendingViolations", {
    state() {
        return {
            pendingViolations: [],
            form: {
                employee_id: null,
                violation_id: null,
                document_link: null,
                document_data: {},
            },
        };
    },
    getters: {
        getEmployeeDisciplinaryAction(state) {
            return (id, violationId) => {
                const violation = state.pendingViolations.filter((el) => {
                    return (
                        el.employee.id === id && el.violation.id === violationId
                    );
                });
                return violation
                    ?.at(0)
                    .violation.disciplinaryActions.find(
                        (a) => a.offense_no === violation.length
                    ).disciplinaryMeasure.title;
            };
        },
        getEmployeeViolationAttempts(state) {
            return (id, violationId) => {
                const violation = state.pendingViolations.filter((el) => {
                    return (
                        el.employee.id === id && el.violation.id === violationId
                    );
                });
                return violation.length;
            };
        },
    },
    actions: {
        async getPendingViolations(params = {}) {
            try {
                this.loading = true;
                const res = await axios.get("/api/pending-violation", {
                    params,
                });
                this.pendingViolations = res.data.data;
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async addPendingViolation() {
            try {
                this.loading = true;

                const res = await axios.post(
                    "/api/pending-violation",
                    this.form
                );

                this.errors = {};
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },

        async deletePendingViolations(data) {
            const ids = data.map((e) => e.id);
            try {
                this.loading = true;
                await axios.delete(`/api/pending-violation/${ids}`);

                await this.getPendingViolations();
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
                violation_id: null,
                document_link: null,
                document_data: {},
            };
            this.errors = {};
        },
    },
});
