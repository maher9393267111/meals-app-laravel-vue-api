<script lang="ts">
import { defineComponent } from "vue";
import { useNutrientStore } from "@/stores/nutrient";
import MeleNutrientItem from "@/components/MeleNutrientItem.vue";
import type { Meal, Nutrient } from "@/types/types";
type Food = Nutrient | Meal;

export default defineComponent({
  data() {
    return {
      nutrientStore: useNutrientStore(),
    };
  },
  computed: {
    extractNutrientsFromBasket(): Array<Nutrient> {
      let nutrients = this.nutrientStore.basket as Array<Nutrient>;
      return nutrients.filter((item: Food) => {
        if ("unit" in item) {
          return item;
        } else return null;
      });
    },
  },
  components: { MeleNutrientItem },
});
</script>

<template>
  <main>
    <h1>Basket</h1>
    <ul class="mele-list">
      <MeleNutrientItem
        v-for="(nutrient, index) in extractNutrientsFromBasket"
        :key="`nutrient-${index}`"
        :data="nutrient"
        :removable="true"
        :with-carbs="true"
      >
        {{ nutrient.name }}
      </MeleNutrientItem>
    </ul>
  </main>
</template>

<style lang="scss">
$list: ".mele-basket";
</style>
