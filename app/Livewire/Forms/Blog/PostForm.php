<?php

namespace App\Livewire\Forms\Blog;

use App\Actions\Post\CreatePost;
use App\Actions\Post\UpdatePost;
use App\Enums\EventStatus;
use App\Models\Blog\PostType;
use App\Models\Blog\Post;
use Livewire\Form;

class PostForm extends Form
{
    protected Post $post;

    public $id;

    public array $title = ['de' => '', 'hu' => ''];
    public array $slug = ['de' => '', 'hu' => ''];
    public array $body = ['de' => '', 'hu' => ''];

    public $user_id;

    public $status;

    public $published_at;
    public $label;

    public $post_type_id;

    public function set(int $postId): void
    {
        $this->post = Post::query()->findOrFail($postId);
        $this->id = $this->post->id;
        $this->slug = $this->post->slug;
        $this->body = $this->post->body;
        $this->user_id = $this->post->user_id;
        $this->title = $this->post->title;
        $this->status = $this->post->status;
        $this->label = $this->post->label;
        $this->post_type_id = $this->post->post_type_id;
        $this->published_at = $this->post->published_at;
    }

    public function create(): Post
    {


        return CreatePost::handle($this);
    }

    public function update(): Post
    {
        return UpdatePost::handle($this);
    }


}
