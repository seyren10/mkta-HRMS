<template>
    <v-toolbar>
        <v-toolbar-title>
            <Heading icon="mdi-account-clock-outline"
                >Pending Violations</Heading
            ></v-toolbar-title
        >
    </v-toolbar>
    <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search employee"
        density="compact"
        variant="underlined"
        clearable
    />

    <VDataTable
        v-model="selected"
        :headers="headers"
        :items="pendingViolations"
        :search="search"
        return-object
        show-select
        style="font-size: 0.8rem"
        density="compact"
        :loading="loading"
    >
        <template #item.violation.description="{ item }">
            {{ `${item.value.violation.description.substring(0, 80)}...` }}
        </template>
        <template #item.attempts="{ item }">
            <v-chip size="small">{{
                getOrdinal(
                    getEmployeeViolationAttempts(
                        item.value.employee.id,
                        item.value.violation.id,
                        1
                    )
                )
            }}</v-chip>
        </template>
        <template #item.disciplinaryAction="{ item }">
            <v-chip size="small" color="red">
                {{
                    getEmployeeDisciplinaryAction(
                        item.value.employee.id,
                        item.value.violation.id,
                        1
                    )
                }}</v-chip
            >
        </template>
        <template #item.document>
            <v-btn
                class="text-none text-caption"
                flat
                color="primary"
                density="compact"
                prepend-icon="mdi-file-outline"
                >Download
            </v-btn>
        </template>
        <template #item.actions="{ item }">
            <v-menu location="start">
                <template #activator="{ props }">
                    <v-btn
                        v-bind="props"
                        icon="mdi-dots-vertical"
                        flat
                        density="compact"
                        size="small"
                    ></v-btn>
                </template>

                <v-sheet class="d-flex flex-column pa-2" elevation="1">
                    <v-btn
                        prepend-icon="mdi-check"
                        class="text-caption text-green-lighten-3"
                        flat
                        @click="
                            handleAccept({
                                id: item.value.id,
                                employee_id: item.value.employee.id,
                                violation_id: item.value.violation.id,
                            })
                        "
                        >Accept</v-btn
                    >
                    <v-divider></v-divider>

                    <v-btn
                        prepend-icon="mdi-close"
                        class="text-caption text-red-lighten-3"
                        flat
                        @click="
                            handleReject({
                                id: item.value.id,
                                employee_id: item.value.employee.id,
                                violation_id: item.value.violation.id,
                            })
                        "
                        >Reject</v-btn
                    >
                </v-sheet>
            </v-menu>
        </template>
    </VDataTable>
    <section class="mt-3 d-flex gap-2" v-if="selected.length">
        <v-btn
            class="text-none text-caption"
            prepend-icon="mdi-check-all"
            flat
            color="green"
            @click="destroyMany()"
            >Accept all</v-btn
        >
        <v-btn
            class="text-none text-caption"
            prepend-icon="mdi-close"
            flat
            color="red"
            @click="transferToEmployeeViolation()"
            >Reject all</v-btn
        >
        <v-btn
            class="text-none text-caption"
            prepend-icon="mdi-close-circle-multiple-outline"
            variant="outlined"
            @click="selected = []"
            >Cancel Selection</v-btn
        >
    </section>
</template>

<script>
import { usePendingViolationStore } from "@/stores/PendingViolationStore";
import { useEmployeeViolationStore } from "@/stores/EmployeeViolationStore";
import { useViolationStore } from "@/stores/ViolationStore";
import { storeToRefs } from "pinia";
import { useUtils } from "@/composables/useUtils";

import Heading from "@/components/Heading.vue";
import { VDataTable } from "vuetify/lib/labs/components.mjs";

export default {
    async setup() {
        const pendingViolationStore = usePendingViolationStore();
        await pendingViolationStore.getPendingViolations({
            includeViolationType: true,
        });
        const { pendingViolations } = storeToRefs(pendingViolationStore);

        const violationStore = useViolationStore();
        await violationStore.getViolations(); //for get

        const employeeViolationStore = useEmployeeViolationStore();
        await employeeViolationStore.getEmployeeViolations({
            includeEmployee: true,
        });

        const {
            getEmployeeDisciplinaryAction,
            getEmployeeViolationAttempts,
            form,
            loading,
        } = storeToRefs(employeeViolationStore);

        const { getOrdinal } = useUtils();

        return {
            getEmployeeDisciplinaryAction,
            getEmployeeViolationAttempts,
            getOrdinal,
            pendingViolationStore,
            pendingViolations,
            employeeViolationStore,
            form,
            loading,
        };
    },
    components: { Heading, VDataTable },
    data() {
        return {
            selected: [],
            headers: [
                { title: "Employees", key: "employee.full_name" },
                {
                    title: "Violation Type",
                    key: "violation.violationType.violation_type",
                },
                { title: "Description", key: "violation.description" },
                { title: "Attempts", key: "attempts" },
                { title: "Disciplinary Action", key: "disciplinaryAction" },
                { title: "Document", key: "document" },
                { title: "", key: "actions", sortable: false },
            ],
            search: "",
        };
    },
    methods: {
        handleAccept(item) {
            this.selected = [];
            this.destroy(item.id);
        },
        handleReject(item) {
            this.form = [];
            const employeeViolation = {
                id: item.id,
                employee_id: item.employee_id,
                violation_id: item.violation_id,
            };

            this.form.push(employeeViolation);

            this.transferToEmployeeViolation();
        },
        async destroy(id) {
            //argument accepts an array of object with id
            await this.pendingViolationStore.deletePendingViolations([{ id }]);
        },
        async destroyMany() {
            await this.pendingViolationStore.deletePendingViolations(this.form);
            this.selected = [];
        },
        async transferToEmployeeViolation() {
            await this.employeeViolationStore.addEmployeeViolation();
            this.selected = [];
        },
    },
    computed: {},
    watch: {
        selected(newVal, oldVal) {
            this.form = this.selected.map((el) => {
                return {
                    id: el.id,
                    employee_id: el.employee.id,
                    violation_id: el.violation.id,
                };
            });
        },
    },
};
</script>

<style scoped></style>
