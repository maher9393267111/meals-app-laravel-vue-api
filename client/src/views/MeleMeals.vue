<script lang="ts">
import MeleCategoryItem from "@/components/MeleCategoryItem.vue";
import { useNutrientStore } from "@/stores/nutrient";
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      nutrientStore: useNutrientStore(),
    };
  },
  components: { MeleCategoryItem },
  beforeMount() {
    this.nutrientStore.getMeals();
  },
});
</script>

<template>
  <main>
    <ul class="mele-list">
      <MeleCategoryItem
        v-for="(meal, index) in nutrientStore.meals"
        :key="`meal-${index}`"
        :data="meal"
      />
    </ul>
  </main>
</template>

<style lang="scss"></style>
