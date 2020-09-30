<template>
  <div>
    <!-- main content -->
    <main class="min-h-0">
      <!-- section content -->
      <section class="w-full min-h-0 bg-white w-full mb-6 shadow rounded">
        <header class="border-blue-800 border-b-2 bg-white rounded-t flex items-center p-10 mt-4 w-full">
          <div class="flex flex-wrap w-full items-center ">
            <div class="w-1/2">
              <h2
                id="content-caption"
                class="font-semibold text-xl w-full"
              >
                {{ position.title }}
              </h2>
              <span class="block w-full text-sm text-gray-700">Posted On {{ dateFormat(position.created_at) }}</span>
            </div>
            <div class="w-1/2">
              <div class="flex flex-wrap justify-end text-xl font-medium">
                <i
                  class="fas fa-map-marker-alt mr-3 mt-1 text-gray-600"
                  aria-hidden="true"
                />
                <span
                  v-if="position.state != null"
                  class="inline-block mr-1"
                >{{ position.state.name }},</span>
                <span v-if="position.country != null"> {{ position.country.name }}</span>
                <span class="text-sm text-gray-600 w-full justify-end flex"> Location</span>
              </div>
            </div>
          </div>
        </header>
        <div class="content flex flex-wrap px-5 bg-gray-100">
          <div
            class="desc w-full p-5"
          >
            <p
              style="min-height: 400px"
              class="leading-normal text-md whitespace-pre-line"
            >
              {{ position.description }}
            </p>

            <h3 class="text-lg font-medium mt-5">
              Deadline
            </h3>
            <p> {{ dateFormat(position.deadline) }}</p>
          </div>

          <div class="actions w-full m-5">
            <button class="bg-green-700 text-white hover:bg-green-600 active:bg-green-600 font-bold text-lg uppercase px-6 py-3 rounded  outline-none focus:outline-none mr-3 mb-1">
              <i class="fas fa-clipboard-check mr-3" />
              <span>Apply</span>
            </button>
            <router-link
              v-if="position.id"
              class="bg-orange-700 text-white hover:bg-orange-600 active:bg-green-600 font-bold text-lg uppercase px-6 py-3 rounded  outline-none focus:outline-none mr-3 mb-1"
              :to="{ name: 'update-position', params: { id: position.id }}"
              type="button"
              style="transition: all .15s ease"
            >
              <i class="fas fa-pen-square mr-3" />
              <span>Update</span>
            </router-link>
          </div>
        </div>
      </section>
    </main>
  </div> 
</template>

<script>
import PositionAPI from '../../api/position';
export default {
  name: "ShowPosition",
  data: function() {
    return {
      position: {
        'id': null,
        'title': null,
        'country': null,
        'state': null,
        'deadline': null,
        'description': null,
        'created_at': null,
      },
    };
  },
  mounted: function() {
    this.getPosition(this.$route.params.id);
  },
  methods: {
    getPosition(id) {
      PositionAPI.singlePosition(id)
        .then(function(response) {
          return response.data;
        })
        .catch(err => console.log(err)).then(res => this.setPosition(res));
    },
    setPosition(res){
      this.position.title = res.name
      let deadline = new Date(res.deadline)
      let position = {id: res.id, title: res.name, country: res.country, state: res.state, deadline: deadline, description: res.description, created_at: new Date(res.date_posted)}
      this.position = position
      document.title = res.name + " - Job Portal"
    }
  }
};
</script>