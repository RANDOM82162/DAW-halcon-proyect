<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_number' => $this->faker->unique()->numerify('CUST-####'),
            'invoice_number' => $this->faker->unique()->numerify('INV-####'),
            'status' => $this->faker->randomElement(['ordered', 'in_process', 'in_route', 'delivered']),
            'order_date' => $this->faker->date(),
            'delivery_date' => $this->faker->optional(0.7)->date(),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'notes' => $this->faker->optional(0.5)->sentence(),
            'user_id' => 1, // Assuming user with ID 1 exists
        ];
    }
}
