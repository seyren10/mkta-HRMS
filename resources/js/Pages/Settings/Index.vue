<template>
    <Heading icon="mdi-cog-outline">Settings</Heading>
    <v-card>
        No Content Yet.
        <!-- <v-tabs v-model="tab.tab" color="primary">
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
        <v-container> No Content </v-container> -->
    </v-card>
</template>

<script>
import Heading from "../../components/Heading.vue";

export default {
    data() {
        return {
            tab: {
                tab: null,
                tabData: [],
            },
        };
    },
    components: { Heading },
};
</script>

<style scoped></style>
