<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class CommentsSection extends Component {

    public $post;
    public $comment;
    public $successMessage;
    protected $rules = [
        'comment' => 'required|min:4',
        'post' => 'required'
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function postComment()
    {
        $this->validate();

        Comment::create([
            'post_id' => $this->post->id,
            'username' => 'Guest',
            'content' => $this->comment
        ]);

        $this->post->refresh();
        $this->comment = '';

        $this->successMessage = 'Comment successfully added!';
    }

    public function render()
    {
        return view('livewire.comments-section');
    }
}
