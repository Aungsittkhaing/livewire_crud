<div class="container my-3">
    <div class="row border-bottom py-2">
        <div class="col-xl-11">
            <h4 class="text-center fw-bold">CRUD App with using livewire</h4>
        </div>
        <div class="col-xl-1">
            <a wire:navigate href="{{ route('posts.create') }}" class="btn btn-primary btn-sm">Add posts</a>
        </div>
    </div>
    {{-- alert component --}}
    <div class="my-2">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
                <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    {{-- data table lists --}}
    <div class="card shadow">
        <div class="table-responsive card-body mt-4">
            <div class="my-3 col-xl-4 ms-auto">
                <input wire:model.live.debounce.delay:300ms="searchPost" type="text" class="form-control"
                    placeholder="search post">
            </div>
            <table class="table table-striped">
                <thead>
                    <th>#</th>
                    <th>Title<span wire:click="sortBy('title')">
                            @if ($sortColumn == 'title')
                                @if ($sortOrder == 'asc')
                                    <i class="bi bi-chevron-up"></i>
                                @else
                                    <i class="bi bi-chevron-down"></i>
                                @endif
                            @else
                                <i class="bi bi-chevron-expand"></i>
                            @endif
                        </span></th>
                    <th>Content<span wire:click="sortBy('content')">
                            @if ($sortColumn == 'content')
                                @if ($sortOrder == 'asc')
                                    <i class="bi bi-chevron-up"></i>
                                @else
                                    <i class="bi bi-chevron-down"></i>
                                @endif
                            @else
                                <i class="bi bi-chevron-expand"></i>
                            @endif
                        </span></th>
                    <th>Featured Image<span wire:click="sortBy('featured_image')">
                            @if ($sortColumn == 'featured_image')
                                @if ($sortOrder == 'asc')
                                    <i class="bi bi-chevron-up"></i>
                                @else
                                    <i class="bi bi-chevron-down"></i>
                                @endif
                            @else
                                <i class="bi bi-chevron-expand"></i>
                            @endif
                        </span></th>
                    <th>Date<span wire:click="sortBy('created_at')">
                            @if ($sortColumn == 'created_at')
                                @if ($sortOrder == 'asc')
                                    <i class="bi bi-chevron-up"></i>
                                @else
                                    <i class="bi bi-chevron-down"></i>
                                @endif
                            @else
                                <i class="bi bi-chevron-expand"></i>
                            @endif
                        </span></th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a class="text-decoration-none" wire:navigate
                                    href="{{ route('posts.view', $post->id) }}">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td>{{ $post->content }}</td>
                            <td>
                                <a wire:navigate href="{{ route('posts.view', $post->id) }}">
                                    @if ($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid"
                                            width="60px">
                                    @endif
                                </a>
                            </td>
                            <td>
                                <p>
                                    <small><strong>Posted: </strong>{{ $post->created_at->diffForHumans() }}</small>
                                </p>
                                <p>
                                    <small><strong>Updated : </strong>{{ $post->updated_at->diffForHumans() }}</small>
                                </p>
                            </td>
                            <td>
                                <a href="{{ route('posts.edit', $post->id) }}" wire:navigate class="btn btn-secondary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button wire:confirm="Are you sure to delete it?"
                                    wire:click="deletePost({{ $post->id }})" type="button" class="btn btn-danger">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <div class="col-12 d-flex justify-content-center">
                            <div class="card" style="width: 20rem;">
                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <h5 class="card-title">There is no data</h5>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </tbody>
            </table>
            {{ $posts->links() }}

        </div>
    </div>
</div>
