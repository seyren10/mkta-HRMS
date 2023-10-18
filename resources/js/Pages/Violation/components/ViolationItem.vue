<template>
    <v-card-text
        class="d-grid list-item"
        :class="{ active: showInfo }"
        @click="showInfo = !showInfo"
    >
        <v-sheet
            position="absolute"
            style="right: 0; top: 0"
            class="text-primary edit"
        >
            <v-btn
                icon="mdi-pencil-outline"
                flat
                size="large"
                @click.stop="handleEditViolation(violation.id, violationType)"
                class="text-secondary"
            ></v-btn>
        </v-sheet>
        <p class="text-caption">
            <strong>Description:</strong>
            {{ violation.description }}
        </p>

        <div class="text-caption chip bg-accent-light text-secondary">
            Offense count before Dismissal/Termination:
            {{ violation.disciplinaryActions.length }}
        </div>
        <v-table density="compact" v-show="showInfo">
            <thead>
                <tr>
                    <th v-for="i in disciplinaryActions.length">
                        {{ getOrdinal(i) }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td v-for="dA in disciplinaryActions">{{ dA.title }}</td>
                </tr>
            </tbody>
        </v-table>
    </v-card-text>
</template>

<script>
import { useUtils } from "@/composables/useUtils";

export default {
    data() {
        const { getOrdinal } = useUtils();
        return {
            showInfo: false,
            getOrdinal,
        };
    },
    props: ["violation", "violationType", "disciplinaryMeasures"],
    emits: ["click"],
    methods: {
        handleEditViolation(violationId, violationType) {
            const dialog = {
                state: true,
                component: "Edit",
                props: {
                    violationId,
                    violationType,
                    disciplinaryMeasures: this.disciplinaryMeasures,
                },
            };
            this.$emit("click", dialog);
        },
    },
    computed: {
        disciplinaryActions() {
            return this.violation.disciplinaryActions.map(
                (el) => el.disciplinaryMeasure
            );
        },
    },
};
</script>

<style scoped>
.edit {
    display: none !important;

    @media screen and (max-width: 40em) {
        display: block !important;
    }
}
.list-item {
    gap: 1rem;
    cursor: pointer;
}
.active {
    background-color: #e3f2fd;
}

.list-item:hover .edit {
    display: block !important;
}
</style>
