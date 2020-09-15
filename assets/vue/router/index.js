import Vue from "vue";
import VueRouter from "vue-router";
import Ads from "../views/Ads";
import Login from "../views/Login";
// import store from "../store"

Vue.use(VueRouter);

const routes = [
  { path: "/ads", name: 'ads', component: Ads },
  { path: "/ads/login", name: 'login', component: Login },
  { path: "*", redirect: "/ads" }
]

let router = new VueRouter({
  mode: "history",
  routes: routes
});


export default router;