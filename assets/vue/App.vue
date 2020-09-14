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
      menuShow: false,
      csrf: '',
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

  },
  methods: {
    toggleNavbar: function(){
      this.menuShow = !this.menuShow;
    },

    logout(){
      this.$store.dispatch('logout');
    }
  },
}
</script>

