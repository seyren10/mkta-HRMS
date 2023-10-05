<template>
    <h1
        class="text-overline d-flex align-center text-secondary"
        style="gap: 0.5rem"
    >
        <v-icon :icon="icon"></v-icon><slot>No Title</slot>
    </h1>
</template>

<script>
export default {
    props: {
        icon: String,
    },
};
</script>

<style scoped></style>
