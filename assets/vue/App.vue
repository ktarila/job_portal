<template>
  <div class="">
    <div class="flex flex-wrap mb-5">
      <div class="w-full">
        <nav class="relative flex flex-wrap items-center justify-between px-2 py-3 navbar-expand-lg bg-indigo-600">
          <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start">
              <router-link
                class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-no-wrap uppercase text-white"
                to="/ads"
              >
                Job Portal
              </router-link>
              <button
                class="text-white cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none"
                type="button"
                @click="toggleNavbar()"
              >
                <i 
                  :class="{'hidden': menuShow, 'block': !menuShow }"
                  class="fas fa-bars"
                />
                <i 
                  :class="{'hidden': !menuShow, 'block': menuShow }"
                  class="fas fa-times"
                />
              </button>
            </div>
            <div
              :class="{'hidden': !menuShow, 'flex': menuShow}"
              class="lg:flex lg:flex-grow items-center"
            >
              <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">
                <li class="nav-item">
                  <router-link
                    class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75"
                    to="/ads"
                  >
                    Jobs
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link
                    class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75"
                    to="/ads/profile"
                  >
                    Profile
                  </router-link>
                </li>
                <li class="nav-item">
                  <a
                    class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75"
                    href="/admin"
                  >
                    Admin
                  </a>
                </li>
                <li class="nav-item">
                  <router-link
                    v-if="!authenticated"
                    class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer"
                    to="/ads/login"
                  >
                    Sign in
                  </router-link>
                  <a
                    v-else
                    class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75 cursor-pointer"
                    @click="logout"
                  >
                    {{ user.fullname }} - Logout
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>
    
    <div class="container mx-auto">
      <Notification />
      <router-view />
    </div>
  </div>
</template>
<script>
import Notification from './views/Notification'
export default {
  name: "App",
  components: {
    Notification,
  },
  data() {
    return {
      menuShow: false,
      csrf: '',
      authenticated: false,
      user: null
    }
  },
  computed: {
    isAuthenticated() {
      return this.$store.getters['isAuthenticated']
    },
    isLogin() {
      return this.$route.name === 'login'
    },
  },
  created() {
    this.$store.dispatch('AutoLogin')
    this.authenticated = this.$store.getters['isAuthenticated']
    this.user = this.$store.getters['user']

  },
  methods: {
    toggleNavbar: function(){
      this.menuShow = !this.menuShow;
    },

    logout(){
      this.$store.dispatch('logout');
      this.authenticated = false
      this.$router.push({ path: "/ads/login" });
    }
  },
}
</script>

