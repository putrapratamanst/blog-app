@extends('layouts.main')
@section('content')

<div class="wrap-pic-w how-pos5-parent">
    <img src="{{ url('storage/'.$post->image) }}" alt="IMG-BLOG">

    <div class="flex-col-c-m size-123 bg9 how-pos5">
        <span class="ltext-107 cl2 txt-center">
        @php
            $publishedAt = \Carbon\Carbon::parse($post->published_at);
        @endphp
        {{ $publishedAt->format('d') }}
        </span>

        <span class="stext-109 cl3 txt-center">
        {{ $publishedAt->format('M Y') }}
        </span>
    </div>
</div>

<div class="p-t-32">
    <span class="flex-w flex-m stext-111 cl2 p-b-19">
        <span>
            <span class="cl4">By</span> Admin  
            <span class="cl12 m-l-4 m-r-6">|</span>
        </span>

        <span>
        {{ $publishedAt->format('d M, Y') }}
            <span class="cl12 m-l-4 m-r-6">|</span>
        </span>

        <span>
            @if ($post->category)
                {{ $post->category->category }}
            @else
                -
            @endif
            <span class="cl12 m-l-4 m-r-6">|</span>
        </span>

        <span>
            8 Comments
        </span>
    </span>

    <h4 class="ltext-109 cl2 p-b-28">
    {{ $post->title }}
    </h4>

    <p class="stext-117 cl6 p-b-26" style="text-align: justify;">
    {{$post->content}}
    </p>
</div>

<!--  -->
<div class="p-t-40">
    <h5 class="mtext-113 cl2 p-b-12">
        Leave a Comment
    </h5>

   
    @if (Auth::check())
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <input type="hidden" name="slug" value="{{ $post->slug }}">
        <div class="bor19 m-b-20">
            <textarea class="stext-111 cl2 plh3 size-124 p-lr-18 p-tb-15" name="comment" placeholder="Comment..." required></textarea>
        </div>

        <button type="submit" class="flex-c-m stext-101 cl0 size-125 bg3 bor2 hov-btn3 p-lr-15 trans-04">
            Post Comment
        </button>
    </form>
    <hr>
    @else
    <p class="stext-107 cl6 p-b-40">
        Please login if you want to submit comment
    </p>
    @endif
    @forelse ($post->comments as $comment)
        <div class="comment mb-4 p-3 border rounded" id="comments-section">
            <div class="d-flex justify-content-between mb-2">
                <strong>{{ $comment->author->name }}</strong>
                <small class="text-muted">{{ $comment->created_at->format('F j, Y \a\t g:i A') }}</small>
            </div>
            <p>{{ $comment->comment }}</p>
        </div>
    @empty
        <p>No comments yet.</p>
    @endforelse
</div>

@endsection
