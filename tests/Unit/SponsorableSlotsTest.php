<?php

namespace Tests\Unit;

use App\Sponsorable;
use App\SponsorableSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SponsorableSlotsTest extends TestCase
{
	use RefreshDatabase;

     /** @test **/
    public function it_belongs_to_sponsorable()
    {
    	$sponsorable = factory(Sponsorable::class)->create(['slug' => 'full-stack-radion']);

    	$sponsorableSlots = factory(SponsorableSlot::class)->create(['sponsorable_id' =>$sponsorable->id]);

    	$this->assertInstanceOf(Sponsorable::class, $sponsorableSlots->sponsorable);
    }
}
