<template>
  <Line :data="data" :options="options" v-if="dataLoaded" />
  <div v-else>Loading...</div>
</template>

<script lang="ts">
import axios from 'axios';
import { apiLink } from '../config.js';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

export default {
  name: 'App',
  components: {
    Line
  },
  data() {
    return {
      data: {
        labels: [],
        datasets: [
          {
            label: 'Price',
            backgroundColor: '#FFBE0B',
            borderColor: '#FFBE0B', // Change the line color here
            data: []
          }
        ]
      },
      options: {},
      dataLoaded: false
    }
  },
  beforeMount() {
    this.loadGraphData()
  },
  methods: {
    loadGraphData() {
      axios.post(apiLink + "/api/getPriceHistory", { slug: this.$route.params.slug })
        .then(({ data }) => {

          data = data.reverse()
          data.forEach(element => {
            this.data.labels.unshift(element.label)
            this.data.datasets[0].data.unshift(element.y)
          });
          this.dataLoaded = true;
        })
        .catch(error => {
          console.error('Error loading graph data:', error);
        });
    }
  }
}
</script>
