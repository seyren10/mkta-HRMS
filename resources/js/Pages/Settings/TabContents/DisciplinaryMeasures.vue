<template>
    <section>
        <v-btn
            block
            prepend-icon="mdi-plus"
            variant="flat"
            color="secondary"
            @click="showForm = true"
            v-if="!showForm"
            >add Disciplinary Measure</v-btn
        >
        <v-form
            class="form-single"
            @submit.prevent="isEditing ? update() : create()"
            v-if="showForm"
        >
            <v-text-field
                v-model="form.title"
                variant="underlined"
                density="compact"
                label="Title"
                :error="errors?.title ? true : false"
                :error-messages="errors?.title"
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
                v-for="disMeasure in disciplinaryMeasures"
                :key="disMeasure.id"
            >
                <span>{{ disMeasure.title }}</span>
                <v-icon class="edit" @click="handleEdit(disMeasure)"
                    >mdi-pencil-outline</v-icon
                >
            </li>
        </ul>
    </section>
</template>

<script>
import { useDisciplinaryMeasureStore } from "@/stores/disciplinaryMeasureStore";
import { storeToRefs } from "pinia";
export default {
    async setup() {
        const disciplinaryMeasureStore = useDisciplinaryMeasureStore();
        await disciplinaryMeasureStore.getDisciplinaryMeasures();

        const { disciplinaryMeasures, form, errors, loading } = storeToRefs(
            disciplinaryMeasureStore
        );

        return {
            disciplinaryMeasures,
            disciplinaryMeasureStore,
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
            await this.disciplinaryMeasureStore.addDisciplinaryMeasure();
            if (!Object.keys(this.errors).length) this.closeForm();
        },
        async update() {
            await this.disciplinaryMeasureStore.updateDisciplinaryMeasure();

            if (!Object.keys(this.errors).length) this.closeForm();
        },
        handleEdit(data) {
            this.disciplinaryMeasureStore.setForm(data);
            this.isEditing = true;
            this.showForm = true;
        },
        closeForm() {
            this.isEditing = false;
            this.showForm = false;
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
