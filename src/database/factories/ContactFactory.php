<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id, // ランダムなカテゴリID
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->numberBetween(1, 3), // 1, 2, 3 のいずれか
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => $this->faker->numerify('###########'), // 11桁の数字
            'address' => $this->faker->address(),
            'building' => $this->faker->optional()->secondaryAddress(), // optional() で null になる可能性も
            'detail' => $this->faker->realText(120), // 最大120文字の文章
        ];
    }
}