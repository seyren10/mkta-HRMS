import { defineStore } from "pinia";

export const useDisciplinaryActionStore = defineStore("disciplinaryActions", {
    state() {
        return {
            disciplinaryActions: [],
            form: {
                description: null,
                violation_type_id: null,
                action_length: 1,
            },
        };
    },
    actions: {
        async getDisciplinaryActions() {
            try {
                this.loading = true;
                const res = await axios.get("/api/disciplinary-action");

                this.disciplinaryActions = res.data.data;
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async addDisciplinaryAction() {
            try {
                this.loading = true;
                await axios.post("/api/disciplinary-action", this.form);

                this.errors = {};
                await this.getDisciplinaryActions();
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async updateDisciplinaryAction() {
            try {
                this.loading = true;
                await axios.put(
                    `/api/disciplinary-action${this.form.id}`,
                    this.form
                );

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
                description: null,
                violation_type_id: null,
                action_length: 5,
            };
            this.errors = {};
        },
    },
});
