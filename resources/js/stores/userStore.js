import { defineStore } from "pinia";
import router from "../router/index";

export const useUserStore = defineStore("users", {
    state: () => {
        return {
            user: null,
        };
    },
    getters: {},
    actions: {
        async getUser() {
            try {
                const res = await axios.get("/api/user");
                this.user = res.data;

                await this.getNotifications();
            } catch (e) {
                // this.error = e.response.data.message;
            }
        },

        async login(email, password) {
            this.loading = true;
            await axios.get("/sanctum/csrf-cookie");
            try {
                const res = await axios.post("/login", {
                    email: email,
                    password: password,
                });
                await this.getUser();
                this.errors = {};

                router.push({ name: "dashboard" });
            } catch (e) {
                console.log(e);
                this.errors = e.response.data;
            } finally {
                this.loading = false;
            }
        },
        async logout() {
            try {
                await axios.delete("/logout");
                this.user = null;
                this.router.push({ name: "login" });
            } catch (e) {}
        },
        async setPasswordFirstTime(data) {
            try {
                await axios.put("/set-password-first-time", data);
                await this.logout();
            } catch (e) {}
        },
        async updateName(data) {
            try {
                await axios.put("/update-name", data);
                await this.getUser();
            } catch (e) {}
        },
    },
});
