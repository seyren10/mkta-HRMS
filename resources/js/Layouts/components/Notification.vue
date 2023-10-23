<template>
    <v-menu location="start">
        <template #activator="{ props }">
            <v-btn icon="" v-bind="props">
                <v-badge color="red" :content="notifications.length">
                    <v-icon color="primary">mdi-bell-outline</v-icon>
                </v-badge>
                <v-tooltip location="bottom" activator="parent"
                    >Notifications</v-tooltip
                >
            </v-btn>
        </template>
        <v-card elevation="1" max-width="700" class="pa-2">
            <v-list>
                <v-list-subheader>Notifications</v-list-subheader>
                <v-list-item
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="bg-accent-light mb-1 rounded text-grey"
                    :prepend-icon="
                        notification.data.type === 'pendingViolation'
                            ? 'mdi-delete-alert-outline'
                            : 'mdi-bell-outline'
                    "
                >
                    <p
                        class="text-caption text-grey-darken-2"
                        v-if="notification.data.type === 'pendingViolation'"
                    >
                        {{ notification.data.data }}
                    </p>
                </v-list-item>
                <v-list-item
                    v-if="!notifications.length"
                    class="bg-accent-light mb-1 rounded"
                >
                    <template #prepend>
                        <v-icon>mdi-bell-check-outline</v-icon>
                    </template>
                    <v-list-item-title class="text-caption text-grey-darken-2"
                        >You Dont have any notifications...</v-list-item-title
                    >
                </v-list-item>
            </v-list>
        </v-card>
    </v-menu>
</template>

<script>
import { useNotificationStore } from "@/stores/notificationStore";
import { storeToRefs } from "pinia";
export default {
    async setup() {
        const notificationStore = useNotificationStore();
        await notificationStore.getNotifications();
        const { notifications } = storeToRefs(notificationStore);
        return { notificationStore, notifications };
    },
};
</script>

<style scoped></style>
