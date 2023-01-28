import MeleBasket from "@/views/MeleBasket.vue";
import MeleMeals from "@/views/MeleMeals.vue";
import { createRouter, createWebHistory } from "vue-router";
import MeleNutrients from "../views/MeleNutrients.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: MeleNutrients,
    },
    {
      path: "/basket",
      name: "basket",
      component: MeleBasket,
    },
    {
      path: "/meals",
      name: "meals",
      component: MeleMeals,
    },
  ],
});

export default router;
