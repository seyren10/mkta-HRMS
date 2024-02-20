import { defineStore } from "pinia";

export const useSettingStore = defineStore("settings", {
    state() {
        return {
            settings: [],
        };
    },
    actions: {
        async getSettings() {
            try {
                this.loading = true;
                const res = await axios.get("/api/setting");
                this.settings = res.data.data;
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
        async updateSettings(settings) {
            try {
                this.loading = true;
                await axios.put("/api/setting", settings);
            } catch (e) {
                this.errors = e.response.data.errors;
            } finally {
                this.loading = false;
            }
        },
    },
});
