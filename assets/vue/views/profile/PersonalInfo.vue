<template>
  <div class="p-5">
    <div class="flex items-center w-full">
      <img
        src="https://i.imgur.com/8Km9tLL.jpg"
        class="w-40 rounded-full border-solid border-white border-2"
      > 

      <div class="px-3 pb-6 pt-2 flex flex-wrap">
        <h2 class="text-black text-4xl font-bold w-full">
          Patrick Kenekayoro
        </h2>
        <span class="text-md text-gray-600 w-full">Patrick.Kenekayoro@outlook.com</span>
        <span class="text-md text-gray-600 w-full">+234(0)12345678 </span>
      </div>  
    </div>
    
    <h4 class="mt-5 text-2xl font-medium border-t w-full py-2">
      About
    </h4>
    <p class="font-light text-gray-800 text-lg">
      I am a highly competent IT professional with a proven track record in designing websites, networking and managing databases. I have strong technical skills as well as excellent interpersonal skills, enabling me to interact with a wide range of clients. I am eager to be challenged in order to grow and further improve my IT skills. My greatest passion is in life is using my technical know-how to benefit other people and organisations.
    </p>

    <div class="font-light text-gray-800 my-5 text-lg">
      <span class="w-full block"><span class="w-2 inline-block text-indigo-800 mr-5"><i class="fas fa-envelope" /></span> Patrick.Kenekayoro@outlook.com</span>
      <span class="w-full block"><span class="w-2 inline-block text-indigo-800 mr-5"><i class="fas fa-phone-square" /></span> +234(0)12345678</span>
      <div class="w-full flex block">
        <span class="w-2 text-indigo-800 mr-5"><i class="fas fa-map-marked-alt" /></span>
        <div>
          <span class="w-full block">Address Line One</span>
          <span class="w-full block">Address Line Two</span>
          <span class="w-full block">City, Country</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PersonalInfo",
  data() {
    return {
    }
  },
  computed: {

  },

  methods: {

  }
}
</script>