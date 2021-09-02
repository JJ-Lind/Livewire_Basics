<?php

namespace Tests\Feature;

use App\Http\Livewire\TagsComponent;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TagsComponentTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function main_page_contains_tags_component_livewire_component()
    {
        $this->get('/users')
             ->assertSeeLivewire('tags-component');
    }

    /** @test */
    public function loads_existing_tags_correctly()
    {
        $taga = Tag::factory()->create();
        $tagb = Tag::factory()->create();

        Livewire::test(TagsComponent::class)
            ->assertSet('tags', json_encode([$taga->name, $tagb->name]));
    }

    /** @test */
    public function adds_tags_correctly()
    {
        $taga = Tag::factory()->create();
        $tagb = Tag::factory()->create();

        Livewire::test(TagsComponent::class)
            ->emit('tagAdded', 'test')
            ->assertEmitted('tagAddedFromBackend', 'test');

        $this->assertDatabaseHas('tags', [
           'name' => 'test'
        ]);
    }

    /** @test */
    public function removes_tags_correctly()
    {
        $taga = Tag::factory()->create();
        $tagb = Tag::factory()->create();

        Livewire::test(TagsComponent::class)
            ->emit('tagRemoved', $tagb->name);

        $this->assertDatabaseMissing('tags', [
            'name' => $tagb->name
        ]);
    }
}
