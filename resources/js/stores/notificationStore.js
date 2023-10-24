import { defineStore } from "pinia";

export const useNotificationStore = defineStore("notifications", {
    state() {
        return {
            notifications: [],
        };
    },
    getters: {
        getTruncatedFullNames(state) {
            return (id, limit = 3) => {
                const notification = state.notifications.find(
                    (e) => e.id === id
                );

                return notification.data.data
                    .reduce((acc, cur) => {
                        if (
                            notification.data.type === "pendingViolation" &&
                            notification.data.data.length >= limit
                        ) {
                            if (notification.data.data.indexOf(cur) < limit)
                                acc.push(cur.employee.full_name);
                        } else if (
                            notification.data.type === "pendingViolation"
                        ) {
                            acc.push(cur.employee.full_name);
                        }
                        return acc;
                    }, [])
                    .join(", ");
            };
        },
        getUnreadNotificationCount() {
            return this.notifications.reduce((acc, cur) => {
                if (!cur.read_at) return ++acc;
                return acc;
            }, 0);
        },
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
