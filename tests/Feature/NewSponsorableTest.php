<?php

namespace Tests\Feature;

use App\Purchase;
use App\Sponsorable;
use App\SponsorableSlot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class NewSponsorableTest extends TestCase
{
    use RefreshDatabase;

     /** @test **/
    public function can_view_sponsorable_slots()
    {
        $sponsorable = factory(Sponsorable::class)->create(['slug' => 'full-stack-radio']);

        $sponsorableSlots = factory(SponsorableSlot::class, 3)->create(['sponsorable_id' => $sponsorable->id]);

        $response = $this->withoutExceptionHandling()->get('/full-stack-radio/sponsorship/new');

        $response->assertSuccessful();

        $this->assertCount(3, $response->data('sponsorableSlots'));

       $this->assertTrue($response->data('sponsorable')->is($sponsorable));
    }

    /** @test **/
    public function sponsorable_slots_are_viewed_in_a_chronological_order()
    {
        $sponsorable = factory(Sponsorable::class)->create(['slug' => 'full-stack-radio']);

        $slotA = factory(SponsorableSlot::class)->create(['publish_date' => Carbon::now()->addDays(10), 'sponsorable_id' => $sponsorable->id]);
        $slotB = factory(SponsorableSlot::class)->create(['publish_date' => Carbon::now()->addDays(30), 'sponsorable_id' => $sponsorable->id]);;
        $slotC = factory(SponsorableSlot::class)->create(['publish_date' => Carbon::now()->addDays(3), 'sponsorable_id' => $sponsorable->id]);


        $response = $this->withoutExceptionHandling()->get('/full-stack-radio/sponsorship/new');

        $response->assertSuccessful();

        $this->assertCount(3, $response->data('sponsorableSlots'));
        $this->assertTrue($response->data('sponsorable')->is($sponsorable));
        $this->assertTrue($response->data('sponsorableSlots')[0]->is($slotC));
        $this->assertTrue($response->data('sponsorableSlots')[1]->is($slotA));
        $this->assertTrue($response->data('sponsorableSlots')[2]->is($slotB));
    }

    /** @test **/
    public function sponsorable_slots_are_viewed_that_are_listed()
    {
        $sponsorable = factory(Sponsorable::class)->create(['slug' => 'full-stack-radio']);

        $slotA = factory(SponsorableSlot::class)->create(['publish_date' => Carbon::now()->subDays(10), 'sponsorable_id' => $sponsorable->id]);
        $slotB = factory(SponsorableSlot::class)->create(['publish_date' => Carbon::now()->subDays(30), 'sponsorable_id' => $sponsorable->id]);
        $slotC = factory(SponsorableSlot::class)->create(['publish_date' => Carbon::now()->addDays(20), 'sponsorable_id' => $sponsorable->id]);
        $slotD = factory(SponsorableSlot::class)->create(['publish_date' => Carbon::now()->addDays(3), 'sponsorable_id' => $sponsorable->id]);


        $response = $this->withoutExceptionHandling()->get('/full-stack-radio/sponsorship/new');

        $response->assertSuccessful();

        $this->assertCount(2, $response->data('sponsorableSlots'));
        $this->assertTrue($response->data('sponsorable')->is($sponsorable));
        $this->assertTrue($response->data('sponsorableSlots')[0]->is($slotD));
        $this->assertTrue($response->data('sponsorableSlots')[1]->is($slotC));
    }

     /** @test **/
    public function sponsorable_slots_are_viewed_that_are_listed_that_are_purchasable()
    {
        $sponsorable = factory(Sponsorable::class)->create(['slug' => 'full-stack-radio']);
        $purchase = factory(Purchase::class)->create();

        $slotA = factory(SponsorableSlot::class)->create(['sponsorable_id' => $sponsorable->id]);
        $slotB = factory(SponsorableSlot::class)->create(['sponsorable_id' => $sponsorable->id,'purchase_id' => $purchase]);
        $slotC = factory(SponsorableSlot::class)->create(['sponsorable_id' => $sponsorable->id,'purchase_id' => $purchase]);
        $slotD = factory(SponsorableSlot::class)->create(['sponsorable_id' => $sponsorable->id]);


        $response = $this->withoutExceptionHandling()->get('/full-stack-radio/sponsorship/new');

        $response->assertSuccessful();

        $this->assertCount(2, $response->data('sponsorableSlots'));
        $this->assertTrue($response->data('sponsorable')->is($sponsorable));
        $this->assertTrue($response->data('sponsorableSlots')[0]->is($slotA));
        $this->assertTrue($response->data('sponsorableSlots')[1]->is($slotD));
    }
}
