<template>
    <div class="login">
        <v-sheet>
            <v-card border elevation="0" min-width="400">
                <v-img src="/21207.jpg"></v-img>
                <v-card-title class="text-overline text-center"
                    >Login</v-card-title
                >
                <v-card-text>
                    <v-card
                        v-if="Object.keys(errors).length"
                        class="bg-red-lighten-4 rounded text-caption text-red-darken-3 mb-3"
                        flat
                    >
                        <template #prepend>
                            <v-icon>mdi-alert-circle-outline</v-icon>
                            {{ errors?.message }}</template
                        >
                    </v-card>
                    <v-form @submit.prevent="login">
                        <v-text-field
                            prepend-icon="mdi-at"
                            variant="underlined"
                            label="Email"
                            type="email"
                            v-model="email"
                        />
                        <v-text-field
                            prepend-icon="mdi-key-outline"
                            type="password"
                            variant="underlined"
                            label="Password"
                            v-model="password"
                        />
                        <div class="mt-3">
                            <v-btn
                                type="submit"
                                color="primary"
                                block
                                variant="flat"
                                :loading="loading"
                                >Login</v-btn
                            >
                            <p class="mt-3 text-caption">
                                Need an account? Request one in the
                                <span class="text-primary">MIS Office</span>
                            </p>
                        </div>
                    </v-form>
                </v-card-text>

                <div></div>
            </v-card>
        </v-sheet>
    </div>
</template>

<script>
import { storeToRefs } from "pinia";
import { useUserStore } from "../../stores/userStore";
export default {
    setup() {
        const userStore = useUserStore();
        const { loading, errors } = storeToRefs(userStore);

        return { userStore, loading, errors };
    },
    data() {
        return {
            email: null,
            password: null,
        };
    },
    methods: {
        login() {
            this.userStore.login(this.email, this.password);
        },
    },
};
</script>

<style scoped>
.login {
    min-height: 100dvh;
    display: grid;
    place-content: center;
}
</style>
