<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" width="200">
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
        </v-navigation-drawer>

        <v-app-bar elevation="0" class="border-b" density="compact">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-app-bar-title>MKTA HRMS</v-app-bar-title>

            <Department />
            <v-btn icon="">
                <v-badge color="red" content="9">
                    <v-icon>mdi-bell-outline</v-icon>
                </v-badge>
                <v-tooltip location="bottom" activator="parent"
                    >Notifications</v-tooltip
                >
            </v-btn>

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
export default {};
</script>

<style scoped></style>
