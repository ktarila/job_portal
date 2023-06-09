import Vue from "vue";
import VueRouter from "vue-router";
import ListPositions from "../views/position/ListPositions";
import ShowPosition from "../views/position/ShowPosition";
import AddPosition from "../views/position/AddPosition";
import UpdatePosition from "../views/position/UpdatePosition";
import Profile from "../views/profile/Profile";
import NewPersonalInfo from "../views/profile/NewPersonalInfo";
import UpdatePersonalInfo from "../views/profile/UpdatePersonalInfo";
import ListApplicants from "../views/applicant/ListApplicants";
import Login from "../views/Login";
import store from "../store"

Vue.use(VueRouter);

const routes = [
  { path: "/ads", name: 'list-positions', component: ListPositions},
  { path: "/ads/applicants", name: 'all-applicants', component: ListApplicants, meta: { requiresAuth: true }},
  { path: "/ads/new", name: 'add-position', component: AddPosition, meta: { requiresAuth: true }},
  { path: "/ads/show/:id", name: 'show-position', component: ShowPosition},
  { path: "/ads/update/:id", name: 'update-position', component: UpdatePosition, meta: { requiresAuth: true }},
  { path: "/ads/profile/:info_id?", name: 'profile', component: Profile, meta: { requiresAuth: true }},
  // { path: "/ads/profile/:infoid", name: 'profile-info', component: Profile, meta: { requiresAuth: true }},
  { path: "/ads/personal-info", name: 'new-personal-info', component: NewPersonalInfo, meta: { requiresAuth: true }},
  { path: "/ads/personal-info/update/:id", name: 'update-personal-info', component: UpdatePersonalInfo, meta: { requiresAuth: true }},
  { path: "/ads/login", name: 'login', component: Login },
  { path: "*", redirect: "/ads" }
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
        path: '/ads/login',
        query: { redirect: to.fullPath }
      });
    }
  } else {
    next(); // make sure to always call next()!
  }
});


export default router;