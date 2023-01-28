import type { Category, Meal, Nutrient } from "@/types/types";
import { defineStore } from "pinia";

export const useNutrientStore = defineStore("nutrient", {
  // arrow function recommended for full type inference
  state: () => {
    return {
      categories: [] as Array<Category>,
      nutrients: [] as Array<Nutrient>,
      meals: [] as Array<Meal>,
      favourites: [] as Array<Nutrient>,
      basket: [] as Array<Nutrient | Meal>,
    };
  },

  actions: {
    getNutrients() {
      fetch("/api/categories")
        .then((res) => res.json())
        .then((json) => (this.categories = json.data))
        .catch((err) => console.log(err));

      fetch("/api/nutrients")
        .then((res) => res.json())
        .then((json) => {
          this.nutrients = json.data;
          this.favourites = this.nutrients.filter(
            (nutrient) => nutrient.favourite_order
          );
          this.favourites.sort((a: Nutrient, b: Nutrient) => {
            if (a.favourite_order && b.favourite_order) {
              return a.favourite_order - b.favourite_order;
            } else {
              return 0;
            }
          });
        })
        .catch((err) => console.log(err));
    },
    getMeals() {
      fetch("/api/meals")
        .then((res) => res.json())
        .then((json) => (this.meals = json.data))
        .catch((err) => console.log(err));
    },
    toggleFavourite(nutrient: Nutrient) {
      if (nutrient.favourite_order == null) {
        nutrient.favourite_order = this.favourites.length + 1;
        this.favourites.push(nutrient);
      } else {
        nutrient.favourite_order = null;
        this.favourites.splice(this.favourites.indexOf(nutrient), 1);
      }
      const url = `/api/nutrients/${nutrient.id}`;
      const options = {
        method: "PUT",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        body: JSON.stringify(nutrient),
      };
      fetch(url, options)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
        });
    },
    updateFavouriteOrder() {
      this.favourites = this.favourites.map((nutrient: Nutrient, index) => {
        nutrient.favourite_order = index + 1;
        return nutrient;
      });
      const url = `/api/favourites/nutrients`;
      const options = {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json;charset=UTF-8",
        },
        body: JSON.stringify(this.favourites),
      };
      fetch(url, options)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
        });
    },
    addNutrientToBasket(food: Nutrient | Meal) {
      if (this.basket.indexOf(food) < 0) {
        this.basket.push(food);
      }
    },
    removeNutrientFromBasket(food: Nutrient | Meal) {
      const index = this.basket.indexOf(food);
      if (index >= 0) {
        this.basket.splice(index, 1);
      }
    },
  },
});
