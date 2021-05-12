<template>
  <h1 v-if="loading">Loading...</h1>
  <div v-if="!loading" class="wrapper">
    <button @click="removeIndex" :disabled="hasNoPrevItem">
      prev
    </button>
    <div class="card">
      <img width="500" height="500" :src="character.image" alt="">
      <h3>{{ character.name }}</h3>

      <button @click="setFavorites">
        {{ favorites[index] ? 'Remove from favorites' : 'Add to favorites' }}
      </button>
      <br><br>
      <router-link :to="`/character/${index}`">Go to character info page</router-link>
      <br><br>
      <router-link :to="`/characters`">Go to characters page</router-link>
    </div>
    <button @click="addIndex" :disabled="hasNoNextItem">
      next
    </button>
  </div>
  <div class="favorites">
    <div v-for="({image, name}, key) in favorites" class="favorite" :key="name">
      <img :src="image" :alt="name" class="favorite__image">
      <div class="favorite__text">
        <span class="favorite__innerText">
          {{name}}
        </span>
        <button class="favorite__remove" @click="removeFavorite(key)">
          Remove
        </button>
      </div>
    </div>
  </div>

</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
        index: 1,
        loading: false,
        character: {
          name: '',
          image: '',
        },
        favorites: {}
    }
  },
  beforeMount() {
    let index = 1

    if (localStorage.index) {
      index = parseInt(localStorage.index)
      this.index = index
    }

    if (localStorage.favorites) {
      this.favorites = JSON.parse(localStorage.favorites)
    }

    this.getData()
  },
  computed: {
    hasNoPrevItem() {
      return this.index <= 1
    },
    hasNoNextItem() {
      return this.index >= 671
    }
  },
  methods: {
    changeIndex(index) {
      this.index = index
      localStorage.index = index
    },
    getData() {
      this.loading = true

      axios.get(`https://rickandmortyapi.com/api/character/${this.index}`).then((response) => {
        const {name, image} = response.data

        this.character = {name, image}
        this.loading = false
      })
    },
    addIndex() {
      if(this.hasNoNextItem) {
        return
      }

      this.changeIndex(this.index + 1)
      this.getData()
    },
    removeIndex() {
      if(this.hasNoPrevItem) {
        return
      }

      this.changeIndex(this.index - 1)
      this.getData()
    },
    setFavorites() {

      if (this.favorites[this.index]) {
        this.removeFavorite(this.index)
        return
      }

      this.addFavorite()
    },
    addFavorite() {
      this.favorites[this.index] = this.character
      localStorage.favorites = JSON.stringify(this.favorites)
    },
    removeFavorite(key) {
      delete this.favorites[key]
      localStorage.favorites = JSON.stringify(this.favorites)
    }
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .wrapper {
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
  }
  .card {
    padding: 10px;
  }

  .favorites {
    display: flex;
    flex-wrap: wrap;
  }

  button {
    padding: 10px 15px;
    font-size: 20px;
    cursor: pointer;
  }

  .favorite {
    width: 100px;
    height: 100px;
    position: relative;
    margin: 10px;
    background-color: rgba(0,0,0,0.8);
    color: white;
    font-weight: bold;
  }

  .favorite__text {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .favorite__image {
    width: 100%;
  }

  .favorite__remove {
    display: none;
    font-size: 10px;
  }

  .favorite:hover .favorite__innerText {
    display: none;
  }

  .favorite:hover .favorite__remove {
    display: inline-block;
  }
</style>