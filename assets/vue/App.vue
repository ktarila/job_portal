<template>
  <div class="">
    <div class="">
      <!-- section body header -->
      <header
        class="flex h-16 bg-gray-100 border-t px-4 justify-between items-center"
      >
        <h1
          id="page-caption"
          class="font-semibold text-lg"
        >
          <router-link
            to="/ads"
          >
            Home
          </router-link>
        </h1>
        <div>
          <router-link
            v-if="!authenticated"
            tag="button"
            class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded"
            to="/ads/login"
          >
            Sign in
          </router-link>
          <button
            v-else
            class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded"
            @click="logout"
          >
            {{ user.fullname }} - Logout
          </button>
        </div>
      </header>
      <router-view />
    </div>
  </div>
</template>
<script>
export default {
  name: "App",
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
    }
  },
  created() {
    let token = this.$parent.$el.attributes['data-csrf'].value
    this.$store.dispatch('addToken', token)
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

