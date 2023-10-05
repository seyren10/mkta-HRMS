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

        <v-expansion-panels variant="popout" class="mt-3">
            <v-expansion-panel
                v-for="violationType in violationTypes"
                :key="violationType.id"
                :title="violationType.violation_type"
            >
                <v-expansion-panel-text>
                    <v-btn
                        prepend-icon="mdi-plus"
                        block
                        flat
                        color="secondary"
                        @click="handleAddViolation(violationType)"
                        >add violation</v-btn
                    >
                    <div class="row">
                        <v-card
                            v-for="violation in violationType.violations"
                            class="my-2 border"
                            flat
                        >
                            <v-card-text class="d-grid list-item">
                                <v-btn
                                    position="absolute"
                                    style="right: 0; top: 0"
                                    icon="mdi-pencil-outline"
                                    flat
                                    size="small"
                                    class="text-primary edit"
                                    @click="
                                        handleEditViolation(
                                            violation.id,
                                            violationType
                                        )
                                    "
                                ></v-btn>
                                <p class="text-caption">
                                    <strong>Description:</strong>
                                    {{ violation.description }}
                                </p>
                                <div
                                    class="text-caption chip text-primary bg-accent-light"
                                >
                                    Steps/Action Length:
                                    {{ violation.action_length }}
                                </div>
                            </v-card-text>
                        </v-card>
                    </div>
                </v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>
        <v-dialog v-model="dialog.state" width="500" persistent>
            <template v-slot:default="{ isActive }">
                <component
                    :is="dialog.component"
                    v-bind="dialog.props"
                    @close="isActive.value = !isActive.value"
                ></component>
            </template>
        </v-dialog>
    </section>
</template>

<script>
import { storeToRefs } from "pinia";
import { useViolationStore } from "@/stores/violationStore";
import { useViolationTypeStore } from "@/stores/violationTypeStore";

import Create from "./Create.vue";
import Edit from "./Edit.vue";
import Heading from "@/components/Heading.vue";
export default {
    async setup() {
        const violationStore = useViolationStore();
        const violationTypeStore = useViolationTypeStore();
        await violationTypeStore.getViolationTypes();

        const { form, loading, errors } = storeToRefs(violationStore);
        const { violationTypes } = storeToRefs(violationTypeStore);

        return {
            violationTypes,
            form,
            loading,
            errors,
        };
    },
    components: { Create, Edit, Heading },
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
                },
            };
        },
        handleEditViolation(violationId, violationType) {
            this.dialog = {
                state: true,
                component: "Edit",
                props: {
                    violationId,
                    violationType,
                },
            };
        },
    },
};
</script>

<style scoped>
.edit {
    display: none !important;

    @media screen and (max-width: 40em) {
        display: block !important;
    }
}
.list-item:hover .edit {
    display: block !important;
}
</style>
