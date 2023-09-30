<template>
    <section>
        <v-btn
            block
            prepend-icon="mdi-plus"
            variant="flat"
            color="secondary"
            @click="showForm = true"
            v-if="!showForm"
            >add offense type</v-btn
        >
        <v-form
            class="form-single"
            @submit.prevent="isEditing ? update() : create()"
            v-if="showForm"
        >
            <v-text-field
                v-model="form.offense_type"
                variant="underlined"
                density="compact"
                label="Type"
                :error="errors?.offense_type ? true : false"
                :error-messages="errors?.offense_type"
                :loading="loading"
            ></v-text-field>
            <v-text-field
                v-model="form.offense_length"
                variant="underlined"
                density="compact"
                label="Offense Length (default is 5)"
                :error="errors?.offense_length ? true : false"
                :error-messages="errors?.offense_length"
                :loading="loading"
            ></v-text-field>
            <v-btn
                type="submit"
                variant="flat"
                :icon="isEditing ? 'mdi-check' : 'mdi-plus'"
                color="primary"
                rounded="0"
                density="compact"
                :loading="loading"
            />
            <v-btn
                variant="outlined"
                icon="mdi-close"
                color="primary"
                rounded="0"
                density="compact"
                @click="closeForm"
            />
        </v-form>
        <ul class="list mt-4">
            <li class="list-item" v-for="nte in ntes" :key="nte.id">
                <div class="list-item__content">
                    <div>{{ nte.offense_type }}</div>
                    <v-chip color="red" class="stages"
                        >Stages: {{ nte.offense_length }}</v-chip
                    >
                </div>
                <v-icon class="edit" @click="handleEdit(nte)"
                    >mdi-pencil-outline</v-icon
                >
            </li>
        </ul>
    </section>
</template>

<script>
import { useEmployeeNteStore } from "@/stores/employeeNteStore";
import { storeToRefs } from "pinia";
export default {
    async setup() {
        const employeeNteStore = useEmployeeNteStore();
        await employeeNteStore.getNtes();

        const { ntes, form, errors, loading } = storeToRefs(employeeNteStore);

        return {
            ntes,
            employeeNteStore,
            form,
            errors,
            loading,
        };
    },
    data() {
        return {
            showForm: false,
            isEditing: false,
        };
    },
    methods: {
        async create() {
            await this.employeeNteStore.addNte();
            if (!Object.keys(this.errors).length) this.closeForm();
        },
        async update() {
            await this.employeeNteStore.updateNte();

            if (!Object.keys(this.errors).length) this.closeForm();
        },
        handleEdit(data) {
            this.employeeNteStore.setForm(data);
            this.isEditing = true;
            this.showForm = true;
        },
        closeForm() {
            this.isEditing = false;
            this.showForm = false;
            this.employeeNteStore.clearForm();
        },
    },
};
</script>

<style scoped>
.form-single {
    display: flex;
    align-items: center;
    gap: 1rem;
}
section {
    width: 90%;
    margin-inline: auto;

    @media screen and (min-width: 40em) {
        width: 60%;
    }
}

.list {
    display: grid;
    grid-template-columns: repeat(1fr);
    gap: 0.8rem;

    @media (min-width: 40rem) {
        grid-template-columns: repeat(2, 1fr);
    }
}

.list-item {
    background-color: #e3f2fd;
    border-radius: 0.3em;
    padding: 1rem;
    color: #42a5f5;
    display: flex;
    justify-content: space-between;
}

.list-item__content {
    display: grid;

    .stages {
        align-self: end;
    }
}
.edit {
    display: none !important;

    @media screen and (max-width: 40em) {
        display: block !important;
    }
}
.list-item:hover .edit {
    display: block !important;
}
</style>
