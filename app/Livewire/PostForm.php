<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads;
    #[Title('Livewire CRUD - Create Post')]
    public $isView = false;
    public $post = null;

    #[Validate('required', message: 'title field is required')]
    #[Validate('min:3', message: 'post title must be miminum 3 characters long')]
    #[Validate('max:100', message: 'post title must be maximum 100 characters long')]
    public $title;

    #[Validate('required', message: 'content field is required')]
    #[Validate('min:3', message: 'post content must be miminum 3 characters long')]
    #[Validate('max:1000', message: 'post content must be maximum 1000 characters long')]
    public $content;


    public $featuredImage;

    public function mount(Post $post)
    {
        $this->isView = request()->routeIs('posts.view');
        if ($post->id) {
            $this->post = $post;
            $this->title = $post->title;
            $this->content = $post->content;
        }
        // dd($post);
    }

    public function savePost()
    {
        $this->validate();

        $rules = [
            "featuredImage" => $this->post && $this->post->featured_image ? 'image|nullable' : 'required|nullable'
        ];
        $messages = [
            'featuredImage.required' => 'featured image field is required',
            'featuredImage.image' => 'featured image field is required'
        ];

        $this->validate($rules, $messages);
        $imagePath = null;

        if ($this->featuredImage) {
            $imageName = time() . "." . $this->featuredImage->extension();
            $imagePath = $this->featuredImage->storeAs('public/uploads', $imageName);
        }

        if ($this->post) {
            $this->post->title = $this->title;
            $this->post->content = $this->content;

            if ($imagePath) {
                $this->post->featured_image = $imagePath;
            }
            // update function
            $updatePost = $this->post->save();

            if ($updatePost) {
                session()->flash('success', 'Post updated successfully');
            } else {
                session()->flash('error', 'Post updated failed');
            }
        } else {
            // create function
            $post = new Post();
            $post->title = $this->title;
            $post->content = $this->content;
            $post->featured_image = $imagePath;
            $post->save();

            if ($post) {
                session()->flash('success', 'Post created successfully');
            } else {
                session()->flash('error', 'Post creation failed');
            }
        }

        return $this->redirect('/posts', navigate: true);
    }
    public function render()
    {
        return view('livewire.post-form');
    }
}
