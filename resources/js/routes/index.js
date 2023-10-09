import { createRouter, createWebHistory } from "vue-router";
// import Register from "../views/auth/register.vue";
import Login from "../pages/auth/login.vue";
import Register from "../pages/auth/register.vue";
import userDashboardLayout from "../layouts/userDashboard.vue";
import userDashboard from "../dashboards/users/dashboard.vue";
import userProfile from "../dashboards/users/userProfile.vue";
import userChangePassword from "../dashboards/users/changePassword.vue";
import userFeedbacks from "../dashboards/users/feedbacks.vue";
// import AdminLogin from "../views/auth/AdminLogin.vue";
// import doesNtHavePermission from "../views/errors/403.vue";
// import store from "../store/index";

const routes = [
    {
        path:"/user",
        redirect:"/user/dashboard",
        component:userDashboardLayout,
        children:[
            {path:"/user/dashboard", name:"userDashboard", component:userDashboard},
            {path:"/user/profile", name:"userProfile", component:userProfile},
            {path:"/user/change/password", name:"userChangePassword", component:userChangePassword},
            {path:"/user/feedback", name:"userFeedbacks", component:userFeedbacks},

        ]
    },
    {
        path: "/login",
        name: "login",
        component: Login,
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    },
    // {
    //     path: "/admin/login",
    //     name: "AdminLogin",
    //     component: AdminLogin,
    // }

];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active",
});

// router.beforeEach((to, from, next) => {
//     if (to.meta.requiresAuth) {
//         // Check if the route requires authentication
//         if (!store.state.user) {
//             // If not authenticated, redirect to login or another route
//             next('/admin/login');
//         } else {
//             // If authenticated, allow access to the route
//             // check user has route permission
//             if (!store.state.user.permissions.includes(to.meta.permission)) {
//                 next('/403');
//             } else {
//                 next();
//             }
//         }
//     } else {
//         // For routes that don't require authentication, allow access
//         next();
//     }
// });

export default router;
