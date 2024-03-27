import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export let searchHistory = defineStore('searchHistory', {
  state() {
    return {
      searchHistory: []
    }
  },
})
