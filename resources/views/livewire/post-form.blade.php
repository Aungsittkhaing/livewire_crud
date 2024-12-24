<div class="container pt-5">
    <div class="row">
        <div class="col-8 m-auto">
            <form action="" wire:submit="savePost">
                <div class="card shadow border-1">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xl-6">
                                <h5 class="fw-bold">{{ $isView ? 'View' : ($post ? 'Edit' : 'Create') }} Post</h5>
                            </div>
                            <div class="col-xl-6 text-end">
                                <a wire:navigate href="{{ route('posts') }}" class="btn btn-primary btn-sm">Back to
                                    Post</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input {{ $isView ? 'disabled' : '' }} wire:model="title" type="text"
                                class="
                            form-control @error('title')
                                is-invalid
                            @enderror"
                                id="title" placeholder="post title">
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- content --}}
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea {{ $isView ? 'disabled' : '' }} wire:model="content"
                                class="
                            form-control @error('content')
                                is-invalid
                            @enderror"
                                id="content" rows="3"></textarea>
                            @error('content')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- view featured image --}}
                        @if ($post)
                            <label class="form-label">Uploaded Featured Image</label>
                            <div class="my-2">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" width="250"
                                    class="img-fluid">
                            </div>
                        @endif
                        {{-- post featured image --}}
                        @if (!$isView)
                            <div class="mb-3">
                                <label for="featuredImage" class="form-label">Featured Image</label>
                                <input wire:model="featuredImage" type="file"
                                    class="
                            form-control @error('featuredImage')
                                is-invalid
                            @enderror"
                                    id="featuredImage" placeholder="featured image">

                                {{-- preview image --}}
                                @if ($featuredImage)
                                    <div class="my-2">
                                        <img src="{{ $featuredImage->temporaryUrl() }}" class="img-fluid"
                                            width="100">

                                    </div>
                                @endif
                                @error('featuredImage')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </div>
                    @if (!$isView)
                        <div class="card-footer">
                            {{-- save button --}}
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">{{ $post ? 'Update' : 'Save' }}</button>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
