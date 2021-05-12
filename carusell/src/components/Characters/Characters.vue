<template>
  <div v-if="!loading">

    <br>

    <table>
      <tr>
        <th>Picture</th>
        <th>Name</th>
        <th>Species</th>
        <th>Gender</th>
        <th>Location</th>
      </tr>

      <tr v-for="character in characters" :key="character.id">
        <td><img width="50" :src="character.image" :alt="character.name"></td>
        <td><router-link :to="`/character/${character.id}`">{{ character.name }}</router-link></td>
        <td>{{ character.species }}</td>
        <td>{{ character.gender }}</td>
        <td><router-link :to="`/location/${character.location.name}`">{{ character.location.name }}</router-link></td>
      </tr>

    </table>
  </div>

  <button @click="getData(prevPage)" :disabled="hasNoPrevItem">
    Prev
  </button>
  <button @click="getData(nextPage)" :disabled="hasNoNextItem">
    Next
  </button>

  <h1 v-if="loading">
    Loading....
  </h1>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      characters: [],
      nextPage: `https://rickandmortyapi.com/api/character?page=1`,
      prevPage: null,
      loading: false
    }
  },
  beforeMount() {
    this.getData(this.nextPage)
  },
  computed: {
    hasNoPrevItem() {
      return ! this.prevPage
    },
    hasNoNextItem() {
      return ! this.nextPage
    }
  },
  methods: {
    getData(page) {

      this.loading = true

      axios.get(page).then((response) => {
        const {info, results} = response.data

        this.characters = results
        this.nextPage = info.next
        this.prevPage = info.prev

        this.loading = false
      })
    },
  },
  watch: {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>