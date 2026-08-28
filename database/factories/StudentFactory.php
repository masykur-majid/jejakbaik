<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nisn' => fake()->randomNumber(9),
            'nis' => fake()->randomNumber(9),
            'student_name' => fake()->name(),
            'email' => fake()->email(),
            'current_grade' => 10
        ];
    }
}
