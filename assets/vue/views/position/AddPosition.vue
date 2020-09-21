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
        <header class="bg-white border-t flex items-center py-3 px-4 mt-4 w-full">
          <div class="flex">
            <h2
              id="content-caption"
              class="font-semibold text-lg"
            >
              Advertise a new position
            </h2>
          </div>
          <div class="ml-auto">
            <router-link
              class="bg-green-700 text-white hover:bg-green-600 active:bg-green-600 font-bold text-sm px-6 py-3 rounded  outline-none focus:outline-none mr-1 mb-1"
              to="/ads"
              type="button"
              style="transition: all .15s ease"
            >
              All Positions
            </router-link>
          </div>
        </header>
        <div class="relative p-6 flex-auto w-full mx-auto">
          <ValidationObserver
            ref="observer"
            slim
          >
            <form class="w-full">
              <div class="flex flex-wrap mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <validation-provider
                    v-slot="{ errors }"
                    rules="required"
                  >
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-job-title"
                    >
                      Job Title
                    </label>
                    <input
                      id="grid-job-title"
                      v-model="newPosition.title"
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      :class="{ 'border-red-400': errors.length > 0 }"
                      type="text"
                      placeholder="Job Title"
                    >
                    <span class="text-red-400 text-sm italic ">{{ errors[0] }}</span>
                  </validation-provider>
                </div>
                <div class="w-full md:w-1/2 px-3">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-deadline"
                  >
                    Deadline
                  </label>
                  <v-date-picker
                    v-model="newPosition.deadline"
                    :input-props="{
                      class: &quot;appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500&quot;,
                      placeholder: &quot;Deadline&quot;,
                      readonly: true
                    }"
                    mode="single"
                    show-caps
                  />
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
                      Description
                    </label>
                    <textarea
                      id="grid-description"
                      v-model="newPosition.description"
                      rows="15"
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      type="password"
                      placeholder="Description"
                      :class="{ 'border-red-400': errors.length > 0 }"
                    />
                    <p class="text-gray-600 text-xs italic -mt-3">
                      Job Description
                    </p>
                    <span class="text-red-400 text-sm italic ">{{ errors[0] }}</span>
                  </div>
                </validation-provider>
              </div>
              <div class="flex flex-wrap -mx-3 mb-2">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <validation-provider
                    v-slot="{ errors }"
                    rules="required"
                  >
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-country"
                    >
                      Country
                    </label>
                    <div class="relative">
                      <select
                        id="grid-country"
                        v-model="selectedCountryIndex"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        :class="{ 'border-red-400': errors.length > 0 }"
                        @change="changeCountry($event)"
                      >
                        <option
                          v-for="(country, index) in countries"
                          :key="index"
                          :value="index"
                        >
                          {{ country.name }}
                        </option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg
                          class="fill-current h-4 w-4"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                        ><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                      </div>
                    </div>
                    <span class="text-red-400 text-sm italic ">{{ errors[0] }}</span>
                  </validation-provider>
                </div> 
                <div
                    
                  class="w-full md:w-1/2 px-3 mb-6 md:mb-0"
                >
                  <validation-provider
                    v-slot="{ errors }"
                    rules="required"
                  >
                    <label
                      class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-state"
                    >
                      State/Region
                    </label>
                    <div class="relative">
                      <select
                        v-if="selectedCountryIndex != null"
                        id="grid-state"
                        v-model="selectedStateIndex"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        :class="{ 'border-red-400': errors.length > 0 }"
                        @change="changeState($event)"
                      >
                        <option
                          v-for="(state, index) in currentStates"
                          :key="state.id"
                          :value="index"
                        >
                          {{ state.name }}
                        </option>
                      </select>
                      <select
                        v-else
                        id="grid-state"
                        v-model="selectedStateIndex"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        :class="{ 'border-red-400': errors.length > 0 }"
                      />
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg
                          class="fill-current h-4 w-4"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                        ><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                      </div>
                    </div>
                    <span class="text-red-400 text-sm italic ">{{ errors[0] }}</span>
                  </validation-provider>
                </div>
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
              Add Postion
            </button>
          </div>
        </div> 
      </section>
    </main>
  </div> 
</template>

<script>
import CountryAPI from '../../api/country';
import PositionAPI from '../../api/position';
import { ValidationProvider, ValidationObserver } from 'vee-validate';
import store from '../../store'
export default {
  name: "AddPosition",
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data: function() {
    return {
      allParams: { page: 1, name: "", country: "" },
      isLoading: false,
      fullPage: false,
      loader: "bars",
      countries: [],
      selectedCountryIndex: null,
      selectedStateIndex: null,
      searchCountry: null,
      newPosition: {
        'title': null,
        'country': null,
        'state': null,
        'deadline': new Date(),
        'description': null,
      },
      fields: ['S/No', 'title', 'country', 'state', 'deadline', 'actions'],
      items: [],
      perPage: 10,
      totalItems: 0,
    };
  },
  computed: {
    currentStates() {
      return this.countries[this.selectedCountryIndex].states
    }
  },
  watch: {
    currentPage: {
      handler: function(value) {
        console.log(value)
        this.allParams.page = value;
      }
    }
  },
  mounted: function() {
    this.getAllCountries();
  },
  methods: {
    changeCountry(event){
      let countryIndex = event.target.value;
      this.newPosition.country = this.countries[countryIndex];
      this.selectedStateIndex = null;
      this.newPosition.state = null;
    },
    changeState(event){
      let stateIndex = event.target.value;
      if (stateIndex >= 0 && this.newPosition.country != null && this.newPosition.country.states.length >= stateIndex)
      {
        this.newPosition.state = this.newPosition.country.states[stateIndex];

      } else {
        this.newPosition.state = null
      }
    },
    getAllCountries() {
      CountryAPI.allCountries()
        .then(function(response) {
          return response.data;
        })
        .catch(err => console.log(err)).then(res => this.setCountries(res));
    },
    setCountries(countries) {
      this.countries = countries["hydra:member"];
    },
    clearForm(){
      this.newPosition = {
        'title': null,
        'country': null,
        'state': null,
        'deadline': new Date(),
        'description': null,
      };
      this.selectedCountryIndex= null
      this.selectedStateIndex= null
      this.$refs.observer.reset();

    },
    async submitForm(){
      const isValid = await this.$refs.observer.validate();
      if (isValid) {
        this.isLoading = true;
        let _this = this;
        PositionAPI.newPosition(this.newPosition)
          .then(function(response) {
            _this.isLoading = false
            _this.showModal = false
            _this.clearForm()
            return response.data
          }).then(data => {
            let notification = {notification: data.name + " added", type: "success"}
            store.dispatch('addNotification', notification)

          })
          .catch(err => console.log(err));
      }
    }
  }
};
</script>