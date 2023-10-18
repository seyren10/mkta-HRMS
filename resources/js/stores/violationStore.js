import { defineStore } from "pinia";

export const useViolationStore = defineStore("violations", {
    state() {
        return {
            violations: [],
            violation: {},
            form: {
                description: "",
                violation_type_id: null,
                action_length: null,
                disciplinaryActionIds: [],
            },
        };
    },

    actions: {
        async getViolations() {
            try {
                this.loading = true;
                const res = await axios.get("/api/violation");

                this.violations = res.data.data;
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async addViolation() {
            try {
                this.loading = true;
                await axios.post("/api/violation", this.form);

                this.errors = {};
                await this.getViolations();
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async updateViolation() {
            try {
                this.loading = true;
                await axios.put(`/api/violation/${this.form.id}`, this.form);

                this.errors = {};
                await this.getViolations();
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
                description: "",
                violation_type_id: null,
                action_length: null,
            };
            this.errors = {};
        },
    },
});
