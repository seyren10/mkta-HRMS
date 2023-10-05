<script>
import EmployeeShow from "@/Pages/Employees/Show.vue";
import Heading from "./Heading.vue";
export default {
    data() {
        return {
            showPageTitle: this.$route.params.showable.toString(),
        };
    },
    computed: {
        getShowableComponent() {
            switch (this.showPageTitle) {
                case "employee":
                    return EmployeeShow;
            }
        },
    },
    watch: {
        "this.$route.params.showable"(to, from) {
            console.log(to);
            console.log(from);
            this.showPageTitle = to?.at(0) || from.at(0);
        },
    },
    components: { Heading },
};
</script>

<template>
    <v-container>
        <div class="d-flex items-end" style="gap: 2rem">
            <v-btn
                icon="mdi-keyboard-backspace"
                color="secondary"
                @click="this.$router.back()"
                size="small"
                variant="text"
            ></v-btn>
            <Heading icon="mdi-account-outline"
                >{{ showPageTitle }} information</Heading
            >
        </div>
        <component :is="getShowableComponent"></component>
    </v-container>
</template>

<style scoped>
.proper::first-letter {
    text-transform: uppercase;
}
</style>
