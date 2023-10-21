<template>
    <v-card>
        <v-toolbar color="accent-light">
            <v-toolbar-title
                ><Heading icon="mdi-chart-bar"
                    >Violations Report</Heading
                ></v-toolbar-title
            >
            <v-btn @click="$emit('close')" icon="mdi-close"></v-btn>
        </v-toolbar>

        <v-card-text>
            <v-list>
                <v-list-item subtitle="Violation Type:">
                    {{ violationType.violation_type }}
                </v-list-item>
                <v-list-item subtitle="Violation Description:">
                    {{ violation.description }}
                </v-list-item>
            </v-list>
            <v-table fixed-header height="500">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Disciplinary Action</th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="employee in employees" :key="employee.id">
                        <td>{{ employee.full_name }}</td>
                        <td>
                            <v-chip>{{
                                getEmployeeDisciplinaryAction(
                                    employee.id,
                                    violation.id,
                                    1
                                )
                            }}</v-chip>
                        </td>
                        <!-- <td>
                            <v-btn
                                flat
                                color="red"
                                class="text-caption"
                                size="small"
                                prepend-icon="mdi-check"
                                >Effective Immediately</v-btn
                            >
                        </td> -->
                    </tr>
                </tbody>
            </v-table>
            <div class="d-flex justify-space-between align-end">
                <router-link
                    class="text-primary text-overline"
                    style="text-decoration: underline"
                    prepend-icon="mdi-link"
                    :to="{ name: 'pendingViolation' }"
                    >Go to Pending Violations</router-link
                >
                <!-- <v-btn
                    flat
                    color="red"
                    class="text-caption"
                    prepend-icon="mdi-check-all"
                    size="small"
                    >Effective Immediately (all)</v-btn
                > -->
            </div>
        </v-card-text>
    </v-card>
</template>

<script>
import { useEmployeeViolationStore } from "@/stores/employeeViolationStore";
import { useViolationStore } from "@/stores/ViolationStore";
import { storeToRefs } from "pinia";

import Heading from "@/components/Heading.vue";
export default {
    async setup() {
        const employeeViolationStore = useEmployeeViolationStore();
        const { getEmployeeDisciplinaryAction, getEmployeeViolationAttempts } =
            storeToRefs(employeeViolationStore);
        const violationStore = useViolationStore();
        await violationStore.getViolations();

        return {
            getEmployeeDisciplinaryAction,
            getEmployeeViolationAttempts,
        };
    },
    components: { Heading },
    props: {
        violation: Object,
        violationType: Object,
        employees: Array,
    },
};
</script>

<style scoped></style>
