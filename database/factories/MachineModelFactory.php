<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\MachineModel;
use App\Models\Manufacture;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MachineModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MachineModel::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->bothify('???#');
        $manufacture_id = Manufacture::all()->random()->id;
        $sub_category_id = Manufacture::find($manufacture_id)->sub_category_id;
        $category_id = SubCategory::find($sub_category_id)->category_id;
        return [
            'title_en' => $title,
            'title_ar' => $title,
            'category_id' => $category_id,
            'sub_category_id' => $sub_category_id,
            'manufacture_id' => $manufacture_id,
        ];
    }
}
