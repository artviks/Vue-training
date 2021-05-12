<template>
  <div v-if="!loading">
    <router-link to="/">Go to Slider</router-link>
    <br>
    <br>
    <br>
    <img width="100" :src="character.image" alt="">

    <h1>
      {{ character.name }}
    </h1>

      <b>Species:</b>  {{character.species}} <br>
      <b>Gender:</b>  {{character.gender}} <br>
      <b>Location:</b> <router-link :to="`/location/${character.location.name}`">{{ character.location.name }}</router-link> <br>
      <div class="dropdown">
        <button class="dropbtn">Episodes</button>
        <div class="dropdown-content">
          <router-link v-for="episode in character.episode" :key="episode" :to="`/episode/${showNumber(episode)}`">{{showNumber(episode)}}</router-link>
        </div>
      </div>
    <br><br><br>

    <router-link :to="`/character/1`">Go to first character</router-link>
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
      character: {},
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

      axios.get(`https://rickandmortyapi.com/api/character/${this.$route.params.id}`).then((response) => {
        this.character = response.data
        this.loading = false
      })
    },
    showNumber(episode) {
      return episode.split('/').pop()
    }
  },
  watch: {
    '$route.params.id'() {
      console.log(123)
      this.getData()
    }
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.dropbtn {
  background-color: gray;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 100px;
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 10px 10px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: black;}

</style>
