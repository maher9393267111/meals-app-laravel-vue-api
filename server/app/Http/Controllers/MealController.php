<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealResource;
use App\Models\Meal;
use App\Models\Nutrient;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MealResource::collection(Meal::with('nutrients')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $meal = new Meal;
        $meal->name = $request->name;
        $meal->save();

        foreach ($request->ingredients as $ingredient) {
            $meal->nutrients()->attach($ingredient['id'], ["standard_amount" => $ingredient['standard_amount']]);
        }
        return [
            "status" => 1,
            "data" => new MealResource($meal),
            "msg" => "Meal successfully created"
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        return new MealResource($meal->load('nutrients'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
        $syncArray = array();
        foreach ($request->ingredients as $ingredient) {
            $syncArray[$ingredient['id']] = array("standard_amount" => $ingredient['standard_amount']);
        }
        // return $ingredients;
        $status = $meal->nutrients()->sync($syncArray);
        return [
            "status" => 1,
            "data" => $meal,
            "operations" => $status,
            "msg" => "Meal updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        $meal->nutrients()->detach();
        $meal->delete();
        return [
            "status" => 1,
            "data" => $meal,
            "msg" => "Meal deleted successfully"
        ];
    }
}
