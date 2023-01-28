export enum Unit {
  GRAM = "gr",
  MILLILITER = "ml",
  PEACE = "pc",
}

export type Maybe<T> = T | null;

export type Nutrient = {
  id: number;
  name: string;
  category?: Category;
  carbs_in_hundred: number;
  unit: Unit;
  standard_amount: number;
  favourite_order: Maybe<number>;
};

export type Category = {
  id: number;
  name: string;
  nutrients?: Array<Nutrient>;
};

export type Meal = {
  name: string;
  nutrients?: Array<Nutrient>;
};
