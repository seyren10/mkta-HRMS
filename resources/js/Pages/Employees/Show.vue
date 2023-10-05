<template>
    <div class="mt-2">
        <v-sheet>
            <div class="row">
                <v-list>
                    <v-list-item>
                        <v-list-item-title
                            ><v-text-field
                                variant="underlined"
                                density="compact"
                                :readonly="!isEditing"
                                hide-details
                                v-model="editForm.first_name"
                            ></v-text-field
                        ></v-list-item-title>
                        <v-list-item-subtitle>First Name</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title
                            ><v-text-field
                                variant="underlined"
                                density="compact"
                                :readonly="!isEditing"
                                hide-details
                                v-model="editForm.last_name"
                            ></v-text-field
                        ></v-list-item-title>
                        <v-list-item-subtitle>Last Name</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title
                            ><v-text-field
                                variant="underlined"
                                density="compact"
                                :readonly="!isEditing"
                                hide-details
                                v-model="editForm.employee_id"
                            ></v-text-field
                        ></v-list-item-title>
                        <v-list-item-subtitle>Employee ID</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title
                            ><v-select
                                variant="underlined"
                                density="compact"
                                :readonly="!isEditing"
                                :items="
                                    departments.map((d) => {
                                        return {
                                            title: d.title,
                                            value: d.id,
                                        };
                                    })
                                "
                                hide-details
                                v-model="editForm.department_id"
                            ></v-select
                        ></v-list-item-title>
                        <v-list-item-subtitle>Department</v-list-item-subtitle>
                    </v-list-item>
                </v-list>
                <v-list>
                    <v-list-item>
                        <v-list-item-title
                            ><v-text-field
                                variant="underlined"
                                density="compact"
                                readonly
                                hide-details
                                v-model="editForm.department.division"
                            ></v-text-field
                        ></v-list-item-title>
                        <v-list-item-subtitle
                            >Division
                            <em style="font-size: 0.7rem"
                                >(data changes from department may not get
                                reflected to this field immediately)
                            </em></v-list-item-subtitle
                        >
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title
                            ><v-text-field
                                variant="underlined"
                                density="compact"
                                :readonly="!isEditing"
                                hide-details
                                v-model="editForm.position"
                            ></v-text-field
                        ></v-list-item-title>
                        <v-list-item-subtitle>Position</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title
                            ><v-text-field
                                type="date"
                                variant="underlined"
                                density="compact"
                                :readonly="!isEditing"
                                hide-details
                                v-model="editForm.hired_date"
                            ></v-text-field
                        ></v-list-item-title>
                        <v-list-item-subtitle>Date Hired</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title
                            ><v-switch
                                variant="underlined"
                                density="compact"
                                :readonly="!isEditing"
                                color="green"
                                hide-details
                                v-model="editForm.is_active"
                                :label="
                                    editForm.is_active ? 'Active' : 'Inactive'
                                "
                            ></v-switch
                        ></v-list-item-title>
                        <v-list-item-subtitle>Status </v-list-item-subtitle>
                    </v-list-item>
                </v-list>
            </div>
            <div class="d-flex justify-end pa-3" style="gap: 1rem">
                <v-btn
                    elevation="0"
                    prepend-icon="mdi-content-save-outline"
                    color="primary"
                    class="text-none"
                    v-if="isEditing"
                    :loading="loading"
                    @click="update"
                    >Save</v-btn
                >
                <v-btn
                    elevation="0"
                    :prepend-icon="
                        isEditing ? 'mdi-close' : 'mdi-pencil-outline'
                    "
                    color="primary"
                    class="text-none"
                    :variant="isEditing ? 'outlined' : 'flat'"
                    @click="isEditing = !isEditing"
                    >{{ isEditing ? "Cancel" : "Edit" }}</v-btn
                >
            </div>
        </v-sheet>
    </div>
</template>

<script>
import { useDepartmentStore } from "@/stores/departmentStore";
import { useEmployeeStore } from "@/stores/employeeStore";
import { storeToRefs } from "pinia";

import { useRoute } from "vue-router";

import Heading from "@/components/Heading.vue";
export default {
    async setup() {
        const route = useRoute();
        const departmentStore = useDepartmentStore();
        await departmentStore.getDepartments();

        const employeeStore = useEmployeeStore();
        await employeeStore.getEmployee(route.params.id);

        const { departments } = storeToRefs(departmentStore);
        const { employee, loading } = storeToRefs(employeeStore);

        return {
            departments,
            employeeStore,
            employee,
            loading,
        };
    },
    components: { Heading },
    data() {
        return {
            isEditing: false,
            editForm: {
                ...this.employee,
                department_id: this.employee.department.id,
            },
        };
    },
    watch: {
        isEditing(newValue, oldValue) {
            if (oldValue) {
                this.resetEditForm();
            }
        },
    },
    methods: {
        resetEditForm() {
            this.editForm = {
                ...this.employee,
                department_id: this.employee.department.id,
            };
        },
        async update() {
            await this.employeeStore.updateEmployee(this.editForm);
            this.isEditing = false;
        },
    },
};
</script>

<style scoped></style>
