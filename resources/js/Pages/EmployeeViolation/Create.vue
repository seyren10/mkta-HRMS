<template>
    <v-dialog fullscreen transition="dialog-bottom-transition">
        <template v-slot:activator="{ props }">
            <slot :props="props"></slot>
        </template>

        <template v-slot:default="{ isActive }">
            <v-card>
                <v-toolbar color="accent-light">
                    <v-toolbar-title
                        ><Heading icon="mdi-account-alert-outline"
                            >Assign Violation</Heading
                        ></v-toolbar-title
                    >
                    <v-btn
                        @click="isActive.value = false"
                        icon="mdi-close"
                    ></v-btn>
                </v-toolbar>
                <v-card-text>
                    <div class="row">
                        <v-select
                            variant="underlined"
                            density="compact"
                            label="Violation Type"
                            prepend-icon="mdi-playlist-check"
                            :items="violationTypes"
                            item-title="violation_type"
                            item-value="id"
                            v-model="violationType"
                            clearable
                        ></v-select>
                        <v-select
                            variant="underlined"
                            density="compact"
                            label="Disciplinary Action"
                            prepend-icon="mdi-shield-outline"
                            :items="disciplinaryMeasures"
                            item-title="title"
                            item-value="id"
                            clearable
                        ></v-select>
                    </div>
                    <v-select
                        variant="underlined"
                        density="comfortable"
                        label="Offense Description"
                        prepend-icon="mdi-text"
                        :items="violations"
                        item-title="description"
                        item-value="id"
                        clearable
                    ></v-select>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </template>
    </v-dialog>
</template>

<script>
import Heading from "@/components/Heading.vue";
export default {
    async setup() {},
    props: {
        employees: Array,
        violationTypes: Array,
        disciplinaryMeasures: Array,
    },
    components: { Heading },
    data() {
        return {
            violationType: null,
            disciplinaryMeasure: null,
        };
    },
    methods: {},
    computed: {
        violations() {
            return this.violationTypes.find(
                (vT) => vT.id === this.violationType
            )?.violations;
        },
    },
};
</script>

<style scoped></style>
