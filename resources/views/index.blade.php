@extends('nova-blog::layout')

@section('title', __('Recent Posts'))

@section('nova-blog-content')
    <div class="card blog-card">
        <div class="card-header">{{ __('Recent Posts') }}</div>
        <div class="card-body blog-post-list">
            @foreach($posts as $p)
                @include('nova-blog::post', [
                    'post' => $p,
                ])
            @endforeach
            {{ $posts->links() }}
        </div>
    </div>
@endsection

@section('nova-blog-sidebar')
    @include('nova-blog::sidebar.categories', [
        'categories' => $categories,
    ])
    @include('nova-blog::sidebar.tags', [
        'tags' => $tags,
    ])
@endsection
