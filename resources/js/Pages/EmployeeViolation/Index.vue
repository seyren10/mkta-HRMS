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
            <Create
                v-slot="{ props }"
                :employees="employees"
                :violation-types="violationTypes"
                :disciplinary-measures="disciplinaryMeasures"
                ><v-btn
                    v-bind="props"
                    color="primary"
                    size="small"
                    prepend-icon="mdi-plus"
                    class="text-none"
                    flat
                    >Assign Violation
                </v-btn></Create
            >

            <Accordion
                :items="violationTypes"
                title-key="violation_type"
            ></Accordion>
        </div>
    </v-sheet>
</template>

<script>
import { useViolationTypeStore } from "@/stores/violationTypeStore";
import { useEmployeeStore } from "@/stores/employeeStore";
import { useDisciplinaryMeasureStore } from "@/stores/disciplinaryMeasureStore";

import { storeToRefs } from "pinia";

import Heading from "@/components/Heading.vue";
import Accordion from "@/components/Accordion.vue";
import Create from "./Create.vue";

export default {
    async setup() {
        const violationTypeStore = useViolationTypeStore();
        const employeeStore = useEmployeeStore();
        const disciplinaryMeasureStore = useDisciplinaryMeasureStore();

        await violationTypeStore.getViolationTypes();
        await employeeStore.getEmployees();
        await disciplinaryMeasureStore.getDisciplinaryMeasures();

        const { violationTypes } = storeToRefs(violationTypeStore);
        const { employees } = storeToRefs(employeeStore);
        const { disciplinaryMeasures } = storeToRefs(disciplinaryMeasureStore);

        return { violationTypes, employees, disciplinaryMeasures };
    },
    data() {
        return {
            dialog: {
                open: false,
                sample: "Create",
            },
        };
    },
    components: { Heading, Accordion, Create },
};
</script>

<style scoped></style>
