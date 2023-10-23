import { defineStore } from "pinia";

export const useNotificationStore = defineStore("notifications", {
    state() {
        return {
            notifications: [],
        };
    },
    actions: {
        async getNotifications() {
            try {
                const res = await axios.get("/api/user-notifications");
                this.notifications = res.data;
            } catch (e) {
                // this.error = e.response.data.message;
            }
        },
    },
});
