import { createRouter, createWebHistory } from "vue-router";

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
            },
            {
                path: "employee-violation",
                name: "employeeViolation",
                component: () => import("@/Pages/EmployeeViolation/Index.vue"),
            },
            {
                path: "nte",
                name: "nte",
                component: () => import("@/Pages/NTE/Index.vue"),
            },
            {
                path: "contract",
                name: "contract",
                component: () => import("@/Pages/Contract/Index.vue"),
            },

            {
                path: "settings",
                name: "settings",
                component: () => import("@/Pages/Settings/Index.vue"),
            },
            {
                path: "disciplinary-measure",
                name: "disciplinaryMeasure",
                component: () =>
                    import("@/Pages/DisciplinaryMeasures/Index.vue"),
            },
            {
                path: "violation-type",
                name: "violationType",
                component: () => import("@/Pages/Violation/ViolationType.vue"),
            },
            {
                path: "violation",
                name: "violation",
                component: () => import("@/Pages/Violation/Index.vue"),
            },
            {
                path: "pending-violation",
                name: "pendingViolation",
                component: () => import("@/Pages/PendingViolation/Index.vue"),
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

export default router;
