import { createRouter, createWebHistory } from "vue-router";
// import Register from "../views/auth/register.vue";
import Login from "../pages/auth/login.vue";
import Register from "../pages/auth/register.vue";
import userDashboardLayout from "../layouts/userDashboard.vue";
import appLayout from "../layouts/app.vue";
import userDashboard from "../dashboards/users/dashboard.vue";
import userProfile from "../dashboards/users/userProfile.vue";
import userChangePassword from "../dashboards/users/changePassword.vue";
import userFeedbacks from "../dashboards/users/feedbacks.vue";
import Home from "../pages/home.vue";
import productDetail from "../pages/productDetail.vue";
// import AdminLogin from "../views/auth/AdminLogin.vue";
// import doesNtHavePermission from "../views/errors/403.vue";
import store from "../stores/index";

const routes = [
    {
        path:"/user",
        redirect:"/user/dashboard",
        component:userDashboardLayout,
        meta:{requireAuth:true,type:0},
        children:[
            {path:"/user/dashboard", name:"userDashboard", component:userDashboard ,meta:{requireAuth:true,type:0}},
            {path:"/user/profile", name:"userProfile", component:userProfile,meta:{requireAuth:true,type:0}},
            {path:"/user/change/password", name:"userChangePassword", component:userChangePassword,meta:{requireAuth:true,type:0}},
            {path:"/user/feedback", name:"userFeedbacks", component:userFeedbacks,meta:{requireAuth:true,type:0}},

        ]
    },
    {
        path:"/",
        redirect:"/",
        component:appLayout,
        children:[
            {path:"/", name:"home", component:Home},
            {path:"/product/:slug/detail", name:"productDetail", component:productDetail},
            

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

router.beforeEach((to, from, next) => {
    // Check if the route requires authentication
    if (to.meta.requireAuth && (typeof(store.state.user.id)=="undefined" || parseInt(new Date()/1000) > store.state.user.expire_at)) {
        next('/login');
    } else {
        // For routes that don't require authentication, allow access
        next();
    }
});

export default router;
