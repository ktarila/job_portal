<template>
  <div>
    <!-- main content -->
    <main class="min-h-0">
      <div class="flex flex-wrap">
        <div class="w-full">
          <div class="border w-full pt-5 px-5">
            <div class="flex flex-wrap -mx-3">
              <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row w-full">
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                  <a
                    class="text-xs font-bold uppercase px-5 py-3 shadow rounded block leading-normal"
                    :class="{'text-indigo-600 bg-white': openTab !== 1, 'text-white bg-indigo-600': openTab === 1}"
                    @click="toggleTabs(1)"
                  >
                    <i class="fas fa-space-shuttle text-base mr-1" /> Personal Info
                  </a>
                </li>
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                  <a
                    class="text-xs font-bold uppercase px-5 py-3 shadow rounded block leading-normal"
                    :class="{'text-indigo-600 bg-white': openTab !== 2, 'text-white bg-indigo-600': openTab === 2}"
                    @click="toggleTabs(2)"
                  >
                    <i class="fas fa-cog text-base mr-1" /> Education
                  </a>
                </li>
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
                  <a
                    class="text-xs font-bold uppercase px-5 py-3 shadow rounded block leading-normal"
                    :class="{'text-indigo-600 bg-white': openTab !== 3, 'text-white bg-indigo-600': openTab === 3}"
                    @click="toggleTabs(3)"
                  >
                    <i class="fas fa-briefcase text-base mr-1" /> Experience
                  </a>
                </li>
              </ul>
            </div>
          </div>
          
          <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow rounded">
            <div class="px-4 py-5 flex-auto">
              <div class="tab-content tab-space">
                <div :class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                  <PersonalInfo 
                    :info-id="personalInfoId"
                  />
                </div>
                <div :class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                  <Education />
                </div>
                <div :class="{'hidden': openTab !== 3, 'block': openTab === 3}">
                  <Experience />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import PersonalInfo from './PersonalInfo'
import Education from './Education'
import Experience from './Experience'
export default {
  name: "Profile",
  components: {
    PersonalInfo,
    Education,
    Experience
  },
  data() {
    return {
      openTab: 1,
      personalInfoId: ""
    }
  },
  created() {
    document.title = "Profile - Job Portal"
    const infoId = this.$route.params.info_id
    if (typeof infoId === 'undefined')
    {
      let user = this.$store.getters['user']

      this.personalInfoId = user.info !== null ? user.info : 0

    }else{
      this.personalInfoId = parseInt(infoId)
    } 
    
  },
  methods: {
    toggleTabs: function(tabNumber){
      this.openTab = tabNumber
    }
  }
}
</script>