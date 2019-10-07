@extends('nova-blog::layout')

@section('title', $category->name)

@section('nova-blog-content')
    <div class="card blog-card">
        <div class="card-header">{{ $category->name }}</div>
        <div class="card-body blog-posts">
            @foreach($posts as $p)
                @include('nova-blog::partials.post', [
                    'post' => $p,
                ])
            @endforeach
            {{ $posts->links() }}
        </div>
    </div>
@endsection

@section('nova-blog-sidebar')
    @include('nova-blog::sidebar.posts', [
        'posts' => $sidebarPosts,
    ])
    @include('nova-blog::sidebar.categories', [
        'categories' => $sidebarCategories,
    ])
    @include('nova-blog::sidebar.tags', [
        'tags' => $tags,
    ])
@endsection
