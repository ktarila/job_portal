<template>
  <div class="">
    <div class="">
      <router-view />
    </div>
  </div>
</template>
<script>
export default {
  name: "App",
  data() {
    return {
      menuShow: false
    }
  },
  computed: {
    isAuthenticated() {
      return this.$store.getters['isAuthenticated']
    },
  },
  created() {
    this.$store.dispatch('AutoLogin')
  },
  methods: {
    toggleNavbar: function(){
      this.menuShow = !this.menuShow;
    },

    logout(){
      this.$store.dispatch('logout');
    }
  }
}
</script>

