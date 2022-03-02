<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomainTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_domain_can_be_requested()
    {
        $product = Product::factory()->create();

        Domain::request('test.com', $product->id);

        $this->assertDatabaseHas('domains', [
            'url' => 'test.com',
            'product_id' => $product->id
        ]);
    }

    public function test_domain_can_be_registered()
    {
        $domain = Domain::factory()->create();
        $domain->register();

        $this->assertEquals('registered', $domain->status);
    }

    public function test_domain_can_be_de_registered()
    {
        $domain = Domain::factory()->create();
        $domain->deregister();
        $this->assertDatabaseMissing('domains', $domain->toArray());
    }
}
