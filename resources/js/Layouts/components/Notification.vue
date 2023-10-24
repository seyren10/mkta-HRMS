<template>
    <v-menu location="start">
        <template #activator="{ props }">
            <v-btn icon="" v-bind="props">
                <v-badge color="red" :content="getUnreadNotificationCount">
                    <v-icon color="primary">mdi-bell-outline</v-icon>
                </v-badge>
                <v-tooltip location="bottom" activator="parent"
                    >Notifications</v-tooltip
                >
            </v-btn>
        </template>
        <v-card elevation="1" max-width="700" class="pa-2" max-height="700">
            <v-list>
                <v-list-subheader sticky>Notifications</v-list-subheader>
                <v-list-item
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="mb-1 rounded text-grey border border"
                    :class="{ 'bg-accent-light': !notification.read_at }"
                    :prepend-icon="
                        notification.data.type === 'pendingViolation'
                            ? 'mdi-delete-alert-outline'
                            : 'mdi-bell-outline'
                    "
                >
                    <div
                        class="text-caption text-grey-darken-2"
                        v-if="notification.data.type === 'pendingViolation'"
                    >
                        <strong>{{
                            getTruncatedFullNames(notification.id, 3)
                        }}</strong>
                        <template v-if="notification.data.data.length - 3 >= 0">
                            and
                            <strong
                                >{{ notification.data.data.length - 3 }}
                            </strong>
                            other
                        </template>
                        <template v-if="notification.data.data.length > 1">{{
                            " were "
                        }}</template>
                        <template v-else>{{ " was " }} </template>
                        automatically rejected for failing to submit a response within a
                        5-day deadline.
                        <span class="text-grey">(Pending Violation)</span>

                        <div class="mt-3 text-primary">
                            {{ formatDate(notification.created_at) }}
                        </div>
                    </div>
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
import { useUtils } from "@/composables/useUtils";

export default {
    async setup() {
        const notificationStore = useNotificationStore();
        await notificationStore.getNotifications();
        const {
            notifications,
            getTruncatedFullNames,
            getUnreadNotificationCount,
        } = storeToRefs(notificationStore);

        const { formatDate } = useUtils();
        return {
            notificationStore,
            notifications,
            getTruncatedFullNames,
            getUnreadNotificationCount,
            formatDate,
        };
    },
};
</script>

<style scoped></style>
