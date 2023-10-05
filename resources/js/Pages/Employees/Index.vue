<template>
    <div>
        <Heading icon="mdi-account-group-outline">Employees</Heading>
        <v-btn
            prepend-icon="mdi-plus"
            class="text-none mb-3"
            size="small"
            color="primary"
            @click="dialog.isOpen = true"
            >Add Employee
        </v-btn>
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search employee"
            density="compact"
            variant="underlined"
        />
        <VDataTable
            :headers="headers"
            :items="employees"
            :search="search"
            style="font-size: 0.8rem"
        >
            <template #item="{ item }">
                <router-link
                    :to="`employee/${item.raw.id}/show`"
                    class="data-table-row"
                    role="row"
                >
                    <!-- <tr> -->
                    <td>{{ item.raw.employee_id }}</td>
                    <td>{{ item.raw.full_name }}</td>
                    <td>{{ item.raw.department.title }}</td>
                    <td>{{ item.raw.department.division }}</td>
                    <td>{{ item.raw.position }}</td>
                    <td>{{ item.raw.hired_date }}</td>
                    <td>
                        <v-chip
                            :color="item.selectable.is_active ? 'green' : 'red'"
                            size="small"
                            >{{ item.selectable.status }}</v-chip
                        >
                    </td>
                    <!-- </tr> -->
                </router-link>
            </template>
        </VDataTable>

        <v-dialog
            v-model="dialog.isOpen"
            persistent
            transition="dialog-bottom-transition"
            style="max-width: 50rem"
        >
            <Create @close="dialog.isOpen = false" :departments="departments" />
        </v-dialog>
    </div>
</template>

<script>
import { VDataTable } from "vuetify/lib/labs/components.mjs";
import { useEmployeeStore } from "@/stores/employeeStore";
import { useDepartmentStore } from "@/stores/departmentStore";
import Create from "./Create.vue";
import Edit from "./Edit.vue";
import Heading from "@/components/Heading.vue";
import { storeToRefs } from "pinia";
export default {
    async setup() {
        const employeeStore = useEmployeeStore();
        const departmentStore = useDepartmentStore();
        await employeeStore.getEmployees();
        const { employees, form, loading, errors } = storeToRefs(employeeStore);
        const { departments } = storeToRefs(departmentStore);
        return {
            employeeStore,
            employees,
            departments,
            form,
            loading,
            errors,
        };
    },
    components: { VDataTable, Create, Edit, Heading },
    data() {
        return {
            search: "",
            headers: [
                { title: "Employee ID", key: "employee_id" },
                { title: "Full Name", key: "full_name" },
                { title: "Department", key: "department.title" },
                { title: "Division", key: "department.division" },
                { title: "Position", key: "position" },
                { title: "Date Hired", key: "hired_date" },
                { title: "Status", key: "status" },
            ],
            dialog: {
                isOpen: false,
            },
        };
    },
};
</script>
