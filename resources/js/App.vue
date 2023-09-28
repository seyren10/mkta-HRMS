<template>
    <router-view v-slot="{ Component }">
        <template v-if="Component">
            <Suspense timeout="0">
                <component :is="Component" />

                <template v-slot:fallback>
                    <Spinner />
                </template>
            </Suspense>
        </template>
    </router-view>
</template>

<script>
import Spinner from "@/components/Spinner.vue";
export default {
    components: { Spinner },
};
</script>
