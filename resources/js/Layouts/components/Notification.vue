<template>
    <v-menu location="start" :close-on-content-click="false">
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
        <v-card
            elevation="1"
            max-width="700"
            class="pa-2 pt-0"
            max-height="700"
        >
            <v-card-title
                class="text-grey bg-white d-flex justify-space-between align-center"
                style="position: sticky; top: 0; left: 0; z-index: 1"
                ><span>Notifications</span>
                <div class="d-flex align-center gap-1">
                    <v-btn
                        class="text-caption"
                        flat
                        color="primary"
                        density="compact"
                        prepend-icon="mdi-bell"
                        @click="filtered = !filtered"
                        >{{ filtered ? "Show All" : "Show Unread" }}</v-btn
                    >
                    <v-btn
                        class="text-caption"
                        variant="outlined"
                        color="primary"
                        density="compact"
                        prepend-icon="mdi-email-newsletter"
                        @click="notificationStore.markAllAsRead()"
                        >Mark all as read</v-btn
                    >
                </div></v-card-title
            >
            <v-card-text class="pa-0">
                <v-list>
                    <v-list-item
                        v-for="notification in filtered
                            ? filteredNotifications
                            : notifications"
                        :key="notification.id"
                        class="mb-1 rounded text-grey border border"
                        :class="{ 'bg-accent-light': !notification.read_at }"
                        :prepend-icon="
                            notification.data.type === 'pendingViolation'
                                ? 'mdi-delete-alert-outline'
                                : 'mdi-bell-outline'
                        "
                        @click="notificationStore.markAsRead(notification.id)"
                    >
                        <template #prepend>
                            <div class="mr-4">
                                <v-icon style="font-size: 2rem">{{
                                    notification.data.type ===
                                    "pendingViolation"
                                        ? "mdi-delete-alert-outline"
                                        : "mdi-bell-outline"
                                }}</v-icon>
                            </div>
                        </template>
                        <div
                            class="text-caption text-grey-darken-2"
                            v-if="notification.data.type === 'pendingViolation'"
                        >
                            <strong>{{
                                getTruncatedFullNames(notification.id, 3)
                            }}</strong>
                            <template
                                v-if="notification.data.data.length - 3 > 0"
                            >
                                and
                                <strong
                                    >{{ notification.data.data.length - 3 }}
                                </strong>
                                other
                            </template>
                            <template
                                v-if="notification.data.data.length > 1"
                                >{{ " were " }}</template
                            >
                            <template v-else>{{ " was " }} </template>
                            automatically rejected for failing to submit a
                            response within a 5-day deadline.
                            <span style="text-transform: capitalize">
                                ({{
                                    notification.data.data.at(0).violation
                                        .violationType.violation_type
                                }})</span
                            >

                            <div class="mt-3 text-primary">
                                {{ formatDate(notification.created_at) }}
                            </div>
                        </div>
                    </v-list-item>
                    <v-list-item
                        v-if="
                            (filtered && !filteredNotifications.length) ||
                            !notifications.length
                        "
                        class="bg-accent-light mb-1 rounded"
                        width="500"
                    >
                        <template #prepend>
                            <v-icon>mdi-bell-check-outline</v-icon>
                        </template>
                        <v-list-item-title
                            class="text-caption text-grey-darken-2"
                            >You Dont have any
                            notifications...</v-list-item-title
                        >
                    </v-list-item>
                </v-list>
            </v-card-text>
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
    data() {
        return {
            filtered: false,
        };
    },
    computed: {
        filteredNotifications() {
            return this.notifications.filter((e) => !e.read_at);
        },
    },
};
</script>

<style scoped></style>
