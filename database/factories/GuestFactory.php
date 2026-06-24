<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class GuestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'identity_number'=>$this->faker->unique()->numerify('3273############'),
            'name'=>$this->faker->name(),
            'gender'=>$this->faker->randomElement(['L','P']),
            'phone'=>$this->faker->phoneNumber(),
            'email'=>$this->faker->unique()->safeEmail(),
            'address'=>$this->faker->address(),
        ];
    }
}
