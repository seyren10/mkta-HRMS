<template>
    <v-menu min-width="200px" rounded>
        <template v-slot:activator="{ props }">
            <p class="text-caption text-secondary">Hi, {{ user.name }}</p>
            <v-btn icon v-bind="props">
                <v-avatar size="small" image="https://i.pravatar.cc/100?img=12">
                </v-avatar>
            </v-btn>
        </template>
        <v-card>
            <v-card-text>
                <h3>Example user</h3>
                <p class="text-caption">test@example.com</p>
                <v-divider class="mt-3"></v-divider>
                <v-list density="compact" nav>
                    <v-list-item prepend-icon="mdi-account-outline"
                        >Profile</v-list-item
                    >
                    <v-list-item prepend-icon="mdi-logout" @click="logout"
                        >Logout</v-list-item
                    >
                </v-list>
            </v-card-text>
        </v-card>
    </v-menu>
</template>

<script>
import { useUserStore } from "@/stores/userStore";
import { storeToRefs } from "pinia";
export default {
    async setup() {
        const userStore = useUserStore();
        await userStore.getUser();
        const { user } = storeToRefs(userStore);
        return { user, userStore };
    },
    methods: {
        logout() {
            this.userStore.logout();
        },
    },
};
</script>

<style scoped></style>
