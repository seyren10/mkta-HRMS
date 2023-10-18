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
            <v-table>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Disciplinary Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="employee in employees" :key="employee.id">
                        <td>{{ employee.full_name }}</td>
                        <td>
                            <v-chip>{{
                                getDisciplinaryAction(employee.id)
                            }}</v-chip>
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </v-card-text>
    </v-card>
</template>

<script>
import { useEmployeeStore } from "@/stores/employeeStore";
import { useEmployeeViolationStore } from "@/stores/employeeViolationStore";

import { storeToRefs } from "pinia";

import Heading from "@/components/Heading.vue";
export default {
    async setup() {
        const employeeStore = useEmployeeStore();
        const employeeViolationStore = useEmployeeViolationStore();
        await employeeViolationStore.getEmployeeViolations({
            includeEmployee: true,
        });

        const { getViolationAttemptsByEmployeeId } = storeToRefs(employeeStore);
        const { employeeViolations, loading } = storeToRefs(
            employeeViolationStore
        );
        return {
            getViolationAttemptsByEmployeeId,
            employeeViolations,
        };
    },
    components: { Heading },
    props: {
        violation: Object,
        violationType: Object,
        employees: Array,
    },
    methods: {
        getDisciplinaryAction(id) {
            const count = this.getViolationAttemptsByEmployeeId(id);

            return this.employeeViolations
                .find((el) => {
                    return el.employee.id === id;
                })
                ?.violation.disciplinaryActions.find(
                    (a) => a.offense_no === count
                ).disciplinaryMeasure.title;
        },
    },
};
</script>

<style scoped></style>
