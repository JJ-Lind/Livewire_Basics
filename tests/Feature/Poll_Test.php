<?php

namespace Tests\Feature;

use App\Http\Livewire\PollingTest;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class Poll_Test extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function main_page_contains_poll_livewire_component()
    {
        $this->get('/users')->assertSeeLivewire('polling-test');
    }

    /** @test */
    public function poll_sums_orders_correctly()
    {
        $order_a = Order::create([
            'price' => 20
        ]);
        $order_b = Order::create([
            'price' => 60
        ]);

        Livewire::test(PollingTest::class)
            ->call('getRevenue')
            ->assertSet('revenue', 80)
            ->assertSee('$80');

        $order_c = Order::create([
            'price' => 20
        ]);

        Livewire::test(PollingTest::class)
            ->call('getRevenue')
            ->assertSet('revenue', 100)
            ->assertSee('$100');
    }
}
