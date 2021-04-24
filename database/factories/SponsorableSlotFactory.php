<?php

namespace Database\Factories;

use App\SponsorableSlot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorableSlotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SponsorableSlot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'publish_date' => Carbon::now()->addMonth(1)
        ];
    }
}
