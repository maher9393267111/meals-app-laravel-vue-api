<script lang="ts">
import { useNutrientStore } from "@/stores/nutrient";
import type MeleBasketVue from "@/views/MeleBasket.vue";
import type MeleHomeVue from "@/views/MeleHome.vue";
import { defineComponent } from "vue";
import IconApple from "./icons/IconApple.vue";
import IconCalculator from "./icons/IconCalculator.vue";
import IconNoodles from "./icons/IconNoodles.vue";

export default defineComponent({
  data() {
    return {
      nutrientStore: useNutrientStore(),
    };
  },
  components: { IconApple, IconCalculator, IconNoodles },
});
</script>

<template>
  <nav class="mele-nav">
    <router-link to="/"><IconApple /></router-link>
    <router-link to="/basket"
      ><div class="mele-nav__calculator">
        <IconCalculator />
        <span class="mele-nav__counter">{{ nutrientStore.basket.length }}</span>
      </div></router-link
    >
    <router-link to="/meals"><IconNoodles /></router-link>
  </nav>
</template>

<style lang="scss">
$c: ".mele-nav";

#{$c} {
  align-items: center;
  background-color: rgba($color: #000000, $alpha: 0.6);
  bottom: 0;
  display: flex;
  justify-content: space-around;
  height: 80px;
  left: 0;
  position: fixed;
  width: 100%;

  svg {
    fill: rgba($color: #fff, $alpha: 0.8);
    height: 50px;
  }

  &__calculator {
    position: relative;
  }

  &__counter {
    align-items: center;
    background-color: rgba($color: #fff, $alpha: 0.8);
    border-radius: 50%;
    display: flex;
    font-size: 1rem;
    height: 20px;
    justify-content: center;
    position: absolute;
    right: 0;
    top: 0;
    width: 20px;
  }
}
</style>
