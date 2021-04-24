<?php

namespace Tests\Unit;

use App\Sponsorable;
use Tests\TestCase;
use App\SponsorableSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SponsorableSlotsTest extends TestCase
{
	use RefreshDatabase;

     /** @test **/
    public function it_belongs_to_sponsorable()
    {
    	$sponsorable = Sponsorable::factory()->create(['slug' => 'full-stack-radion']);

    	$sponsorableSlots = SponsorableSlot::factory()->create(['sponsorable_id' =>$sponsorable->id]);

    	$this->assertInstanceOf(Sponsorable::class, $sponsorableSlots->sponsorable);
    }
}
