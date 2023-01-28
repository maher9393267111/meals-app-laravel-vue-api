<script lang="ts">
import { defineComponent } from "vue";
import type { PropType } from "vue";
import type { Category, Meal } from "@/types/types";
import MeleNutrientItem from "./MeleNutrientItem.vue";

export default defineComponent({
  props: {
    data: {
      // provide more specific type to `Object`
      type: Object as PropType<Category | Meal>,
      required: true,
    },
  },
  data() {
    return {
      active: false,
    };
  },
  components: { MeleNutrientItem },
});
</script>

<template>
  <div>
    <li @click="active = !active" class="mele-list__item">
      <span>{{ data.name }}</span>
    </li>

    <Transition name="roll-out">
      <ul
        v-if="data.nutrients"
        v-show="active"
        class="mele-list mele-list--inset"
      >
        <MeleNutrientItem
          v-for="(nutrient, nutIndex) in data.nutrients"
          :key="`nutrient-${nutIndex}`"
          :data="nutrient"
        />
      </ul>
    </Transition>
  </div>
</template>

<style lang="scss">
.mele-list--inset {
    max-height: calc(10 * 45) + px;
}
.roll-out-enter-active {
  transition: all 0.5s ease-out;
}

.roll-out-leave-active {
  transition: all 0.5s ease-in;
}

.roll-out-enter-from,
.roll-out-leave-to {
  opacity: 0;
  max-height: 0px;
}
</style>
