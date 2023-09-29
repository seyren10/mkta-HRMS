<template>
    <v-card>
        <v-toolbar color="secondary" class="border-b" density="compact">
            <v-toolbar-title>Add Employee</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon="mdi-close" @click="$emit('close')"> </v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <v-container>
            <v-form @submit.prevent="create">
                <div class="row">
                    <v-text-field
                        label="Employee ID*"
                        variant="underlined"
                        density="compact"
                        v-model="form.employee_id"
                        :error="errors?.employee_id ? true : false"
                        :error-messages="errors?.employee_id"
                    ></v-text-field>
                    <v-select
                        label="Department*"
                        variant="underlined"
                        density="compact"
                        v-model="form.department_id"
                        :items="
                            departments.map((d) => {
                                return { title: d.title, value: d.id };
                            })
                        "
                        :error="errors?.department_id ? true : false"
                        :error-messages="errors?.department_id"
                    ></v-select>
                </div>
                <div class="row">
                    <v-text-field
                        label="First Name*"
                        variant="underlined"
                        density="compact"
                        v-model="form.first_name"
                        :error="errors?.first_name ? true : false"
                        :error-messages="errors?.first_name"
                    ></v-text-field>
                    <v-text-field
                        label="Last Name*"
                        variant="underlined"
                        density="compact"
                        v-model="form.last_name"
                        :error="errors?.last_name ? true : false"
                        :error-messages="errors?.last_name"
                    ></v-text-field>
                </div>
                <div class="row">
                    <v-text-field
                        label="Position"
                        variant="underlined"
                        density="compact"
                        v-model="form.position"
                    ></v-text-field>
                    <v-text-field
                        label="Date Hired*"
                        type="date"
                        variant="underlined"
                        density="compact"
                        v-model="form.hired_date"
                        :error="errors?.hired_date ? true : false"
                        :error-messages="errors?.hired_date"
                    ></v-text-field>
                </div>

                <v-btn
                    block
                    variant="flat"
                    color="blue-lighten-1"
                    type="submit"
                    :loading="loading"
                    >Create Item
                </v-btn>
            </v-form>
        </v-container>
    </v-card>
</template>

<script>
import { useEmployeeStore } from "@/stores/employeeStore";
import { storeToRefs } from "pinia";
export default {
    async setup() {
        const employeeStore = useEmployeeStore();
        const { employees, form, loading, errors } = storeToRefs(employeeStore);

        return {
            employeeStore,
            employees,
            form,
            loading,
            errors,
        };
    },
    props: {
        departments: Array,
    },
    methods: {
        async create() {
            await this.employeeStore.addEmployee();
        },
    },
};
</script>
