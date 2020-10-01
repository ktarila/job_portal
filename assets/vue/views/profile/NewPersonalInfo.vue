<template>
  <div>
    <loading-overlay
      :active="isLoading"
      :is-full-page="fullPage"
      :loader="loader"
    />
    <!-- main content -->
    <main class="min-h-0">
      <!-- section content -->
      <section class="w-full min-h-0 border-l border-r border-b">
        <header class="bg-white border-t flex items-center p-10 mt-4 w-full">
          <div class="flex">
            <h2
              id="content-caption"
              class="font-semibold text-lg"
            >
              Update Personal Information
            </h2>
          </div>
        </header>
        <div class="relative p-6 flex-auto w-full mx-auto">
          <ValidationObserver
            ref="observer"
            slim
          >
            <form class="w-full">
              <div class="flex flex-wrap mb-6">
                <div class="w-full my-5">
                  <validation-provider
                    ref="avatarProvider"
                    v-slot="{ validate, errors }"
                    rules="image|size:100"
                  >
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      :class="{ 'text-red-700': errors.length > 0 }"
                      for="grid-avatar"
                    > Photo </label>
                    <div id="preview mb-5">
                      <img
                        v-if="url"
                        :src="url"
                        class="mb-5 max-w-40 rounded-full"
                      >
                    </div>
                  
                    <input
                      id="grid-avatar"
                      ref="avatarInput"
                      class="cursor-pointer"
                      type="file"
                      name="avatar"
                      @change="onFileChange"
                    >
                    <span class="text-red-400 text-sm italic block">{{ errors[0] }}</span>
                  </validation-provider>
                </div>
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                  <validation-provider
                    v-slot="{ errors }"
                    rules="required"
                  >
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-firsname"
                    >
                      Firstname
                    </label>
                    <input
                      id="grid-firsname"
                      v-model="newPersonalInfo.firstname"
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      :class="{ 'border-red-400': errors.length > 0 }"
                      type="text"
                      placeholder="Firstname"
                    >
                    <span class="text-red-400 text-sm italic ">{{ errors[0] }}</span>
                  </validation-provider>
                </div>

                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-middlename"
                  >
                    Middlename
                  </label>
                  <input
                    id="grid-middlename"
                    v-model="newPersonalInfo.middlename"
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    type="text"
                    placeholder="Middlename"
                  >
                </div>

                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                  <validation-provider
                    v-slot="{ errors }"
                    rules="required"
                  >
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-lastname"
                    >
                      Lastname
                    </label>
                    <input
                      id="grid-lastname"
                      v-model="newPersonalInfo.lastname"
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      :class="{ 'border-red-400': errors.length > 0 }"
                      type="text"
                      placeholder="Lastname"
                    >
                    <span class="text-red-400 text-sm italic ">{{ errors[0] }}</span>
                  </validation-provider>
                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-6">
                <validation-provider
                  v-slot="{ errors }"
                  rules="required"
                  class="w-full"
                >
                  <div class=" px-3">
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-description"
                    >
                      About me
                    </label>
                    <textarea
                      id="grid-description"
                      v-model="newPersonalInfo.about"
                      rows="15"
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      type="password"
                      placeholder="Brief summary about yourself"
                      :class="{ 'border-red-400': errors.length > 0 }"
                    />
                    <p class="text-gray-600 text-xs italic -mt-3">
                      Brief about yourself
                    </p>
                    <span class="text-red-400 text-sm italic ">{{ errors[0] }}</span>
                  </div>
                </validation-provider>
              </div>
            </form>
          </ValidationObserver>
        </div>
        <!--footer-->
        <div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">
          <div>
            <button
              class="text-green-800 bg-transparent border border-solid border-green-900 hover:bg-green-900 hover:text-white active:bg-green-700 font-bold  text-sm px-4 py-2 rounded outline-none focus:outline-none mr-3 mb-1"
              type="button"
              style="transition: all .15s ease"
              @click="clearForm()"
            >
              Reset
            </button>
            <button
              class="bg-green-800 hover:bg-green-900 text-white font-medium px-4 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 rounded"
              type="button"
              style="transition: all .15s ease"
              @click="submitForm()"
            >
              Update
            </button>
          </div>
        </div> 
      </section>
    </main>
  </div> 
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import PersonalInfoApi from '../../api/personalInfo'
import store from '../../store'
export default {
  name: "NewPersonalInfo",
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data: function() {
    return {
      isLoading: false,
      fullPage: false,
      loader: "bars",
      url: null,
      newPersonalInfo: {
        'avatar': null,
        'firstname': "",
        'lastname': "",
        'middlename': "",
        'about': "",
      },
    };
  },
  methods: {
    clearForm(){
      this.newPersonalInfo = {
        'firstname': "",
        'lastname': "",
        'middlename': "",
        'about': "",
        'avatar': null,
      };
      this.url = null;
      this.$refs.avatarInput.value='';
      this.$refs.observer.reset();
    },
    async onFileChange(e) {
      const { valid } = await this.$refs.avatarProvider.validate(e);
      if (valid) {
        const file = e.target.files[0];
        this.newPersonalInfo.avatar = file
        this.url = URL.createObjectURL(file);
      }
    },
    async submitForm(){
      const isValid = await this.$refs.observer.validate();
      if (isValid) {
        this.isLoading = true;
        this.isLoading = false;
        let formData = this.getFormData();
        let _this = this;
        PersonalInfoApi.createPersonalInfo(formData)
          .then(function(response) {
            _this.isLoading = false
            _this.clearForm()
            return response.data
          }).then(data => {
            let notification = {notification: data.lastname + " added", type: "success"}
            store.dispatch('addNotification', notification)
            console.log(data)
            store.dispatch('personalInfoId', data.id)

          })
          .catch(err => console.log(err.response));
      }
    }, 
    getFormData(){
      let formData = new FormData()
      formData.append('avatar', this.newPersonalInfo.avatar)
      formData.append('firstname', this.newPersonalInfo.firstname)
      formData.append('middlename', this.newPersonalInfo.middlename)
      formData.append('lastname', this.newPersonalInfo.lastname)
      formData.append('about', this.newPersonalInfo.about)

      return formData;
    }
  }
};
</script>