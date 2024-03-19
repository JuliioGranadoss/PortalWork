<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccessLog>
 */
class AccessLogFactory extends Factory
{
    public function definition()
    {
        $userIds = User::pluck('id')->toArray();

        $userId = $this->faker->randomElement($userIds);
        $maxConnectionsPerMonth = $this->faker->numberBetween(15, 30);
        $monthAgo = Carbon::now()->subMonths(12);
        $createdAt = $this->faker->dateTimeBetween($monthAgo, 'now');
        while ($createdAt->format('N') >= 6) {
            $createdAt = $this->faker->dateTimeBetween($monthAgo, 'now');
        }
        $createdAt->setTime($this->faker->numberBetween(8, 22), $this->faker->numberBetween(0, 59), $this->faker->numberBetween(0, 59));

        return [
            'user_id' => $userId,
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }
}
