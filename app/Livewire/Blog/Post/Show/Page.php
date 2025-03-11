<?php

namespace App\Livewire\Blog\Post\Show;

use App\Livewire\Forms\Blog\PostForm;
use App\Models\Blog\Post;
use Livewire\Component;

class Page extends Component
{

    public Post $post;
    public PostForm $form;

    public function mount(Post $post):void
    {
        $this->post = $post;
        $this->form->set($post->id);
    }

    public function render()
    {
        return view('livewire.blog.post.show.page');
    }
}
