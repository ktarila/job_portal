<template>
  <div>
    <!-- section body header -->
    <header
      aria-label="page caption"
      class="flex-none flex h-16 bg-gray-100 border-t px-4 items-center"
    >
      <h1
        id="page-caption"
        class="font-semibold text-lg"
      >
        Dashboard
      </h1>
    </header>

    <!-- main content -->
    <main class="w-full flex-wrap flex min-h-0 border-t">
      <!-- recent positions -->
      <RecentPositions />
      

      <!-- section content -->
      <section
        aria-label="main content"
        class="w-full md:w-3/4 min-h-0 border-l"
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
              Advertised positions (6)
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
                role="row"
                class="hover:bg-blue-100 border-b cursor-pointer"
              >
                <td class="py-3 px-1">
                  #12534
                </td>
                <td class="py-3 px-1">
                  <div class="relative group w-full">
                    <p class="w-full truncate">
                      Web Developer.
                    </p>
                  </div>
                </td>
                <td class="py-3 px-1">
                  Nigeria
                </td>
                <td class="py-3 px-1">
                  Abuja
                </td>
                <td class="py-3 px-1">
                  14 July, 2020
                </td>
                <td class="py-3 px-1">
                  14 Nov, 2020
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
      class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex"
    >
      <div class="relative w-auto my-6 mx-auto max-w-3xl">
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
          <div class="relative p-6 flex-auto">
            <form class="w-full max-w-lg">
              <div class="flex flex-wrap mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-job-title"
                  >
                    Job Title
                  </label>
                  <input
                    id="grid-job-title"
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    type="text"
                    placeholder="Job Title"
                  >
                </div>
                <div class="w-full md:w-1/2 px-3">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-deadline"
                  >
                    Deadline
                  </label>
                  <input
                    id="grid-deadline"
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    type="text"
                    placeholder="Deadline"
                  >
                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-description"
                  >
                    Description
                  </label>
                  <textarea
                    id="grid-description"
                    rows="6"
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    type="password"
                    placeholder="Description"
                  />
                  <p class="text-gray-600 text-xs italic -mt-3">
                    Job Description
                  </p>
                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-2">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-country"
                  >
                    Country
                  </label>
                  <div class="relative">
                    <select
                      id="grid-country"
                      class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    >
                      <option>Nigeria</option>
                      <option>Algeria</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                      <svg
                        class="fill-current h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                      ><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                    </div>
                  </div>
                </div> 
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-state"
                  >
                    State/Region
                  </label>
                  <div class="relative">
                    <select
                      id="grid-state"
                      class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    >
                      <option>Abuja</option>
                      <option>Lagos</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                      <svg
                        class="fill-current h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                      ><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                    </div>
                  </div>
                </div>
              </div>
            </form>
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
              @click="toggleModal()"
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
import RecentPositions from './RecentPositions'
export default {
  name: "Ads",
  components: {
    RecentPositions,
  },
  data: function() {
    return {
      csrf: '',
      showModal: false
    };
  },
  mounted: function() {
    this.$data.csrf = this.$store.getters['getCsrfToken']
  },
  methods: {
    toggleModal(){
      this.showModal = !this.showModal;
    }
  }
};
</script>