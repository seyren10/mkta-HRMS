<template>
    <v-chip
        :prepend-icon="
            number > 0
                ? iconSet?.positive ?? 'mdi-arrow-down'
                : iconSet?.negative ?? 'mdi-arrow-up'
        "
        :color="
            number > 0
                ? colorSet?.positive ?? 'red'
                : colorSet?.negative ?? 'green'
        "
    >
        {{ number }}
    </v-chip>
</template>

<script>
export default {
    props: {
        number: Number,
        iconSet: {
            positive: String,
            negative: String,
        },
        colorSet: {
            positive: String,
            negative: String,
        },
    },
};
</script>

<style scoped></style>
