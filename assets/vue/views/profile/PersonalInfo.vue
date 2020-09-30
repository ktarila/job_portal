<template>
  <div class="p-5">
    <div class="flex items-center w-full">
      <img
        src="https://i.imgur.com/8Km9tLL.jpg"
        class="w-40 md:w-1/6 max-w-40 rounded-full border-solid border-white border-2"
      > 

      <div class="px-3 pb-6 pt-2 flex flex-wrap w-5/6">
        <div class="flex w-full md:w-3/4 items-center"> 
          <div class="flex w-full flex-wrap">
            <h2 class="text-black text-2xl md:text-4xl font-bold w-full">
              {{ getFullname }}
            </h2>
            <span class="text-md text-gray-600 w-full">Patrick.Kenekayoro@outlook.com</span>
            <span class="text-md text-gray-600 w-full">+234(0)12345678 </span>
          </div>
        </div>
        <div class="w-full md:w-1/4 flex md:justify-end">
          <div>
            <router-link
              v-if="personalInfoId == null"
              class="bg-green-700 text-white hover:bg-green-600 active:bg-green-600 font-bold  text-sm md:text-normal uppercase py-2 px-4 md:px-6 md:py-3 rounded  outline-none focus:outline-none mr-3 mb-1"
              :to="{ name: 'new-personal-info'}"
              type="button"
              style="transition: all .15s ease"
            >
              <span>Add Personal Info</span>
            </router-link>
            <router-link
              v-else
              class="bg-green-700 text-white hover:bg-green-600 active:bg-green-600 font-bold  text-sm md:text-normal uppercase py-2 px-4 md:px-6 md:py-3 rounded  outline-none focus:outline-none mr-3 mb-1"
              :to="{ name: 'new-personal-info'}"
              type="button"
              style="transition: all .15s ease"
            >
              <span>Update Personal Info</span>
            </router-link>
          </div>
        </div>
      </div>  
    </div>
    
    <h4 class="mt-5 text-2xl font-medium border-t w-full py-2 pt-10">
      About
    </h4>
    <p class="font-light text-gray-800 text-lg mb-10">
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
import PersonalInfoAPI from '../../api/personalInfo'
export default {
  name: "PersonalInfo",
  data() {
    return {
      firstname: "",
      middlename: "",
      lastname: "",
      about: "",
      personalInfoId: null
    }
  },
  computed: {
    getFullname() {
      return this.firstname + " " + this.middlename + " " + this.lastname ;
    },
  },
  created() {
    let user = this.$store.getters['user']
    console.log(user)
    this.personalInfoId = user.info
    this.getInfo();
  },
  mounted: function() {
    
  },

  methods: {
    getInfo() {
      if (this.personalInfoId != null)
      {
        PersonalInfoAPI.singlePersonalInfo(this.personalInfoId)
          .then(function(response) {
            return response.data;
          })
          .catch(err => console.log(err)).then(res => this.setPersonalInfo(res));

      }
      
    },
    setPersonalInfo(res){
      this.firstname = res.firstname
      this.middlename = res.middlename
      this.lastname = res.lastname
      document.title = this.firstname + " " + this.middlename + " " +this.lastname + " Personal Info - Job Portal"
    }

  }
}
</script>