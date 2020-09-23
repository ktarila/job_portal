<template>
  <div>
    <!-- main content -->
    <main class="min-h-0 border-t">
      <!-- section content -->
      <section class="w-full min-h-0 border-l border-r border-b">
        <div class="search-form w-full pt-5 px-5">
          <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-sm px-3 mb-3">
              <input
                v-model="allParams.name"
                class="block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight border-gray-200 focus:outline-none focus:bg-white"
                type="text"
                placeholder="Search title"
              >
            </div>
            <div class="w-full max-w-sm px-3 mb-3">
              <select
                id="search-country"
                v-model="allParams.country"
                class="block w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              >
                <option
                  value=""
                  disabled
                  selected
                >
                  Filter by country
                </option>
                <option
                  v-for="(country, index) in countries"
                  :key="index"
                  :value="country.id"
                >
                  {{ country.name }}
                </option>
              </select>
            </div>
            <div class="w-full px-3 md:px-0 sm:w-auto items-center flex md:-mt-3">
              <button
                class="bg-green-700 text-white hover:bg-green-600 active:bg-green-600 font-bold text-sm px-6 py-3 rounded  outline-none focus:outline-none mr-1 mb-1"
                @click="performSearch"
              >
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
            <router-link
              class="bg-green-700 text-white hover:bg-green-600 active:bg-green-600 font-bold text-sm px-6 py-3 rounded  outline-none focus:outline-none mr-1 mb-1"
              to="/ads/new"
              type="button"
              style="transition: all .15s ease"
            >
              Add Position
            </router-link>
          </div>
        </header>
        <div
          class="w-full px-3"
          style="overflow-y: auto"
        >
          <table class="border-t w-full min-h-0 table-auto border-collapse py-3">
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
                @click="showPosition(position.id)"
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
                    <i class="fas fa-clipboard-check mr-3" />
                    <span>Apply</span>
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
          class="flex p-3 bg-white border-t"
        >
          footer
        </footer>
      </section>
    </main>
  </div>
</template>
<script>
import CountryAPI from '../../api/country';
import PositionAPI from '../../api/position';
import Pagination from '../Pagination'
export default {
  name: "ListPositions",
  components: {
    Pagination
  },
  data: function() {
    return {
      allParams: { page: 1, name: "", country: "" },
      countries: [],
      showModal: false,
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
    toggleModal() {
      this.showModal = !this.showModal;
    },
    changeCountry(event) {
      let countryIndex = event.target.value;
      this.newPosition.country = this.countries[countryIndex];
      this.selectedStateIndex = null;
      this.newPosition.state = null;
    },
    changeState(event) {
      let stateIndex = event.target.value;
      if (stateIndex >= 0 && this.newPosition.country != null && this.newPosition.country.states.length >= stateIndex) {
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
    performSearch() {
      // Your AJAX or other code to display the data for the newly selected currentPage
      // this.currentPage = selectedPage
      this.getAllPositions(1)
    },
    getSerialNumber(index) {
      return (index + 1) + ((this.allParams.page - 1) * this.perPage);

    },
    showPosition(id) {
      this.$router.push({ name: "show-position", params: { id: id } });
    },
  }
};
</script>