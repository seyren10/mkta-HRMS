<template>
    <div class="loader">
        <v-icon class="icon text-blue-lighten-1">mdi-loading</v-icon>
    </div>
</template>

<style scoped>
.loader {
    display: grid;
    height: 80vh;
    place-items: center;
}

.icon {
    font-size: 4rem;
    animation: spin 350ms linear infinite;
}

@keyframes spin {
    0% {
        rotate: 0deg;
    }
    100% {
        rotate: 360deg;
    }
}
</style>
