<template>
  <div v-if="alertOpen">
    <div
      v-if="isError"
      class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-red-500"
    >
      <span class="text-xl inline-block mr-5 align-middle">
        <i class="fas fa-bell" />
      </span>
      <span class="inline-block align-middle mr-8">
        <b class="capitalize">Error</b> {{ notificationMsg }}
      </span>
      <button
        class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none"
        @click="closeAlert()"
      >
        <span>×</span>
      </button>
    </div>

    <div
      v-if="isInfo"
      class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-blue-500"
    >
      <span class="text-xl inline-block mr-5 align-middle">
        <i class="fas fa-bell" />
      </span>
      <span class="inline-block align-middle mr-8">
        <b class="capitalize">Info</b> {{ notificationMsg }}
      </span>
      <button
        class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none"
        @click="closeAlert()"
      >
        <span>×</span>
      </button>
    </div>

    <div
      v-if="isSuccess"
      class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-green-500"
    >
      <span class="text-xl inline-block mr-5 align-middle">
        <i class="fas fa-bell" />
      </span>
      <span class="inline-block align-middle mr-8">
        <b class="capitalize">Success</b> {{ notificationMsg }}
      </span>
      <button
        class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none"
        @click="closeAlert()"
      >
        <span>×</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Notification",
  data() {
    return {
    }
  },
  computed: {
    alertOpen() {
      return this.$store.getters['getNotificationMessage'] != null
    },
    notificationMsg() {
      return this.$store.getters['getNotificationMessage']
    },
    isError(){
      // console.log(this.$store.getters['getNotificationType'])
      return this.$store.getters['getNotificationType'] == "error"
    },
    isSuccess(){
      return this.$store.getters['getNotificationType'] == "success"
    },
    isInfo(){
      return this.$store.getters['getNotificationType'] == "info"
    }
  },

  methods: {
    closeAlert: function(){
      this.$store.dispatch('clearNotification')
    },
  }
}
</script>