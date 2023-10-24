<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" width="250" style="height: 100%">
            <!-- <v-list-item prepend-avatar="/Logo.svg"></v-list-item> -->
            <v-img src="/Logo.svg"></v-img>
            <v-divider class="my-3"></v-divider>
            <v-list density="compact" nav>
                <router-link
                    v-for="link in navLinkData"
                    :key="link.value"
                    :to="link.path"
                >
                    <v-list-item
                        :prepend-icon="
                            this.$route.name === link.path.name
                                ? link.iconSelect
                                : link.icon
                        "
                        :title="link.title"
                        :value="link.value"
                    ></v-list-item>
                </router-link>
            </v-list>

            <v-list
                density="compact"
                nav
                style="position: absolute; bottom: 0; left: 0; right: 0"
                base-color="secondary"
            >
                <v-divider class="mb-5"></v-divider>
                <router-link :to="{ name: 'employee' }">
                    <v-list-item
                        prepend-icon="mdi-account-outline"
                        title="Profile"
                        value="profile"
                    />
                </router-link>
                <router-link :to="{ name: 'contract' }">
                    <v-list-item
                        prepend-icon="mdi-logout-variant"
                        title="Logout"
                        value="logout"
                    />
                </router-link>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar elevation="0" class="border-b" density="compact">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-app-bar-title>MKTA HRMS</v-app-bar-title>

            <Department />

            <Notification />

            <router-link :to="{ name: 'settings' }">
                <v-btn icon="">
                    <v-icon
                        :icon="
                            this.$route.matched[1].name === 'settings'
                                ? 'mdi-cog'
                                : ' mdi-cog-outline'
                        "
                    ></v-icon>
                    <v-tooltip location="bottom" activator="parent"
                        >Settings</v-tooltip
                    >
                </v-btn>
            </router-link>

            <template #append>
                <v-divider vertical class="mx-5"></v-divider>
                <div class="d-flex align-center" style="gap: 1rem">
                    <ProfileMenu />
                </div>
            </template>
        </v-app-bar>

        <v-main class="background">
            <v-container>
                <router-view v-slot="{ Component }">
                    <template v-if="Component">
                        <Suspense timeout="0">
                            <component :is="Component" />

                            <template v-slot:fallback>
                                <Spinner />
                            </template>
                        </Suspense>
                    </template>
                </router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import { navLinkData } from "./navLinkData";
import { useNotificationStore } from "@/stores/notificationStore";
import { usePendingViolationStore } from "@/stores/pendingViolationStore";

import ProfileMenu from "./components/ProfileMenu.vue";
import Department from "./components/Department.vue";
import Spinner from "@/components/Spinner.vue";
import Notification from "./components/Notification.vue";

export default {
    setup() {
        const notificationStore = useNotificationStore();
        const pendingViolationStore = usePendingViolationStore();

        return {
            notificationStore,
            pendingViolationStore,
        };
    },
    data: () => ({ drawer: null, navLinkData }),
    components: { ProfileMenu, Department, Spinner, Notification },
    watch: {
        $route() {
            console.log(this.$route.matched[1].name);
        },
    },
    mounted() {
        const tenMinutes = 1000 * 60 * 10;
        this.pollServerEvery(tenMinutes);
    },
    methods: {
        pollServerEvery(interval) {
            setInterval(() => {
                this.notificationStore.getNotifications();
                this.pendingViolationStore.getPendingViolations();
            }, interval);
        },
    },
};
</script>

<style scoped>
.router-link-exact-active {
    color: #42a5f5;
}

.actions {
    display: flex;
    gap: 1rem;
}

i {
    color: #42a5f5;
}
</style>
