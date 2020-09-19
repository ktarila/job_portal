<template>
  <div
    v-if="moreThanOnePage"
    class="flex flex-col items-center my-12"
  >
    <div class="flex text-gray-700">
      <div class="flex h-12 font-medium rounded-full bg-gray-200">
        <div 
          class="h-12 w-12 mr-1 flex justify-center items-center rounded-full bg-gray-200 cursor-pointer"
          @click="setCurrentPage(Math.max(1, currentPage - 1))"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="100%"
            height="100%"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-chevron-left w-6 h-6"
          >
            <polyline points="15 18 9 12 15 6" />
          </svg>
        </div>
        <div
          v-for="(page, index) in pages"
          :key="index"
          class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full"
          :class="getClass(page.number)"
        >
          <a
            v-if="page.number"
            class="hover:text-yellow-700"
            @click="setCurrentPage(page.number)"
          >
            {{ page.number }}
          </a><span v-if="pageNull(page)">...</span>
        </div>

        <div 
          class="h-12 w-12 ml-1 flex justify-center items-center rounded-full bg-gray-200 cursor-pointer"
          @click="setCurrentPage(Math.min(pageCount, currentPage + 1))"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="100%"
            height="100%"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-chevron-right w-6 h-6"
          >
            <polyline points="9 18 15 12 9 6" />
          </svg>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "Pagination",
  props: {
    currentPage: {
      required: true,
      type: Number
    },
    pageCount: {
      required: true,
      type: Number
    },
    ulClass: {
      default: 'pagination',
      type: String
    },
  },
  data: function () {
    return {
      pages: []
    };
  },
  computed: {
    moreThanOnePage() {
      // Whenever pageCount changes, it triggers the page divst to be rebuilt
      this.buildPageList();
      return this.pageCount > 1;
    }
  },
  methods: {
    buildPageList(page) {
      if (!page) {
        page = this.currentPage
      }
      this.pages = [];
      if (this.pageCount > 10) {
        if (page >= 7 &&  page < this.pageCount - 4) {
          this.makePagesRange(1, 2);
          this.pages.push({
            number: null
          });
          this.makePagesRange(page - 3, page + 3);
          this.pages.push({
            number: null
          });
          this.makePagesRange(this.pageCount - 1, this.pageCount);
        } else if (page < 7) {
          this.makePagesRange(1, 8);
          this.pages.push({
            number: null
          });
          this.makePagesRange(this.pageCount - 1, this.pageCount);
        } else if (page >= this.pageCount - 4) {
          this.makePagesRange(1, 2);
          this.pages.push({
            number: null
          });
          this.makePagesRange(this.pageCount - 5, this.pageCount);
        }
      } else {
        this.makePagesRange(1, this.pageCount);
      }
    },
    makePagesRange(x,y) {
      for (var i=x;i<=y;i++){
        this.pages.push({
          number: i
        });
      }
    },
    getClass(pageNumber) {
      if (pageNumber == this.currentPage) {
        return 'bg-teal-600 text-white';
      } else if (pageNumber == null) {
        return 'disabled';
      } else if (pageNumber == 'previous' && this.currentPage == 1) {
        return 'disabled';
      } else if (pageNumber == 'next' && this.currentPage == this.pageCount) {
        return 'disabled';
      } else {
        return 'clickable';
      }
    },
    pageNull(page) {
      return page.number == null;
    },
    setCurrentPage(newPage) {
      if (this.currentPage != newPage) {
        this.$emit('page-changed', newPage);
        this.buildPageList(newPage);
      }
    }
  }
}
</script>