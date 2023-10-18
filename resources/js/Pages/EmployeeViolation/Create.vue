<template>
    <v-card>
        <v-toolbar color="accent-light">
            <v-toolbar-title
                ><Heading icon="mdi-account-alert-outline"
                    >Assign Violation</Heading
                ></v-toolbar-title
            >
            <v-btn @click="$emit('close')" icon="mdi-close"></v-btn>
        </v-toolbar>
        <v-card-text>
            <div class="row">
                <section>
                    <div class="mb-4">
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
                            @update:modelValue="form.violation_id = null"
                        ></v-select>
                        <v-autocomplete
                            v-model="form.violation_id"
                            variant="underlined"
                            density="comfortable"
                            label="Offense Description"
                            prepend-icon="mdi-text"
                            :items="violations"
                            item-title="description"
                            item-value="id"
                            clearable
                            :error="errors?.violaton_id ? true : false"
                            :error-messages="errors?.violation_id"
                        ></v-autocomplete>
                    </div>
                    <Heading icon="mdi-check-all">Select Employee(s)</Heading>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search employee"
                        density="compact"
                        variant="underlined"
                    />
                    <VDataTable
                        v-model="selected"
                        :headers="headers"
                        :items="employees"
                        :search="search"
                        return-object
                        show-select
                        style="font-size: 0.8rem"
                        density="compact"
                    >
                        <template #item.violationCount="{ item }">
                            <v-chip
                                :prepend-icon="
                                    getViolationAttemptsByEmployeeId(
                                        item.value.id
                                    ) > 0
                                        ? 'mdi-arrow-down'
                                        : 'mdi-minus'
                                "
                                :color="
                                    getViolationAttemptsByEmployeeId(
                                        item.value.id
                                    ) > 0
                                        ? 'red'
                                        : 'green'
                                "
                                size="small"
                                >{{
                                    getViolationAttemptsByEmployeeId(
                                        item.value.id
                                    )
                                }}</v-chip
                            >
                        </template>
                    </VDataTable>
                </section>
                <div class="bg-accent-light rounded pa-2 d-flex flex-column">
                    <Heading icon="mdi-check-all">Selected Employee(s)</Heading>
                    <VDataTable
                        :headers="headers"
                        :items="selected"
                        :search="search"
                        return-object
                        style="font-size: 0.8rem"
                        density="compact"
                    >
                        <template #column.violationCount="props">
                            <v-icon
                                @click="
                                    selected = [];
                                    confirm = false;
                                "
                                >mdi-close-circle-multiple-outline</v-icon
                            >
                        </template>
                        <template #item.violationCount="{ item }">
                            <v-icon @click="deleteSelected(item.value)"
                                >mdi-close-circle-outline</v-icon
                            >
                        </template>
                    </VDataTable>
                    <div
                        class="mt-4 align-self-start mt-auto"
                        v-if="selected.length"
                    >
                        <v-btn
                            flat
                            class="text-none"
                            color="primary"
                            :prepend-icon="
                                !confirm
                                    ? 'mdi-account-alert-outline'
                                    : 'mdi-check'
                            "
                            @click="create"
                            :loading="loading"
                            >{{
                                !confirm
                                    ? "Assign Violation"
                                    : "Click to Confirm"
                            }}</v-btn
                        >
                        <v-btn
                            v-if="confirm"
                            @click="confirm = false"
                            class="text-none ml-2"
                            prepend-icon="mdi-cancel"
                            color="red-lighten-2"
                            flat
                            :loading="loading"
                            >Cancel</v-btn
                        >
                    </div>
                </div>
            </div>
        </v-card-text>
    </v-card>

    <v-dialog width="700" v-model="dialog.open" persistent>
        <Report
            @close="$emit('close')"
            :violation-type="
                violationTypes.find((el) => el.id === violationType)
            "
            :violation="
                violations.find((el) => el.id === this.form.violation_id)
            "
            :employees="selected"
        />
    </v-dialog>
</template>

<script>
import { useEmployeeViolationStore } from "@/stores/employeeViolationStore";
import { useEmployeeStore } from "@/stores/employeeStore";
import { storeToRefs } from "pinia";

import Heading from "@/components/Heading.vue";
import { VDataTable } from "vuetify/lib/labs/components.mjs";
import Report from "./components/Report.vue";

export default {
    async setup() {
        const employeeViolationStore = useEmployeeViolationStore();
        const employeeStore = useEmployeeStore();

        const { getViolationAttemptsByEmployeeId } = storeToRefs(employeeStore);
        const { form, errors, loading } = storeToRefs(employeeViolationStore);

        return {
            employeeStore,
            employeeViolationStore,
            getViolationAttemptsByEmployeeId,
            form,
            errors,
            loading,
        };
    },
    props: {
        employees: Array,
        violationTypes: Array,
    },
    components: { Heading, VDataTable, Report },
    emits: ["close"],
    data() {
        return {
            violationType: null,
            selected: [],

            headers: [
                { title: "Employee ID", key: "employee_id" },
                { title: "Full Name", key: "full_name" },
                { title: "Department", key: "department.title" },
                {
                    title: "Attempts",
                    key: "violationCount",
                    sortable: false,
                },
            ],
            search: "",
            confirm: false,
            dialog: {
                open: false,
            },
        };
    },
    unmounted() {
        this.employeeViolationStore.clearForm();
    },
    methods: {
        deleteSelected(selected) {
            this.selected = this.selected.filter((el) => el.id !== selected.id);
        },

        async create() {
            if (this.confirm) {
                //add

                await this.employeeViolationStore.addEmployeeViolation();

                if (!Object.keys(this.errors).length) {
                    this.dialog.open = true;
                }
            }

            //confirm first
            this.confirm = !this.confirm;
        },
    },
    computed: {
        violations() {
            return this.violationTypes?.find(
                (vT) => vT.id === this.violationType
            )?.violations;
        },
    },
    watch: {
        selected(newVal, oldVal) {
            this.form.employee_id = this.selected.map((el) => {
                return el.id;
            });
        },
    },
};
</script>

<style scoped></style>
