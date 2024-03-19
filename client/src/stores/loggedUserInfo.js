import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export let userLogged = defineStore('userLogged', {
  state() {
    return {
      name: '',
      email: '',
      id: '',
      role: '',
      created_at: '',
      wishList: []
    }
  },

})
