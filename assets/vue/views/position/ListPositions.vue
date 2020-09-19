<template>
  <div>
    <loading-overlay
      :active="isLoading"
      :is-full-page="fullPage"
      :loader="loader"
    />

    <!-- main content -->
    <main class="min-h-0 border-t">
      <!-- section content -->
      <section
        class="w-full min-h-0 border-l border-r border-b"
      >
        <div class="search-form w-full pt-5 px-5">
          <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-sm px-3 mb-3">
              <input
                class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight border-gray-200 focus:outline-none focus:bg-white"
                type="text"
                placeholder="Search title"
              >
            </div>
            <div class="w-full max-w-sm px-3 mb-3">
              <input
                class="appearance-none block w-full bg-gray-200 text-gray-700 border-gray-200 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                type="text"
                placeholder="Search location"
              >
            </div>

            <div class="w-full px-3 md:px-0 sm:w-auto items-center flex md:-mt-3">
              <button class="bg-green-800 text-white active:bg-green-600 font-bold text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1">
                Search
              </button>
            </div>
          </div>
        </div>
        <!-- content caption -->
        <header class="bg-white border-t flex items-center py-3 px-4 mt-4 w-full">
          <div class="flex">
            <h2
              id="content-caption"
              class="font-semibold"
            >
              Advertised positions ({{ totalItems }})
            </h2>
          </div>
          <div class="ml-auto">
            <button
              class="bg-green-800 text-white active:bg-green-600 font-bold text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1"
              type="button"
              style="transition: all .15s ease"
              @click="toggleModal()" 
            >
              Add a new position
            </button>
          </div>
        </header>

        <div
          class="w-full px-3"
          style="overflow-y: auto"
        >
          <table
            class="border-t w-full min-h-0 table-auto border-collapse py-3"
          >
            <thead class="w-full px-4">
              <tr class="border-b w-full">
                <th class="font-semibold text-left py-3 px-1">
                  #
                </th>
                <th class="font-semibold text-left py-3 px-1">
                  Position
                </th>
                <th class="font-semibold text-left py-3 px-1">
                  Country
                </th>
                <th class="font-semibold text-left py-3 px-1">
                  Region/State
                </th>
                <th class="font-semibold text-left py-3 px-1">
                  Date Posted
                </th>
                <th class="font-semibold text-left py-3 px-1">
                  Deadline
                </th>
                <th class="font-semibold text-left py-3 px-1">
                  Action
                </th>
              </tr>
            </thead>
            <tbody class="w-full min-h-0 px-4">
              <tr
                v-for="(position, index) in items"
                :key="index"
                role="row"
                class="hover:bg-blue-100 border-b cursor-pointer"
              >
                <td class="py-3 px-1">
                  #{{ getSerialNumber(index) }}
                </td>
                <td class="py-3 px-1">
                  <div class="relative group w-full">
                    <p class="w-full truncate">
                      {{ position.name }}
                    </p>
                  </div>
                </td>
                <td class="py-3 px-1">
                  {{ position.country.name }}
                </td>
                <td class="py-3 px-1">
                  {{ position.state.name }}
                </td>
                <td class="py-3 px-1">
                  {{ dateFormat(position.date_posted) }}
                </td>
                <td class="py-3 px-1">
                  {{ dateFormat(position.deadline) }}
                </td>
                <td class="py-3 px-1">
                  <button class="focus:outline-none bg-blue-600 hover:bg-blue-700 text-white text-sm hover:text-white-700 py-2 px-4 rounded">
                    Apply
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <Pagination
          :page-count="Math.ceil(totalItems / perPage)"
          :current-page="allParams.page"
          @page-changed="fetchData"
        />
        <!-- content footer, currently hidden -->
        <footer
          aria-label="content footer"
          class="flex p-3 bg-white border-t hidden"
        >
          footer
        </footer>
      </section>
    </main>

    <!-- Create Staff Modal  -->
    <div
      v-if="showModal"
      class="overflow-x-hidden overflow-y-scroll fixed inset-0 z-50 outline-none focus:outline-none mt-0 md:mt-20"
    >
      <div class="relative w-auto my-6 mx-auto max-w-lg">
        <!--content-->
        <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
          <!--header-->
          <div class="flex items-start justify-between p-5 border-b border-solid border-gray-300 rounded-t">
            <h3 class="text-2xl font-medium">
              Advertise a new position
            </h3>
            <button
              class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
              @click="toggleModal()"
            >
              <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                ×
              </span>
            </button>
          </div>
          <!--body-->
          <div class="relative p-6 flex-auto w-full max-w-lg">
            <ValidationObserver
              ref="observer"
              slim
            >
              <form class="w-full max-w-lg">
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
                        rows="6"
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
            <button
              class="text-green-800 bg-transparent border border-solid border-green-900 hover:bg-green-900 hover:text-white active:bg-green-700 font-bold  text-sm px-4 py-2 rounded outline-none focus:outline-none mr-3 mb-1"
              type="button"
              style="transition: all .15s ease"
              @click="toggleModal()"
            >
              Close
            </button>
            <button
              class="bg-green-800 hover:bg-green-900 text-white font-medium px-4 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 rounded"
              type="button"
              style="transition: all .15s ease"
              @click="submitForm()"
            >
              Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      v-if="showModal"
      class="opacity-25 fixed inset-0 z-40 bg-black"
    />
  </div>
</template>

<script>
import CountryAPI from '../../api/country';
import PositionAPI from '../../api/position';
import { ValidationProvider, ValidationObserver } from 'vee-validate';
import Pagination from '../Pagination'
export default {
  name: "ListPositions",
  components: {
    ValidationProvider,
    ValidationObserver,
    Pagination
  },
  data: function() {
    return {
      allParams: { page: 1 },
      isLoading: false,
      fullPage: false,
      loader: "bars",
      countries: [],
      showModal: false,
      selectedCountryIndex: null,
      selectedStateIndex: null,
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
        this.getAllPositions();
      }
    }
  },
  mounted: function() {
    this.getAllCountries();
    this.getAllPositions();
  },
  methods: {
    toggleModal(){
      this.showModal = !this.showModal;
    },
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
    getAllPositions(page = 1) {
      this.allParams.page = page
      // console.log("fetching positions")
      PositionAPI.allPositions(this.allParams)
        .then(function(response) {
          return response.data;
        })
        .catch(err => console.log(err.response)).then(res => this.setPositionItems(res));

    },
    setPositionItems(positions) {
      this.items = positions["hydra:member"];
      this.totalItems = positions["hydra:totalItems"];

    },
    fetchData(page) {
      // Your AJAX or other code to display the data for the newly selected currentPage
      // this.currentPage = selectedPage
      this.getAllPositions(page)
    },
    getSerialNumber(index) {
      return (index + 1) + ((this.allParams.page - 1) * this.perPage);

    },
    async submitForm(){
      // this.newPosition.deadline = moment(this.date).format('YYYY-MM-DD');

      const isValid = await this.$refs.observer.validate();
      if (isValid) {
        this.isLoading = true;
        let _this = this;
        PositionAPI.newPosition(this.newPosition)
          .then(function(response) {
            console.log(response)
            _this.items.unshift(response.data)
            _this.totalItems++
            _this.isLoading = false
            _this.showModal = false
            return response.data;
          })
          .catch(err => console.log(err));
      }

    }
  }
};
</script>