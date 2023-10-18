<template>
    <v-toolbar
        ><v-toolbar-title
            ><Heading icon="mdi-alert-octagon-outline"
                >Employee Violations</Heading
            ></v-toolbar-title
        ></v-toolbar
    >
    <v-sheet>
        <div class="pa-3">
            <v-btn
                color="primary"
                size="small"
                prepend-icon="mdi-plus"
                class="text-none"
                flat
                @click="dialog.open = true"
                >Assign Violation
            </v-btn>

            <Accordion :items="violationTypes">
                <template v-slot:title="{ item }">
                    <span>{{ item.violation_type }}</span>
                    <v-badge
                        class="ml-4"
                        v-if="violationPerType(item).length"
                        color="red"
                        :content="violationPerType(item).length"
                    ></v-badge>
                </template>

                <template v-slot="{ item }">
                    <div class="d-grid align-start col-4" style="gap: 1rem">
                        <ShowableContent
                            style="flex-basis: 20rem"
                            v-for="violation in violationPerType(item)"
                            v-if="violationPerType(item).length"
                        >
                            <strong>Description: </strong
                            >{{ violation.description }}

                            <template #showable>
                                <v-table fixed-header height="400">
                                    <thead>
                                        <tr>
                                            <th>Employees</th>
                                            <th>Attempts</th>
                                            <th>Disciplinary Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="employee in employeeWithViolation(
                                                violation
                                            )"
                                        >
                                            <td>
                                                <router-link
                                                    :to="{
                                                        name: 'employeeShow',
                                                        params: {
                                                            id: employee.id,
                                                        },
                                                    }"
                                                    target="_blank"
                                                    class="text-primary"
                                                    >{{
                                                        employee.full_name
                                                    }}</router-link
                                                >
                                            </td>
                                            <td>
                                                <v-chip
                                                    size="small"
                                                    color="red"
                                                    prepend-icon="mdi-arrow-down"
                                                    >{{
                                                        getViolationAttempts(
                                                            employee.id,
                                                            violation.id
                                                        )
                                                    }}</v-chip
                                                >
                                            </td>
                                            <td>
                                                <v-chip size="small">{{
                                                    getDisciplinaryAction(
                                                        employee.id,
                                                        violation.id
                                                    )
                                                }}</v-chip>
                                            </td>
                                        </tr>
                                    </tbody>
                                </v-table>
                            </template>
                        </ShowableContent>
                        <div v-else>No Content Available</div>
                    </div>
                </template>
            </Accordion>
        </div>
    </v-sheet>
    <v-dialog
        fullscreen
        transition="dialog-bottom-transition"
        persistent
        v-model="dialog.open"
    >
        <Create
            :employees="employees"
            :violation-types="violationTypes"
            @close="dialog.open = false"
        />
    </v-dialog>
</template>

<script>
import { useViolationTypeStore } from "@/stores/violationTypeStore";
import { useEmployeeStore } from "@/stores/employeeStore";
import { useEmployeeViolationStore } from "@/stores/employeeViolationStore";

import { storeToRefs } from "pinia";

import Heading from "@/components/Heading.vue";
import Accordion from "@/components/Accordion.vue";
import Create from "./Create.vue";
import ShowableContent from "@/components/ShowableContent.vue";

export default {
    async setup() {
        const violationTypeStore = useViolationTypeStore();
        const employeeStore = useEmployeeStore();
        const employeeViolationStore = useEmployeeViolationStore();

        await violationTypeStore.getViolationTypes({ includeViolations: true });
        await employeeStore.getEmployees({ includeEmployeeViolations: true });
        await employeeViolationStore.getEmployeeViolations({
            includeEmployee: true,
        });

        const { violationTypes } = storeToRefs(violationTypeStore);
        const { employees, getViolationAttempts } = storeToRefs(employeeStore);
        const { employeeViolations, getDisciplinaryAction } = storeToRefs(
            employeeViolationStore
        );

        return {
            violationTypes,
            employees,
            getViolationAttempts,
            getDisciplinaryAction,
            employeeStore,
            employeeViolations,
        };
    },
    data() {
        return {
            dialog: {
                open: false,
            },
        };
    },
    computed: {
        employeeViolationsOnly() {
            return this.employeeViolations.map((a) => a.violation);
        },
    },
    methods: {
        violationPerType(type) {
            return type.violations.filter((el) => {
                return this.employeeViolationsOnly.find((e) => e.id === el.id);
            });
        },
        employeeWithViolation(violation) {
            return this.employeeViolations
                .filter((e) => e.violation.id === violation.id)
                .map((e) => e.employee)
                .reduce((acc, e) => {
                    if (!acc.find((a) => a.id === e.id)) {
                        acc.push(e);
                    }
                    return acc;
                }, []);
        },
    },

    components: { Heading, Accordion, Create, ShowableContent },
};
</script>

<style scoped></style>
