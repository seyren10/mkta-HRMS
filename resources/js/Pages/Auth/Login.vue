<template>
    <div class="login">
        <v-sheet>
            <v-card border elevation="0" min-width="400">
                <v-img src="/21207.jpg"></v-img>
                <v-card-title class="text-overline text-center"
                    >Login</v-card-title
                >
                <v-card-text>
                    <v-text-field
                        prepend-icon="mdi-at"
                        variant="underlined"
                        label="Email"
                        type="email"
                    />
                    <v-text-field
                        prepend-icon="mdi-key-outline"
                        type="password"
                        variant="underlined"
                        label="Password"
                    />
                    <div class="mt-3">
                        <v-btn color="primary" block variant="flat"
                            >Login</v-btn
                        >
                        <p class="mt-3">
                            Doesn't have an account? Request one in
                            <span class="text-primary">MIS Office</span>
                        </p>
                    </div>
                </v-card-text>

                <div></div>
            </v-card>
        </v-sheet>
    </div>
</template>

<script>
export default {};
</script>

<style scoped>
.login {
    min-height: 100dvh;
    display: grid;
    place-content: center;
}
</style>
