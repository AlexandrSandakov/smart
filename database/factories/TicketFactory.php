<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Ticket::class;

    public function definition(): array
    {

        return [

            'customer_id' => Customer::factory(),
            'subject' => fake()->sentence(),
            'message' => fake()->paragraph(),
            'status' => TicketStatus::NEW,
            'manager_id' => null,
            'answered_at' => null,
        ];
    }

    public function status(TicketStatus $status): static
    {
        return $this->state(fn () => ['status' => $status]);
    }

    public function assigned(?User $manager = null): static
    {
        return $this->state(fn () => ['manager_id' => $manager?->id]);
    }

    public function answered(?Carbon $at = null): static
    {
        return $this->state(fn () => ['answered_at' => $at ?? now()]);
    }

    public function inProgress(?User $manager = null): static
    {
        return $this->status(TicketStatus::IN_PROGRESS)->assigned($manager);
    }

    public function closed(?User $manager = null): static
    {
        return $this->status(TicketStatus::CLOSED)->assigned($manager)->answered();
    }
}
