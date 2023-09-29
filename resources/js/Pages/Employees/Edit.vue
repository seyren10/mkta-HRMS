<template>
    <v-card>
        <v-toolbar color="white" class="border-b">
            <v-toolbar-title>Add Device</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn variant="text" @click="dialog = false"> cancel </v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <v-container>
            <v-form>
                <v-row>
                    <v-col>
                        <v-text-field label="Brand*"></v-text-field>
                    </v-col>
                </v-row>
                <v-col cols="12"
                    ><v-btn
                        block
                        variant="flat"
                        color="blue-lighten-1"
                        type="submit"
                        >Create Item</v-btn
                    ></v-col
                >
            </v-form>
        </v-container>
    </v-card>
</template>

<script>
export default {};
</script>

<style scoped></style>
