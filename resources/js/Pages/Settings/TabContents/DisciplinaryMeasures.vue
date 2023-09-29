<template>
    <section>
        <v-form class="form-single">
            <v-text-field
                variant="underlined"
                density="compact"
                label="title"
            ></v-text-field>
            <v-btn variant="flat">Save</v-btn>
        </v-form>
        <div class="list">
            <div class="list-item"></div>
        </div>
    </section>
</template>

<script>
export default {};
</script>

<style scoped>
.form-single {
    display: flex;
    gap: 1rem;
}
section {
    width: 50%;
    margin-inline: auto;
}
</style>
