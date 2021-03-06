@extends('nova-blog::layout')

@section('title', $author->name)

@section('nova-blog-content')
    <div class="card blog-card">
        <div class="card-header">{{ $author->name }}</div>
        <div class="card-body">
            <div class="blog-posts">
                @forelse($posts as $p)
                    @include('nova-blog::partials.post', [
                        'post' => $p,
                    ])
                @empty
                    <div>{{ __('Not found') }}</div>
                @endforelse
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection

@section('nova-blog-sidebar')
    @include('nova-blog::sidebar.posts', [
        'posts' => $sidebarPosts,
    ])
    @include('nova-blog::sidebar.categories', [
        'categories' => $categories,
    ])
    @include('nova-blog::sidebar.tags', [
        'tags' => $tags,
    ])
@endsection
