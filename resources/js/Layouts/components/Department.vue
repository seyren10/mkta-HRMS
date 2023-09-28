<template>
    <v-dialog width="500" persistent>
        <template v-slot:activator="{ props }">
            <v-btn icon="" v-bind="props">
                <v-icon>mdi-domain</v-icon>
                <v-tooltip location="bottom" activator="parent"
                    >Departments</v-tooltip
                >
            </v-btn>
        </template>

        <template v-slot:default="{ isActive }">
            <v-toolbar color="secondary" density="compact">
                <v-toolbar-title>Departments</v-toolbar-title>
                <v-toolbar-items>
                    <v-btn
                        :icon="showForm ? 'mdi-cancel' : 'mdi-plus'"
                        @click="handleShowForm"
                    />
                    <v-btn
                        icon="mdi-close"
                        @click="isActive.value = !isActive.value"
                    ></v-btn>
                </v-toolbar-items>
            </v-toolbar>

            <v-sheet rounded="0">
                <v-form
                    class="form"
                    style="gap: 0.8rem"
                    v-if="showForm"
                    @submit.prevent="isEditing ? update() : create()"
                >
                    <v-text-field
                        label="title*"
                        variant="underlined"
                        density="compact"
                        v-model="form.title"
                        :error="errors?.title ? true : false"
                        :error-messages="errors?.title"
                    />
                    <v-text-field
                        label="description"
                        variant="underlined"
                        density="compact"
                        v-model="form.description"
                    />
                    <v-select
                        label="division*"
                        variant="underlined"
                        density="compact"
                        :items="['production', 'office']"
                        v-model="form.division"
                        :error="errors?.division ? true : false"
                        :error-messages="errors?.division"
                    />
                    <v-btn
                        v-if="!isEditing"
                        prepend-icon="mdi-plus-outline"
                        type="submit"
                        variant="flat"
                        stacked
                        :loading="loading"
                        >Add</v-btn
                    >
                    <v-btn
                        v-else
                        prepend-icon="mdi-check-outline"
                        type="submit"
                        variant="flat"
                        stacked
                        :loading="loading"
                        >Update</v-btn
                    >
                </v-form>

                <v-table density="compact">
                    <thead>
                        <tr>
                            <th>
                                <div class="d-flex align-center">
                                    <span>Title</span>
                                    <v-icon
                                        @click="sort('title')"
                                        :icon="
                                            !sortAscending
                                                ? 'mdi-sort-ascending'
                                                : 'mdi-sort-descending'
                                        "
                                    />
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-center">
                                    <span>Division</span>
                                    <v-icon
                                        @click="sort('division')"
                                        :icon="
                                            !sortAscending
                                                ? 'mdi-sort-ascending'
                                                : 'mdi-sort-descending'
                                        "
                                    />
                                </div>
                            </th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="department in sortedDepartments"
                            :key="department.id"
                        >
                            <td>{{ department.title }}</td>
                            <td>{{ department.division }}</td>
                            <td>{{ department.description }}</td>
                            <td>
                                <v-icon
                                    icon="mdi-pencil-outline"
                                    color="accent"
                                    @click="handleEdit(department)"
                                />
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </v-sheet>
        </template>
    </v-dialog>
</template>

<script>
import { storeToRefs } from "pinia";
import { useDepartmentStore } from "@/stores/departmentStore";
export default {
    async setup() {
        const departmentStore = useDepartmentStore();
        await departmentStore.getDepartments();

        const { departments, loading, errors, form } =
            storeToRefs(departmentStore);

        return {
            form,
            departmentStore,
            departments,
            loading,
            errors,
        };
    },
    data() {
        return {
            showForm: false,
            isEditing: false,
            sortedDepartments: this.departments,
            sortAscending: true,
        };
    },
    methods: {
        create() {
            this.departmentStore.addDepartment();
        },
        async update() {
            await this.departmentStore.updateDepartment();
            this.showForm = false;
        },
        handleEdit(data) {
            this.departmentStore.setForm(data);
            this.isEditing = true;
            this.showForm = true;
        },
        handleShowForm() {
            this.showForm = !this.showForm;

            if (this.showForm) this.isEditing = false;
        },
        sort(type) {
            this.sortAscending = !this.sortAscending;

            switch (type) {
                case "title":
                    this.sortedDepartments = this.sortedDepartments.sort(
                        (a, b) => {
                            return this.sortAscending
                                ? a.title.localeCompare(b.title)
                                : b.title.localeCompare(a.title);
                        }
                    );
                    break;
                case "division":
                    this.sortedDepartments = this.sortedDepartments.sort(
                        (a, b) => {
                            return this.sortAscending
                                ? a.division.localeCompare(b.division)
                                : b.division.localeCompare(a.division);
                        }
                    );
                    break;

                default:
                    break;
            }
        },
    },
};
</script>

<style scoped>
i {
    color: #42a5f5;
}

.form {
    display: grid;
    grid-template-columns: repeat(3, 1fr) auto;
    margin-block: 1rem;
    padding-inline: 0.6rem;
}
</style>
