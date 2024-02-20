<template>
    <Heading icon="mdi-cog-outline">Settings</Heading>
    <v-sheet class="pa-3">
        <v-alert type="info" closable close-label="Close Alert" v-model="alert"
            >Success</v-alert
        >

        <v-list v-for="(setting, key) in settings" :key="key">
            <v-list-subheader>
                {{ camelCaseToTitleCase(key) }}
            </v-list-subheader>
            <v-list-item v-for="set in setting">
                <div v-if="set.name === 'automaticRejection'">
                    <v-checkbox
                        label="Automatic Rejection after 5 days"
                        :model-value="+set.value ? true : false"
                        @change="
                            (event) => {
                                form[set.name] = {
                                    id: set.id,
                                    value: event.target.checked,
                                };
                            }
                        "
                    ></v-checkbox>
                </div>
            </v-list-item>
        </v-list>

        <v-btn
            class="text-none"
            flat
            color="primary"
            prepend-icon="mdi-content-save-check-outline"
            @click="update"
            :loading="settingLoading"
            >Save changes</v-btn
        >
    </v-sheet>
</template>

<script>
import { useSettingStore } from "@/stores/settingStore";
import { storeToRefs } from "pinia";

import Heading from "../../components/Heading.vue";

export default {
    async setup() {
        const settingStore = useSettingStore();
        await settingStore.getSettings();
        const { settings, loading: settingLoading } = storeToRefs(settingStore);

        return {
            settings,
            settingStore,
            settingLoading,
        };
    },
    data() {
        return {
            form: {},
            alert: false,
        };
    },
    methods: {
        camelCaseToTitleCase(inputString) {
            // Add a space before each capital letter that is not at the beginning
            return (
                inputString
                    .replace(/([a-z])([A-Z])/g, "$1 $2")
                    // Capitalize the first letter of each word
                    .replace(/^./, function (str) {
                        return str.toUpperCase();
                    })
            );
        },
        async update() {
            const form = {
                data: Object.entries(this.form).map(([key, value]) => ({
                    id: value.id,
                    value: value.value,
                })),
            };
            await this.settingStore.updateSettings(form);
            this.alert = true;
        },
    },
    components: { Heading },
};
</script>

<style scoped></style>
