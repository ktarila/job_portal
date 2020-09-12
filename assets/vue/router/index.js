import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import Login from "../views/Login";
import store from "../store"

Vue.use(VueRouter);

const routes = [
  { path: "/home", name: 'home', component: Home, meta: { requiresAuth: true } },
  { path: "/login", name: 'login', component: Login},
  { path: "*", redirect: "/home" }
]

let router = new VueRouter({
  mode: "history",
  routes: routes
});


router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (store.getters['isAuthenticated']) {
      next();
    } else {
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      });
    }
  } else {
    next(); // make sure to always call next()!
  }
});

export default router;