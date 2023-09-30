import { defineStore } from "pinia";

export const useDisciplinaryMeasureStore = defineStore("disciplinaryMeasure", {
    state() {
        return {
            disciplinaryMeasures: [],
            form: {
                title: null,
            },
        };
    },
    actions: {
        async getDisciplinaryMeasures() {
            try {
                this.loading = true;
                const res = await axios.get("/api/disciplinary-measure");
                this.disciplinaryMeasures = res.data.data;
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async addDisciplinaryMeasure() {
            try {
                this.loading = true;
                await axios.post("/api/disciplinary-measure", this.form);

                this.errors = {};
                await this.getDisciplinaryMeasures();
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async updateDisciplinaryMeasure() {
            try {
                this.loading = true;
                await axios.put(
                    `/api/disciplinary-measure/${this.form.id}`,
                    this.form
                );

                this.errors = {};
                await this.getDisciplinaryMeasures();
                this.clearForm();
            } catch (e) {
                console.log(e);
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        // async getEmployee(id) {
        //     try {
        //         this.loading = true;
        //         const res = await axios.get(`/api/employee/${id}`);
        //         this.employee = res.data.employee;
        //     } catch (e) {
        //         console.log(e);
        //         this.errors = e.response.data.errors;
        //     } finally {
        //         this.loading = false;
        //     }
        // },
        setForm(data) {
            this.form = data;
        },
        clearForm() {
            this.form = {
                title: null,
            };
        },
    },
});
