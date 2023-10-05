<template>
    <div>
        <v-toolbar color="primary" density="compact">
            <v-toolbar-title>Define new Violation</v-toolbar-title>
            <v-toolbar-items>
                <v-btn icon="mdi-close" @click="this.$emit('close')"></v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <v-sheet>
            <v-container>
                <v-form @submit.prevent="update">
                    <v-text-field
                        readonly
                        label="Violation Type"
                        variant="underlined"
                        density="compact"
                        :model-value="violationType.violation_type"
                        :error="errors?.violation_type ? true : false"
                        :error-messages="errors?.violation_type"
                    ></v-text-field>
                    <v-textarea
                        label="Description"
                        variant="underlined"
                        density="compact"
                        auto-grow
                        v-model="form.description"
                        :error="errors?.description ? true : false"
                        :error-messages="errors?.description"
                    ></v-textarea>
                    <v-text-field
                        type="number"
                        label="Action Length"
                        variant="underlined"
                        density="compact"
                        v-model="form.action_length"
                        :error="errors?.action_length ? true : false"
                        :error-messages="errors?.action_length"
                    ></v-text-field>
                    <v-btn
                        type="submit"
                        block
                        size="small"
                        color="primary"
                        :loading="loading"
                        >add</v-btn
                    >
                </v-form>
            </v-container>
        </v-sheet>
    </div>
</template>

<script>
import { useViolationStore } from "@/stores/violationStore";
import { useViolationTypeStore } from "@/stores/violationTypeStore";
import { storeToRefs } from "pinia";
export default {
    setup() {
        const violationStore = useViolationStore();
        const violationTypeStore = useViolationTypeStore();
        const { form, errors, loading } = storeToRefs(violationStore);

        return {
            violationTypeStore,
            violationStore,
            form,
            errors,
            loading,
        };
    },
    props: {
        violationId: Number,
        violationType: Object,
    },
    created() {
        this.violationStore.setForm({
            violation_type_id: this.violationType.id,
            ...this.violationType.violations.find(
                (v) => v.id === this.violationId
            ),
        });
    },
    methods: {
        async update() {
            await this.violationStore.updateViolation();
            await this.violationTypeStore.getViolationTypes();
            if (!Object.keys(this.errors).length) {
                this.$emit("close");
            }
        },
    },
    beforeUnmount() {
        this.violationStore.clearForm();
    },
};
</script>

<style scoped></style>
