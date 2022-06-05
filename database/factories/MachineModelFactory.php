<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Manufacture\Entities\Manufacture;
use Modules\SubCategory\Entities\SubCategory;

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
