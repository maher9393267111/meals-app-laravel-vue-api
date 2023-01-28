<script lang="ts">
import MeleFavourites from "@/components/MeleFavourites.vue";
import MeleSearch from "@/components/MeleSearch.vue";
import { useNutrientStore } from "@/stores/nutrient";
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      nutrientStore: useNutrientStore(),
    };
  },
  components: { MeleFavourites, MeleSearch },
  beforeMount() {
    this.nutrientStore.getNutrients();
  },
});
</script>

<template>
  <main>
    <MeleFavourites />
    <MeleSearch />
  </main>
</template>

<style lang="scss"></style>
