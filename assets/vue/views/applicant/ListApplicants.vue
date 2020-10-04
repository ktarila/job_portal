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
                placeholder="Search surname"
              >
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
              All Applicant Profiles ({{ totalItems }})
            </h2>
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
                  Firstname
                </th>
                <th class="font-semibold text-left py-3 px-1">
                  Middlename
                </th>
                <th class="font-semibold text-left py-3 px-1">
                  Lastname
                </th>
                <th class="font-semibold text-left py-3 px-1">
                  Email
                </th>
                <th class="font-semibold text-left py-3 px-1">
                  Phone
                </th>
                <th
                  v-if="isLoggedIn()" 
                  class="font-semibold text-left py-3 px-1"
                >
                  Action
                </th>
              </tr>
            </thead>
            <tbody class="w-full min-h-0 px-4">
              <tr
                v-for="(applicant, index) in items"
                :key="index"
                role="row"
                class="hover:bg-blue-100 border-b cursor-pointer"
                @click="showApplicant(applicant.id)"
              >
                <td class="py-3 px-1">
                  #{{ getSerialNumber(index) }}
                </td>
                <td class="py-3 px-1">
                  <div class="relative group w-full">
                    <p class="w-full truncate">
                      {{ applicant.firstname }}
                    </p>
                  </div>
                </td>
                <td class="py-3 px-1">
                  {{ applicant.middlename }}
                </td>
                <td class="py-3 px-1">
                  {{ applicant.lastname }}
                </td>
                <td class="py-3 px-1">
                  {{ applicant.email }}
                </td>
                <td class="py-3 px-1">
                  {{ applicant.phone }}
                </td>
                <td
                  v-if="isLoggedIn()"
                  class="py-3 px-1"
                >
                  <button class="focus:outline-none bg-blue-600 hover:bg-blue-700 text-white text-sm hover:text-white-700 py-2 px-4 rounded">
                    <i class="fas fa-envelope mr-3" />
                    <span>Invite</span>
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
import PersonalInfoAPI from '../../api/personalInfo';
import Pagination from '../Pagination'
export default {
  name: "ListApplicants",
  components: {
    Pagination
  },
  data: function() {
    return {
      allParams: { page: 1, name: "", country: "" },
      items: [],
      perPage: 10,
      totalItems: 0,
    };
  },
  watch: {
    currentPage: {
      handler: function(value) {
        this.allParams.page = value;
        this.getAllApplicants();
      }
    }
  },
  mounted: function() {
    this.getAllApplicants();
  },
  methods: {
    getAllApplicants(page = 1) {
      this.allParams.page = page

      PersonalInfoAPI.allApplicants(this.allParams)
        .then(function(response) {
          return response.data;
        })
        .catch(err => console.log(err.response)).then(res => this.setApplicantItems(res));

    },
    setApplicantItems(positions) {
      this.items = positions["hydra:member"];
      this.totalItems = positions["hydra:totalItems"];

    },
    fetchData(page) {
      // Your AJAX or other code to display the data for the newly selected currentPage
      // this.currentPage = selectedPage
      this.getAllApplicants(page)
    },
    performSearch() {
      // Your AJAX or other code to display the data for the newly selected currentPage
      // this.currentPage = selectedPage
      this.getAllApplicants(1)
    },
    getSerialNumber(index) {
      return (index + 1) + ((this.allParams.page - 1) * this.perPage);

    },
    showApplicant(id) {
      console.log(id)
      this.$router.push({ name: "profile", query: { info_id: id } });
    },
  }
};
</script>