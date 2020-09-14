<template>
  <!-- recent positions -->
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
            <i class="fas fa-user h-8 w-8" />
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
</template>

<script>
export default {
  name: "RecentPositions"
};
</script>