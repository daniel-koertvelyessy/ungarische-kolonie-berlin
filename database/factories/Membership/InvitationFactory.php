<?php

declare(strict_types=1);

namespace Database\Factories\Membership;

use App\Models\Membership\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;

final class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'token' => $this->faker->unique()->uuid,
            'accepted' => false,
        ];
    }
}
