<script lang="ts">
import { useNutrientStore } from "@/stores/nutrient";
import type { Nutrient } from "@/types/types";
import { defineComponent } from "vue";
import IconMagnify from "./icons/IconMagnify.vue";
import MeleNutrientItem from "./MeleNutrientItem.vue";

export default defineComponent({
  data() {
    return {
      nutrientStore: useNutrientStore(),
      searchInput: "",
    };
  },
  computed: {
    filteredNutrients(): Array<Nutrient> {
      const pattern = new RegExp(this.searchInput.toLocaleLowerCase(), "g");
      return this.nutrientStore.nutrients.filter((nutrient: Nutrient) => {
        return pattern.test(nutrient.name.toLocaleLowerCase());
      });
    },
  },
  components: { MeleNutrientItem, IconMagnify },
});
</script>

<template>
  <div class="mele-search container">
    <input
      class="mele-search__input"
      v-model="searchInput"
      placeholder="Search nutrient"
    />
    <IconMagnify class="mele-search__icon" />
  </div>
  <MeleNutrientItem
    v-for="(nutrient, index) in filteredNutrients.slice(0, 20)"
    :key="`nutrient-${index}`"
    :data="nutrient"
    :addable="true"
    :loveable="true"
  />
  <p class="container my-5">Showing 20 of {{ filteredNutrients.length }}</p>
</template>

<style lang="scss">
$c: ".mele-search";
#{$c} {
  margin: 2rem 0;
  position: relative;

  &__input {
    border: 2px solid var(--color-text);
    border-radius: 20px;
    font-size: 1.2rem;
    padding: 0.5rem 3rem;
    width: 100%;

    &:focus-visible {
      outline: var(--mele-red) auto 1px;
      + .mele-search__icon {
        fill: var(--mele-red);
      }
    }
  }

  &__icon {
    position: absolute;
    left: 2rem;
    height: 70%;
    top: 15%;
  }
}
</style>
