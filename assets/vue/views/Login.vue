<template>
  <div class="container mx-auto mt-10">
    <div class="w-full flex items-center">
      <div class="hidden md:block w-2/3">
        <div class="w-3/4 mx-auto">
          <img src="/image/image.png">
        </div>
      </div>
      <div class="w-full md:w-1/3">
        <div class="w-full bg-gray-100 rounded shadow max-w-md mx-auto">
          <div class="w-full p-5">
            <div class="border-b border-gray-300">
              <h1 class="text-center text-3xl tracking-wide leading-wide mt-0 text-gray-800 p-5">
                <i class="fas fa-lock mr-5" /> Login
              </h1>
            </div>
            <div class="px-4 py-4">
              <div
                v-if="hasError"
                class="bg-pink-500 rounded font-medium text-white px-5 py-2 mb-5 w-full"
                role="alert"
              >
                <span class="width-full">{{ error }}</span>
              </div>
              <form class="bg-transparent rounded pt-6 pb-8 mb-4">
                <div class="mb-4">
                  <label
                    class="block text-gray-700 font-medium mb-2"
                    for="email"
                  >
                    Email
                  </label>
                  <input
                    id="email"
                    v-model="email"
                    class="h-12 block w-full bg-gray-400 border border-gray-200 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    type="text"
                    placeholder="Email"
                  >
                </div>
                <div class="mb-6">
                  <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="password"
                  >
                    Password
                  </label>
                  <input
                    id="password"
                    v-model="password"
                    class="h-12 block w-full bg-gray-400 border border-gray-200 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    type="password"
                    placeholder="******************"
                  >
                </div>
                <div class="flex items-center justify-between">
                  <button
                    :disabled="email.length === 0 || password.length === 0"
                    class="
                    bg-green-500
                    hover:bg-green-700
                    text-white
                    font-bold
                    py-2
                    px-4
                    rounded
                    focus:outline-none
                    focus:shadow-outline
                    w-full"
                    type="button"
                    @click="performLogin()"
                  >
                    Sign In
                  </button>
                </div>
                <div class="mt-10 flex justify-between">
                  <a
                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                    href="#"
                  >
                    Forgot Password?
                  </a>

                  <a
                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                    href="/register"
                  >
                    Register
                  </a>
                </div>
              </form>
            </div>
            <p class="text-center text-gray-500 text-xs">
              &copy;2020 Job Portal. All rights reserved.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      email: '',
      password: '',
    };
  },
  computed: {
    hasError() {
      return this.$store.getters['hasError'];
    },
    error() {
      return this.$store.getters['error'];
    },
  },
  created() {
    document.title = "Login - Job Portal"
  },
  methods: {
    performLogin() {
      let payload = { email: this.$data.email, password: this.$data.password }

      // this.$store.dispatch('login', payload);
      let redirect = this.$route.query.redirect;

      this.$store.dispatch('login', payload)
        .then(() => {
          if (!this.$store.getters['hasError']) {
            if (typeof redirect !== 'undefined' && redirect !== '/ads') {
              this.$router.push({ path: redirect });
            } else {
              window.location = "/"
            }
          }
        })
        .catch( e => {
          console.log(e)
        });

    },
  },
};
</script>