<template>
    <v-expansion-panels variant="inset" class="mt-3">
        <v-expansion-panel
            v-for="item in items"
            :key="item.id"
            :title="item[titleKey]"
        >
            <v-expansion-panel-title v-if="!titleKey">
                <template v-slot:default="props">
                    <slot name="title" :item="item"></slot>
                </template>
            </v-expansion-panel-title>
            <v-expansion-panel-text>
                <slot :item="item">No Content available</slot>
            </v-expansion-panel-text>
        </v-expansion-panel>
    </v-expansion-panels>
</template>

<script>
export default {
    props: {
        items: Array,
        titleKey: String,
    },
};
</script>

<style scoped>
.row-2 {
    row-gap: 0;
    align-items: start;
    width: 100vw;
}
</style>
