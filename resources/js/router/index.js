import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/stores/userStore";

import MainLayout from "@/Layouts/MainLayout.vue";

const routes = [
    {
        path: "/",
        name: "index",
        component: MainLayout,
        redirect: { name: "dashboard" },
        children: [
            {
                path: "dashboard",
                name: "dashboard",
                component: () => import("@/Pages/Dashboard/Index.vue"),
                meta: {
                    requiresAuth: true,
                },
            },
            {
                path: "employee",
                name: "employee",
                component: () => import("@/Pages/Employees/Index.vue"),
                children: [
                    {
                        path: ":id/show",
                        name: "employeeShow",
                        component: () => import("@/Pages/Employees/Show.vue"),
                        props: true,
                    },
                ],
                meta: {
                    requiresAuth: true,
                },
            },
            {
                path: "employee-violation",
                name: "employeeViolation",
                component: () => import("@/Pages/EmployeeViolation/Index.vue"),
                meta: {
                    requiresAuth: true,
                },
            },
            {
                path: "nte",
                name: "nte",
                component: () => import("@/Pages/NTE/Index.vue"),
                meta: {
                    requiresAuth: true,
                },
            },
            {
                path: "contract",
                name: "contract",
                component: () => import("@/Pages/Contract/Index.vue"),
                meta: {
                    requiresAuth: true,
                },
            },

            {
                path: "settings",
                name: "settings",
                component: () => import("@/Pages/Settings/Index.vue"),
                meta: {
                    requiresAuth: true,
                },
            },
            {
                path: "disciplinary-measure",
                name: "disciplinaryMeasure",
                component: () =>
                    import("@/Pages/DisciplinaryMeasures/Index.vue"),
                meta: {
                    requiresAuth: true,
                },
            },
            {
                path: "violation-type",
                name: "violationType",
                component: () => import("@/Pages/Violation/ViolationType.vue"),
                meta: {
                    requiresAuth: true,
                },
            },
            {
                path: "violation",
                name: "violation",
                component: () => import("@/Pages/Violation/Index.vue"),
                meta: {
                    requiresAuth: true,
                },
            },
            {
                path: "pending-violation",
                name: "pendingViolation",
                component: () => import("@/Pages/PendingViolation/Index.vue"),
                meta: {
                    requiresAuth: true,
                },
            },
        ],
    },
    {
        path: "/login",
        name: "login",
        component: () => import("@/Pages/Auth/Login.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from) => {
    const userStore = useUserStore();
    await userStore.getUser();

    if (to.meta.requiresAuth && !userStore.user) {
        return { name: "login", replace: true };
    }
});
export default router;
