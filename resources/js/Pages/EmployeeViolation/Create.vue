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
                        :items="activeEmployees"
                        :search="search"
                        return-object
                        show-select
                        style="font-size: 0.8rem"
                        density="compact"
                    >
                        <template v-slot:item.data-table-select="{ item }">
                            <v-checkbox
                                v-if="
                                    !hasPendingViolation(
                                        item.value.id,
                                        this.form.violation_id
                                    )
                                "
                                v-model="selected"
                                :value="item.value"
                                hide-details
                                style="font-size: 0.8rem; margin-left: 0.3rem"
                                color="primary"
                                density="compact"
                            />
                        </template>
                        <template #item.attempts="{ item }">
                            <NumericChip
                                :number="
                                    getEmployeeViolationAttempts(
                                        item.value.id,
                                        this.form.violation_id
                                    )
                                "
                                size="small"
                            />
                        </template>
                        <template #item.pendingViolation="{ item }">
                            <v-chip
                                size="small"
                                class="text-caption"
                                color="secondary"
                                v-if="
                                    hasPendingViolation(
                                        item.value.id,
                                        this.form.violation_id
                                    )
                                "
                            >
                                Has Pending Violation
                            </v-chip>
                        </template>
                    </VDataTable>
                </section>
                <div class="bg-accent-light rounded pa-2 d-flex flex-column">
                    <Heading icon="mdi-check-all">Selected Employee(s)</Heading>
                    <VDataTable
                        :headers="headers"
                        :items="filteredSelected"
                        return-object
                        style="font-size: 0.8rem"
                        density="compact"
                    >
                        <template #column.attempts="props">
                            <v-icon
                                @click="
                                    selected = [];
                                    confirm = false;
                                "
                                >mdi-close-circle-multiple-outline</v-icon
                            >
                        </template>
                        <template #item.attempts="{ item }">
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
            :employees="filteredSelected"
        />
    </v-dialog>
</template>

<script>
import { useEmployeeViolationStore } from "@/stores/employeeViolationStore";
import { usePendingViolationStore } from "@/stores/pendingViolationStore";
import { storeToRefs } from "pinia";

import Heading from "@/components/Heading.vue";
import { VDataTable } from "vuetify/lib/labs/components.mjs";
import Report from "./components/Report.vue";
import NumericChip from "@/components/NumericChip.vue";

export default {
    async setup() {
        const pendingViolationStore = usePendingViolationStore();
        await pendingViolationStore.getPendingViolations();
        const employeeViolationStore = useEmployeeViolationStore();

        const { form, errors, loading, pendingViolations } = storeToRefs(
            pendingViolationStore
        );
        const { getEmployeeViolationAttempts } = storeToRefs(
            employeeViolationStore
        );

        return {
            pendingViolationStore,
            pendingViolations,
            getEmployeeViolationAttempts,
            form,
            errors,
            loading,
        };
    },
    props: {
        employees: Array,
        violationTypes: Array,
    },
    components: { Heading, VDataTable, Report, NumericChip },
    emits: ["close"],
    data() {
        return {
            violationType: null,
            selected: [],

            headers: [
                { title: "Employee ID", key: "employee_id" },
                { title: "Full Name", key: "full_name" },
                { title: "Department", key: "department.title" },
                { title: "Attempts", key: "attempts" },
                { title: "", key: "pendingViolation" },
            ],
            search: "",
            confirm: false,
            dialog: {
                open: false,
            },
        };
    },
    methods: {
        deleteSelected(selected) {
            this.selected = this.selected.filter((el) => el.id !== selected.id);
        },

        async create() {
            if (this.confirm) {
                //add
                await this.pendingViolationStore.addPendingViolation();

                if (!Object.keys(this.errors).length) {
                    this.dialog.open = true;
                }
            }

            //confirm first
            this.confirm = !this.confirm;
        },
        hasPendingViolation(employeeId, violationId) {
            return this.pendingViolations.find(
                (el) =>
                    el.employee.id === employeeId &&
                    el.violation.id === violationId
            )
                ? true
                : false;
        },
    },
    computed: {
        violations() {
            return this.violationTypes?.find(
                (vT) => vT.id === this.violationType
            )?.violations;
        },
        activeEmployees() {
            return this.employees.filter((e) => e.status === "active");
        },
        filteredSelected() {
            return this.selected.filter((a) => {
                return !this.pendingViolations.find((b) => {
                    return (
                        b.employee.id === a.id &&
                        b.violation.id === this.form.violation_id
                    );
                });
            });
        },
    },
    watch: {
        filteredSelected(newVal, oldVal) {
            this.form.employee_id = this.filteredSelected.map((el) => {
                return el.id;
            });
        },
    },
    unmounted() {
        this.pendingViolationStore.clearForm();
    },
};
</script>

<style scoped></style>
