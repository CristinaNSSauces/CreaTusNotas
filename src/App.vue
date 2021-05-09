<template>
  <div id="nav">
    <!-- <router-link to="/">Crear Nota</router-link> |
    <router-link to="/notas">Notas</router-link> -->
  </div>
  <router-view/>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
#app {
  font-family: 'Roboto', sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  width: 100%;
  height: 100%;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
</style>
