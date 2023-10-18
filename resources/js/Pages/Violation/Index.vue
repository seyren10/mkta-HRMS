<template>
    <section>
        <Heading icon="mdi-alert-octagon-outline">Violations</Heading>
        <v-btn
            size="small"
            prepend-icon="mdi-format-list-checkbox"
            class="ml-4 mt-4 text-none"
            color="primary"
            :to="{ name: 'violationType' }"
            >Violation Types</v-btn
        >

        <Accordion :items="violationTypes" title-key="violation_type">
            <template v-slot="{ item: violationType }">
                <v-btn
                    prepend-icon="mdi-plus"
                    block
                    flat
                    color="secondary"
                    @click="handleAddViolation(violationType)"
                    >add violation</v-btn
                >
                <div class="row align-start">
                    <v-card
                        v-for="violation in violationType.violations"
                        class="my-2 border"
                        flat
                    >
                        <ViolationItem
                            :violation="violation"
                            :violationType="violationType"
                            :disciplinary-measures="disciplinaryMeasures"
                            @click="(data) => (dialog = data)"
                        />
                    </v-card>
                </div>
            </template>
        </Accordion>
        <v-dialog v-model="dialog.state" persistent fullscreen>
            <template v-slot:default="{ isActive }">
                <component
                    :is="dialog.component"
                    v-bind="dialog.props"
                    @close="
                        isActive.value = !isActive.value;
                        violationStore.clearForm();
                    "
                ></component>
            </template>
        </v-dialog>
    </section>
</template>

<script>
import { storeToRefs } from "pinia";
import { useViolationStore } from "@/stores/violationStore";
import { useViolationTypeStore } from "@/stores/violationTypeStore";
import { useDisciplinaryMeasureStore } from "@/stores/disciplinaryMeasureStore";

import Create from "./Create.vue";
import Edit from "./Edit.vue";
import Heading from "@/components/Heading.vue";
import Accordion from "@/components/Accordion.vue";
import ViolationItem from "./components/ViolationItem.vue";

export default {
    async setup() {
        const violationStore = useViolationStore();
        const violationTypeStore = useViolationTypeStore();
        const disciplinaryMeasureStore = useDisciplinaryMeasureStore();

        await disciplinaryMeasureStore.getDisciplinaryMeasures();
        await violationTypeStore.getViolationTypes({
            includeViolations: true,
        });

        const { form, loading, errors } = storeToRefs(violationStore);
        const { violationTypes } = storeToRefs(violationTypeStore);
        const { disciplinaryMeasures } = storeToRefs(disciplinaryMeasureStore);

        return {
            violationStore,
            violationTypes,
            disciplinaryMeasures,
            form,
            loading,
            errors,
        };
    },
    components: { Create, Edit, Heading, Accordion, ViolationItem },
    data() {
        return {
            showForm: false,
            isEditing: false,
            dialog: {
                state: false,
                component: null,
                props: {},
            },
        };
    },

    methods: {
        handleAddViolation(violationType) {
            this.dialog = {
                state: true,
                component: "Create",
                props: {
                    violationType,
                    disciplinaryMeasures: this.disciplinaryMeasures,
                },
            };
        },
    },
};
</script>

<style scoped></style>
