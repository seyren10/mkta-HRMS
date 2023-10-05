<template>
    <section>
        <h1><v-icon>mdi-format-list-checkbox</v-icon> Violation Types</h1>
        <v-btn
            class="my-4 text-none"
            prepend-icon="mdi-arrow-left"
            flat
            size="small"
            @click="$router.back()"
            color="primary"
            >Back</v-btn
        >
        <v-sheet
            rounded
            elevation="1"
            style="border-top-left-radius: 0"
            class="pa-4"
        >
            <v-btn
                block
                prepend-icon="mdi-plus"
                variant="flat"
                color="secondary"
                @click="showForm = true"
                v-if="!showForm"
                >add violation type</v-btn
            >

            <v-form
                class="form-single"
                @submit.prevent="isEditing ? update() : create()"
                v-if="showForm"
            >
                <v-text-field
                    v-model="form.violation_type"
                    variant="underlined"
                    density="compact"
                    label="Type"
                    :error="errors?.violation_type ? true : false"
                    :error-messages="errors?.violation_type"
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
                <li
                    class="list-item"
                    v-for="violationType in violationTypes"
                    :key="violationType.id"
                >
                    <div class="list-item__content">
                        <div>{{ violationType.violation_type }}</div>
                    </div>
                    <v-icon class="edit" @click="handleEdit(violationType)"
                        >mdi-pencil-outline</v-icon
                    >
                </li>
            </ul>
        </v-sheet>
    </section>
</template>

<script>
import { useViolationTypeStore } from "@/stores/violationTypeStore";
import { storeToRefs } from "pinia";
export default {
    async setup() {
        const violationTypeStore = useViolationTypeStore();
        await violationTypeStore.getViolationTypes();

        const { violationTypes, form, errors, loading } =
            storeToRefs(violationTypeStore);

        return {
            violationTypes,
            violationTypeStore,
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
            await this.violationTypeStore.addViolationType();
            if (!Object.keys(this.errors).length) this.closeForm();
        },
        async update() {
            await this.violationTypeStore.updateViolationType();

            if (!Object.keys(this.errors).length) this.closeForm();
        },
        handleEdit(data) {
            this.violationTypeStore.setForm(data);
            this.isEditing = true;
            this.showForm = true;
        },
        closeForm() {
            this.isEditing = false;
            this.showForm = false;
            this.violationTypeStore.clearForm();
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
.small-adaptive {
    width: 90%;
    margin-inline: auto;

    @media screen and (min-width: 40em) {
        width: 60%;
    }
}

.list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.8rem;

    @media (min-width: 40rem) {
        grid-template-columns: repeat(3, 1fr);
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
    gap: 1.5rem;
    .stages {
        align-self: end;
        justify-self: start;
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
