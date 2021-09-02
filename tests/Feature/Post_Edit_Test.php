<?php

namespace Tests\Feature;

use App\Http\Livewire\PostEdit;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Storage;
use Tests\TestCase;

class Post_Edit_Test extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function post_edit_page_contains_post_edit_livewire_component()
    {
        $post = Post::factory()->create();
        $this->get(route('post.edit', $post))
             ->assertSeeLivewire('post-edit');
    }

    /** @test */
    public function post_edit_page_form_works()
    {
        $post = Post::factory()->create();

        Livewire::test(PostEdit::class, ['post' => $post])
            ->set('title', 'New Title')
            ->set('content', 'New Content')
            ->call('submitForm')
            ->assertSee('Post was updated successfully');

        $post->refresh();
        $this->assertEquals('New Title', $post->title);
        $this->assertEquals('New Content', $post->content);
    }

    /** @test */
    public function post_edit_page_upload_works_for_images()
    {
        $post = Post::factory()->create();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('photo.jpg');

        Livewire::test(PostEdit::class, ['post' => $post])
            ->set('title', 'New Title')
            ->set('content', 'New Content')
            ->set('photo', $file)
            ->call('submitForm')
            ->assertSee('Post was updated successfully');

        $post->refresh();
        $this->assertEquals('New Title', $post->title);
        $this->assertEquals('New Content', $post->content);
        $this->assertNotNull($post->photo);
        Storage::disk('public')->assertExists($post->photo);
    }

    /** @test */
    public function post_edit_page_upload_fails_on_non_images()
    {
        $post = Post::factory()->create();

        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf', 1024);

        Livewire::test(PostEdit::class, ['post' => $post])
            ->set('title', 'New Title')
            ->set('content', 'New Content')
            ->set('photo', $file)
            ->call('submitForm')
            ->assertSee('The photo must be an image')
            ->assertHasErrors(['photo' => 'image']);

        $post->refresh();
        $this->assertNull($post->photo);
        Storage::disk('public')->assertMissing($post->photo);
    }
}
