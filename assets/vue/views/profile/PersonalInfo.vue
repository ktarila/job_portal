<template>
  <div class="p-5">
    <div class="flex items-center w-full">
      <img
        :src="getAvatar"
        class="w-40 md:w-1/6 max-w-40 rounded-full border-solid border-white border-2"
      > 

      <div class="px-3 pb-6 pt-2 flex flex-wrap w-5/6">
        <div class="flex w-full md:w-3/4 items-center"> 
          <div class="flex w-full flex-wrap">
            <h2 class="text-black text-2xl md:text-4xl font-bold w-full">
              {{ getFullname }}
            </h2>
            <span class="text-md text-gray-600 w-full">{{ email }}</span>
            <span class="text-md text-gray-600 w-full">{{ phone }} </span>
          </div>
        </div>
        <div class="w-full md:w-1/4 flex md:justify-end">
          <div>
            <router-link
              v-if="personalInfoId == 0"
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
              :to="{ name: 'update-personal-info', params: { id: personalInfoId }}"
              type="button"
              style="transition: all .15s ease"
            >
              <span>Update Personal Info</span>
            </router-link>
          </div>
        </div>
      </div>  
    </div>
    
    <h4 class="mt-5 text-2xl font-medium border-t w-full pb-0 pt-10">
      About
    </h4>
    <p
      style="min-height: 150px"
      class="leading-normal text-lg whitespace-pre-line text-gray-800 mb-10 -mt-3"
    >
      {{ about }}
    </p>

    <div class="font-light border-t border-gray-200 text-gray-800 my-5 text-lg">
      <span class="w-full block my-1"><span class="w-2 inline-block text-indigo-800 mr-10 mt-10"><i class="fas fa-envelope" /></span> {{ email }}</span>
      <span class="w-full block my-1"><span class="w-2 inline-block text-indigo-800 mr-10"><i class="fas fa-phone-square" /></span> {{ phone }}</span>
      <div class="w-full flex block my-1">
        <span class="w-2 text-indigo-800 mr-10"><i class="fas fa-map-marked-alt" /></span>
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
  props: {
    // type check
    infoId: {
      type: Number,
      default: null,
      required: true
    }
  },
  data() {
    return {
      firstname: "",
      middlename: "",
      lastname: "",
      about: "",
      email: "",
      phone: "",
      personalInfoId: null,
      avatarUrl: null
    }
  },
  computed: {
    getFullname() {
      return this.firstname + " " + this.middlename + " " + this.lastname ;
    },
    getAvatar() {
      let img_src = this.avatarUrl == null ? "/image/avatar.svg" : this.avatarUrl
      return  img_src
    },
  },
  created() {
    this.getInfo();
  },
  mounted: function() {
    
  },

  methods: {
    getInfo() {
      this.personalInfoId = this.infoId
      if (this.personalInfoId !== 0)
      {
        PersonalInfoAPI.singlePersonalInfo(this.personalInfoId)
          .then(function(response) {
            return response.data;
          })
          .catch(err => console.log(err)).then(res => this.setPersonalInfo(res));

      }
      
    },
    setPersonalInfo(res){
      // console.log(res)
      if (res.avatar)
      {
        this.avatarUrl = res.avatar.url
      }
      this.firstname = res.firstname
      this.middlename = res.middlename
      this.lastname = res.lastname
      this.about = res.about
      this.email = res.email
      this.phone = res.phone
      document.title = this.firstname + " " + this.middlename + " " +this.lastname + " Personal Info - Job Portal"
    }

  }
}
</script>