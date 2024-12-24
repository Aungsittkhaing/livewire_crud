<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination, WithoutUrlPagination;
    #[Title('Livewire CRUD - Post List')]
    public $searchPost = null;
    public $activePageNumber = 1;
    public $sortColumn = 'id';
    public $sortOrder = 'asc';

    // public $posts;
    // public function mount()
    // {
    //     $this->posts = Post::all();
    // }
    public function sortBy($columnName)
    {
        if ($this->sortColumn === $columnName) {
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $columnName;
            $this->sortOrder = 'asc';
        }
    }
    public function fetchPost()
    {
        return Post::where('title', 'LIKE', '%' . $this->searchPost . '%')
            ->orWhere('content', 'LIKE', '%' . $this->searchPost . '%')
            ->orderBy($this->sortColumn, $this->sortOrder)->paginate(4);
    }
    public function render()
    {
        $posts = $this->fetchPost();
        return view('livewire.post-list', compact('posts'));
    }
    public function deletePost(Post $post)
    {
        if ($post) {
            //delete featured image from storage
            if (Storage::exists($post->featured_image)) {
                Storage::delete($post->featured_image);
            };
            $deleteResponse = $post->delete();
            if ($deleteResponse) {
                session()->flash('success', 'Post Deleted Successfully');
            } else {
                session()->flash('error', 'Post Deletion Failed');
            }
        } else {
            session()->flash('error', 'Post Not Found');
        }
        $posts = $this->fetchPost();

        if ($posts->isEmpty() && $this->activePageNumber > 1) {
            //decrement active page number(previous page)
            $this->gotoPage($this->activePageNumber - 1);
        } else {
            //redirect to the active page number
            $this->gotoPage($this->activePageNumber);
        }

        // return $this->redirect('/posts', navigate: true);
    }

    public function updatingPage($pageNumber)
    {
        $this->activePageNumber = $pageNumber;
    }
}
