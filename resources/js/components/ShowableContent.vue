<template>
    <div
        class="border rounded pa-2 text-caption list-item"
        :class="{ active: showInfo }"
        @click="showInfo = !showInfo"
    >
        <slot>No Content Available</slot>

        <v-card v-if="showInfo" class="mt-4" flat>
            <v-card-text>
                <slot name="showable">No Showable Content</slot>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showInfo: false,
        };
    },
};
</script>

<style scoped>
.list-item {
    gap: 1rem;
    cursor: pointer;
}
.active {
    background-color: #e3f2fd;
}
</style>
