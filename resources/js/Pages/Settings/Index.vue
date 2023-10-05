<template>
    <h1 class="text-overline d-flex align-center mx-2 mb-2" style="gap: 0.3rem">
        <v-icon>mdi-cog-outline</v-icon>
        <p>Settings</p>
    </h1>
    <v-card>
        <v-tabs v-model="tab.tab" color="primary">
            <v-tab
                v-for="(tab, index) in tab.tabData"
                :value="index"
                :key="index"
                :prepend-icon="tab.icon"
                :to="tab.link"
                class="text-none"
                >{{ tab.title }}</v-tab
            >
        </v-tabs>
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
    </v-card>
</template>

<script>
import Spinner from "@/components/Spinner.vue";
export default {
    components: {
        Spinner,
    },
    data() {
        return {
            tab: {
                tab: null,
                tabData: [
                    {
                        icon: "mdi-shield-outline",
                        title: "Disciplinary Measures",
                        link: { name: "disciplinaryMeasure" },
                    },
                    {
                        icon: "mdi-format-list-checkbox",
                        title: "Violation Types",
                        link: { name: "violationType" },
                    },
                    {
                        icon: "mdi-alert-decagram-outline",
                        title: "Violations",
                        link: { name: "violation" },
                    },
                ],
            },
        };
    },
};
</script>

<style scoped></style>
