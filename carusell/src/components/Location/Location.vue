<template>
  <div v-if="!loading">
    <router-link to="/characters">Go back</router-link>
    <br>
    <br>
    <br>
    <h1>
      {{ location.name }}
    </h1>
    <p>
      <b>Type:</b>  {{location.type}} <br>
      <b>Dimension:</b>  {{location.dimension}} <br>
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
      location: {},
      loading: false
    }
  },
  beforeMount() {
    this.getData()
  },
  computed: {},
  methods: {
    getData() {
      if(!this.$route.params.name) {
        return
      }

      this.loading = true

      axios.get(`https://rickandmortyapi.com/api/location/?name=${this.$route.params.name}`).then((response) => {
        const {results} = response.data
        this.location = results[0]
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