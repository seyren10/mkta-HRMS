import { defineStore } from "pinia";

export const useViolationTypeStore = defineStore("violationTypes", {
    state() {
        return {
            violationTypes: [],
            form: {
                violation_type: null,
            },
        };
    },
    actions: {
        async getViolationTypes() {
            try {
                this.loading = true;
                const res = await axios.get("/api/violation-type");
                this.violationTypes = res.data.data;
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async addViolationType() {
            try {
                this.loading = true;
                await axios.post("/api/violation-type", this.form);

                this.errors = {};
                await this.getViolationTypes();
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async updateViolationType() {
            try {
                this.loading = true;
                await axios.put(
                    `/api/violation-type/${this.form.id}`,
                    this.form
                );

                this.errors = {};
                await this.getViolationTypes();
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
                violation_type: null,
            };
        },
    },
});
