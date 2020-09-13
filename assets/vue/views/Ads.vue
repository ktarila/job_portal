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
      <!-- section update to tickets -->
      <section class="md:flex flex-wrap p-4 hidden w-1/4 max-w-sm bg-gray-100 min-h-0 overflow-auto">
        <h1 class="font-semibold mb-3">
          Recent Positions
        </h1>
        <ul>
          <li>
            <article
              tabindex="0"
              class="cursor-pointer border rounded-md p-3 bg-white flex text-gray-700 mb-2 hover:border-orange-500 focus:outline-none focus:border-orange-500"
            >
              <span class="flex-none pt-1 pr-2">
                <img
                  class="h-8 w-8 rounded-md"
                  src="https://raw.githubusercontent.com/bluebrown/tailwind-zendesk-clone/master/public/assets/avatar.png"
                >
              </span>
              <div class="flex-1">
                <header class="mb-1">
                  Tarun T <span class="font-semibold">commented</span> on
                  <h1 class="inline">
                    "RE: WPMS issue".
                  </h1>
                </header>
                <p class="text-gray-600">
                  Hi Mazhar, Please note this issue comes when user is not
                  closing or logout sy…
                </p>
                <footer class="text-gray-500 mt-2 text-sm">
                  Friday 22:16
                </footer>
              </div>
            </article>
          </li>
        </ul>
      </section>

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
              <button class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 border border-gray-400 rounded">
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
              class="focus:outline-none border rounded-md px-3 py-2 leading-none bg-green-600 hover:bg-green-700 text-white"
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
                  Date
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
  </div>
</template>

<script>
export default {
  name: "Ads"
};
</script>