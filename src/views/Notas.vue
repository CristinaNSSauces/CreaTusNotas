<template>
  <div class="notas">
    <h1>Lista de notas</h1>
    <TablaNotas/>
  </div>
</template>

<script>
// @ is an alias to /src
import TablaNotas from '@/components/TablaNotas.vue';
export default {
  name: 'notas',
  components: {
    TablaNotas
  }
}
</script>

<style scoped>
  .home{
    width:100%;
    height:55%;
    display: flex;
    justify-content: center;
  }
</style>