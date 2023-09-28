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
