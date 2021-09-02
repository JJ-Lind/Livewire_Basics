<?php

namespace Tests\Feature;

use App\Http\Livewire\CommentsSection;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class Comments_Section_Test extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function post_index_contains_posts()
    {
        $post = Post::factory()->create();
        $this->get(route('post.index'))
             ->assertSee($post->title);
    }

    /** @test */
    public function post_show_contains_comments_livewire_component()
    {
        $post = Post::factory()->create();
        $this->get(route('post.show', $post))
             ->assertSeeLivewire('comments-section');
    }

    /** @test */
    public function valid_comment_can_be_posted()
    {
        $post = Post::factory()->create();
        Livewire::test(CommentsSection::class)
            ->set('post', $post)
            ->set('comment', 'This is my comment')
            ->call('postComment')
            ->assertSee('Comment successfully added!')
            ->assertSee('This is my comment');
    }

    /** @test */
    public function comment_is_required()
    {
        $post = Post::factory()->create();
        Livewire::test(CommentsSection::class)
            ->set('post', $post)
            ->call('postComment')
            ->assertHasErrors(['comment' => 'required'])
            ->assertSee('The comment field is required');
    }

    /** @test */
    public function comment_requires_min_characters()
    {
        $post = Post::factory()->create();
        Livewire::test(CommentsSection::class)
            ->set('post', $post)
            ->set('comment', 'Boi')
            ->call('postComment')
            ->assertHasErrors(['comment' => 'min'])
            ->assertSee('The comment must be at least 4 characters');
    }
}
