<script lang="ts">
import { defineComponent } from "vue";
import type { PropType } from "vue";
import type { Nutrient } from "@/types/types";
import IconFavourite from "./icons/IconFavourite.vue";
import { useNutrientStore } from "@/stores/nutrient";
import IconPlus from "./icons/IconPlus.vue";
import IconMinus from "./icons/IconMinus.vue";

export default defineComponent({
  props: {
    data: {
      // provide more specific type to `Object`
      type: Object as PropType<Nutrient>,
      required: true,
    },
    draggable: {
      type: Boolean,
      default: false,
    },
    addable: {
      type: Boolean,
      default: false,
    },
    loveable: {
      type: Boolean,
      default: false,
    },
    removable: {
      type: Boolean,
      default: false,
    },
    withCarbs: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      active: false,
      isFavourite: false,
      nutrientStore: useNutrientStore(),
    };
  },
  components: { IconFavourite, IconPlus, IconMinus },
  methods: {
    addFavourite() {
      this.isFavourite = !this.isFavourite;
      this.nutrientStore.toggleFavourite(this.data);
    },
    drop(e: TouchEvent) {
      this.$emit("drop", e);
    },
    drag(e: TouchEvent) {
      this.$emit("drag", e);
    },
    addToBasket() {
      this.active = true;
      this.nutrientStore.addNutrientToBasket(this.data);
    },
    removeFromBasket() {
      this.active = false;
      this.nutrientStore.removeNutrientFromBasket(this.data);
    },
  },
});
// v-on="enableClick ? { click: () => clickHandler(params) } : {}"
</script>
<template>
  <li
    class="mele-list__item"
    :class="{ 'mele-list__item--active': active }"
    @touchmove.self="drag"
    @touchend.self="drop"
  >
    <IconMinus
      v-if="(addable && active) || removable"
      @click="removeFromBasket"
      class="mele-list__action"
    />
    <IconPlus
      v-if="addable && !active"
      @click="addToBasket"
      class="mele-list__action"
    />
    <span class="mele-list__label">{{ data.name }}</span>
    <IconFavourite
      v-if="loveable"
      @click="addFavourite"
      class="mele-list__action"
      :class="{ 'mele-list__action--active': data.favourite_order !== null }"
    />
    <span v-if="withCarbs">{{
      `${data.carbs_in_hundred}kh / 100${data.unit}`
    }}</span>
  </li>
</template>

<style lang="scss">
$c: ".mele-list";
#{$c} {
  padding-left: 0;

  &__item {
    align-items: center;
    background-color: var(--color-heading);
    border-bottom: 2px solid var(--color-text);
    color: var(--color-text);
    cursor: pointer;
    display: flex;
    height: 45px;
    justify-content: space-between;
    padding: 0.5rem 1rem;
    text-align: left;
    width: 100%;
    -webkit-tap-highlight-color: transparent;
    z-index: 99;
    transition: font-size 0.5s ease-in-out;

    &--active {
      font-size: 1.5rem;
    }

    * {
      pointer-events: none;
    }
  }

  &__label {
    flex-grow: 1;
    margin-left: 1rem;
  }

  &__action {
    line-height: 0;
    fill: var(--mele-hightlight);
    pointer-events: all;
    &--active {
      fill: var(--mele-red);
    }
  }

  .mele-list--inset & {
    background-color: var(--color-background);
    border-bottom: 1px solid var(--vt-c-indigo);
    color: var(--color-text);
  }
}

.drop-placeholder {
  position: relative;
  margin-top: 45px;
  z-index: 1;
  &::after {
    content: "";
    height: 45px;
    width: 100%;
    position: absolute;
    top: -45px;
    left: 0;
    background-color: grey;
  }

  &--bottom {
    margin-top: 0;
    margin-bottom: 45px;
    &::after {
      top: 45px;
    }
  }
}
</style>
