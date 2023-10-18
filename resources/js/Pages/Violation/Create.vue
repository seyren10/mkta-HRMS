<template>
    <v-card>
        <v-toolbar color="primary">
            <v-toolbar-title>Define new Violation</v-toolbar-title>
            <v-toolbar-items>
                <v-btn icon="mdi-close" @click="this.$emit('close')"></v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
            <v-form @submit.prevent="create">
                <v-row>
                    <v-col cols="12" md="6" sm="12">
                        <v-text-field
                            readonly
                            label="Violation Type"
                            variant="underlined"
                            density="compact"
                            :model-value="violationType.violation_type"
                            :error="errors?.violation_type ? true : false"
                            :error-messages="errors?.violation_type"
                        ></v-text-field>
                        <v-textarea
                            label="Description"
                            variant="underlined"
                            density="compact"
                            auto-grow
                            v-model="form.description"
                            :error="errors?.description ? true : false"
                            :error-messages="errors?.description"
                        ></v-textarea>
                        <v-btn
                            v-show="
                                form.description.trim() !== '' &&
                                disciplinaryActions.some((a) => a.id)
                            "
                            type="submit"
                            color="primary"
                            prepend-icon="mdi-plus"
                            block
                            :loading="loading"
                            >Add</v-btn
                        >
                    </v-col>
                    <v-col
                        cols="12"
                        md="6"
                        sm="12"
                        class="bg-blue-grey-lighten-5 pa-4 rounded"
                    >
                        <p class="text-overline">Disciplinary Steps</p>
                        <v-select
                            v-for="(action, index) in disciplinaryActions"
                            :key="index"
                            label="Disciplinary Action"
                            variant="underlined"
                            density="compact"
                            v-model="disciplinaryActions[index]"
                            item-title="title"
                            :items="
                                disciplinaryMeasuresFilter.map((el) => {
                                    return {
                                        title: el.title,
                                        value: el,
                                    };
                                })
                            "
                            :error="errors?.action_length ? true : false"
                            :error-messages="errors?.action_length"
                        >
                            <template #prepend> {{ index + 1 }}. </template>
                            <template #append="props">
                                <v-btn
                                    icon="mdi-close"
                                    size="xs"
                                    flat
                                    color="none"
                                    @click="
                                        handleDeleteDisciplinaryAction(
                                            disciplinaryActions[index]
                                        )
                                    "
                                ></v-btn>
                            </template>
                        </v-select>
                        <div class="d-flex justify-end">
                            <v-btn
                                v-if="disciplinaryMeasuresFilter.length > 0"
                                class="text-none"
                                color="secondary"
                                flat
                                border
                                prepend-icon="mdi-content-save"
                                @click="handleIncreaseActionLength"
                                >Append action</v-btn
                            >
                        </div>
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<script>
import { useViolationStore } from "@/stores/violationStore";
import { useViolationTypeStore } from "@/stores/violationTypeStore";
import { storeToRefs } from "pinia";

export default {
    async setup() {
        const violationStore = useViolationStore();
        const violationTypeStore = useViolationTypeStore();
        const { form, errors, loading } = storeToRefs(violationStore);

        return {
            violationTypeStore,
            violationStore,
            form,
            loading,
            errors,
        };
    },
    props: {
        violationType: Object,
        disciplinaryMeasures: Array,
    },
    data() {
        return {
            disciplinaryActions: [{ id: null, title: null }],
        };
    },
    emits: ["close"],
    watch: {
        disciplinaryActions: {
            handler(newValue, oldValue) {
                if (this.disciplinaryActions?.some((a) => a.id))
                    this.form.action_length = this.disciplinaryActions.length;
            },
            immediate: true,
            deep: true,
        },
    },
    created() {
        this.form.violation_type_id = this.violationType.id;
    },
    computed: {
        disciplinaryMeasuresFilter() {
            return this.disciplinaryMeasures.filter(
                (el) => !this.disciplinaryActions.includes(el)
            );
        },
    },
    methods: {
        async create() {
            this.form.disciplinaryActionIds = this.disciplinaryActions
                .map((a) => a.id)
                .filter((a) => a);
            await this.violationStore.addViolation();

            await this.violationTypeStore.getViolationTypes({
                includeViolations: true,
            });
            if (!Object.keys(this.errors).length) {
                this.$emit("close");
            }
        },
        handleIncreaseActionLength() {
            this.disciplinaryActions.push({ id: null, title: null });
        },
        handleDeleteDisciplinaryAction(index) {
            this.disciplinaryActions = this.disciplinaryActions.filter(
                (a) => a !== index
            );
        },
    },
};
</script>

<style scoped>
.list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}
</style>
