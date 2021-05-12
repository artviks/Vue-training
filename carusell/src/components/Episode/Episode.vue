<template>
  <div v-if="!loading">
    <router-link to="/characters">Go to characters</router-link>
    <br>
    <br>
    <br>
    <h1>
      {{ episode.name }}
    </h1>
    <p>
      <b>Air date:</b>  {{episode.air_date}} <br>
      <b>Episode:</b>  {{episode.episode}} <br>
    </p>
    <br><br>
    <router-link :to="`/`">Go to slider</router-link>
  </div>
  <h1 v-if="loading">
    Loading....
  </h1>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      episode: {},
      loading: false
    }
  },
  beforeMount() {
    this.getData()
  },
  computed: {},
  methods: {
    getData() {
      if(!this.$route.params.id) {
        return
      }

      this.loading = true

      axios.get(`https://rickandmortyapi.com/api/episode/${this.$route.params.id}`).then((response) => {
        this.episode = response.data
        this.loading = false
      })
    },
  },
  watch: {},
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>