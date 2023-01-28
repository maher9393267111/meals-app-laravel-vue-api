<script lang="ts">
import MeleNutrientItem from "@/components/MeleNutrientItem.vue";
import { useNutrientStore } from "@/stores/nutrient";
import type { Maybe, Nutrient } from "@/types/types";
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      nutrientStore: useNutrientStore(),
      dragging: false,
      underlyingElementIndex: null as Maybe<number>,
      startPosition: 0,
    };
  },
  watch: {
    dragging(state: boolean) {
      if (state) {
        document.body.style.overflowY = "hidden";
      } else {
        document.body.style.overflowY = "";
      }
    },
  },
  computed: {
    favourites(): Array<Nutrient> {
      return this.nutrientStore.favourites;
    },
  },
  methods: {
    drop(e: TouchEvent, nutrient: Nutrient, index: number) {
      this.dragging = false;
      const target = e.target as HTMLLIElement;
      const favourites = target.parentNode?.children as HTMLCollection;
      const underLyingElementIndex = this.getUnderlyingElementIndex(e, index);
      target.style.position = "";
      target.style.top = "";
      const positionDiff = this.startPosition
        ? this.startPosition - e.changedTouches[0].pageY
        : 0;
      this.startPosition = 0;
      if (positionDiff < -10 || positionDiff > 35) {
        this.favourites.splice(
          this.nutrientStore.favourites.indexOf(nutrient),
          1
        );
        if (underLyingElementIndex < 0) {
          this.favourites.unshift(nutrient);
        } else if (underLyingElementIndex > favourites.length - 1) {
          this.favourites.push(nutrient);
        } else if (underLyingElementIndex < index) {
          this.favourites.splice(underLyingElementIndex, 0, nutrient);
        } else {
          this.favourites.splice(underLyingElementIndex - 1, 0, nutrient);
        }
        this.nutrientStore.updateFavouriteOrder();
      }

      for (let i = 0; i < favourites.length; i++) {
        favourites[i].classList.remove("drop-placeholder");
        favourites[i].classList.remove("drop-placeholder--bottom");
      }
    },
    drag(e: TouchEvent, index: number) {
      this.startPosition = this.startPosition
        ? this.startPosition
        : e.changedTouches[0].pageY;

      this.dragging = true;
      const target = e.target as HTMLLIElement;
      const favourites = target.parentNode?.children as HTMLCollection;
      const underLyingElementIndex = this.getUnderlyingElementIndex(e, index);
      target.style.position = "absolute";
      target.style.top = e.changedTouches[0].pageY + "px";
      for (let i = 0; i < favourites.length; i++) {
        favourites[i].classList.remove("drop-placeholder");
        favourites[i].classList.remove("drop-placeholder--bottom");
      }
      if (underLyingElementIndex > favourites.length) {
        favourites[
          favourites.length - 1 === index ? index - 1 : favourites.length - 1
        ].classList.add("drop-placeholder", "drop-placeholder--bottom");
      } else if (underLyingElementIndex < 0) {
        favourites[0 === index ? 1 : 0].classList.add("drop-placeholder");
      } else {
        favourites[underLyingElementIndex].classList.add("drop-placeholder");
      }
    },
    getUnderlyingElementIndex(e: TouchEvent, index: number): number {
      const target = e.target as HTMLLIElement;
      const favourites = target.parentNode?.children as HTMLCollection;
      const count = target.parentNode!.children.length - 1;
      const draggedFromTop = e.changedTouches[0].clientY;
      const elementDimensions =
        favourites[index === 0 ? 1 : 0].getBoundingClientRect();

      if (draggedFromTop < elementDimensions.top + elementDimensions.height / 2)
        return -1;

      for (let i = 0; i <= count; i++) {
        const elementDimensions = favourites[i].getBoundingClientRect();
        if (i === index) continue;
        if (
          draggedFromTop <
          elementDimensions.top + elementDimensions.height / 2
        ) {
          return i;
        }
      }
      return favourites.length + 1;
    },
  },
  components: { MeleNutrientItem },
});
</script>

<template>
  <ul class="mele-list">
    <MeleNutrientItem
      v-for="(nutrient, index) in favourites"
      :key="`favourite-${index}`"
      :data="nutrient"
      @drop="drop($event, nutrient, index)"
      @drag="drag($event, index)"
      :draggable="true"
      :loveable="true"
      :addable="true"
    />
  </ul>
</template>
