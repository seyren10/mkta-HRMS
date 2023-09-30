<template>
    <v-card>
        <v-tabs v-model="tab.tab" color="primary">
            <v-tab
                v-for="(tab, index) in tab.tabData"
                :value="index"
                :key="index"
                :prepend-icon="tab.icon"
                class="text-none"
                >{{ tab.title }}</v-tab
            >
        </v-tabs>
        <v-window v-model="tab.tab">
            <v-window-item
                v-for="(data, index) in tab.tabData"
                :key="index"
                :value="index"
            >
                <v-container>
                    <component :is="data.component" />
                </v-container>
            </v-window-item>
        </v-window>
    </v-card>
</template>

<script>
import DisciplinaryMeasures from "./TabContents/DisciplinaryMeasures.vue";
import NteTypes from "./TabContents/NteTypes.vue";

export default {
    data() {
        return {
            tab: {
                tab: null,
                tabData: [
                    {
                        icon: "mdi-shield-outline",
                        title: "Disciplinary Measures",
                        component: "DisciplinaryMeasures",
                    },
                    {
                        icon: "mdi-format-list-checkbox",
                        title: "NTE Types",
                        component: "NteTypes",
                    },
                ],
            },
        };
    },
    components: { DisciplinaryMeasures, NteTypes },
};
</script>

<style scoped></style>
