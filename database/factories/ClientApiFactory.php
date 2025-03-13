<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientApi>
 */
class ClientApiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clientId = Str::uuid();
        $clientSecret = Hash::make($clientId);

        return [
            'app_name' => fake()->name(),
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        ];
    }
}
