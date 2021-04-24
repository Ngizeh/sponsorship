<?php

namespace Tests\Unit;

use App\Sponsorable;
use App\SponsorableSlot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SponsorableTest extends TestCase
{
	use RefreshDatabase;

    /** @test **/
   public function find_sponsorable_by_slug()
   {
   		$sponsorable = Sponsorable::factory()->create(['slug' => 'full-stack-radio']);

   		$foundSponsorable = Sponsorable::findOrFailBySlug('full-stack-radio');

   		$this->assertTrue($foundSponsorable->is($sponsorable));
   }

   /** @test **/
   public function fails_if_slug_not_found_sponsorable_by_slug()
   {
   		$this->expectException(ModelNotFoundException::class);

   		Sponsorable::findOrFailBySlug('slug-that-does-not-exsit');
   }

    /** @test **/
   public function sponsorable_slots_belongs_to_sponsorable()
   {
       $sponsorable = Sponsorable::factory()->create(['slug' => 'full-stack-radio']);

       $this->assertInstanceOf(Collection::class, $sponsorable->slots);
   }
}
