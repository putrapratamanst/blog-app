<?php
use Illuminate\Support\Str;

?>
@extends('layouts.main')
@section('content')

@foreach ($posts as $post)
<div class="p-b-63">
    <a href="blog-detail.html" class="hov-img0 how-pos5-parent">
        <img src="{{ url('storage/'.$post->image) }}" alt="IMG-BLOG">

        <div class="flex-col-c-m size-123 bg9 how-pos5">
            <span class="ltext-107 cl2 txt-center">
                22
            </span>

            <span class="stext-109 cl3 txt-center">
                Jan 2018
            </span>
        </div>
    </a>

    <div class="p-t-32">
        <h4 class="p-b-15">
            <a href="blog-detail.html" class="ltext-108 cl2 hov-cl1 trans-04">
                {{ $post->title }}
            </a>
        </h4>

        <p class="stext-117 cl6">
            {!! Str::limit($post->content, 200, ' ...') !!}
        </p>

        <div class="flex-w flex-sb-m p-t-18">
            <span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
                <span>
                    <span class="cl4">By</span> Admin  
                    <span class="cl12 m-l-4 m-r-6">|</span>
                </span>

                <span>
                    StreetStyle, Fashion, Couple  
                    <span class="cl12 m-l-4 m-r-6">|</span>
                </span>

                <span>
                    8 Comments
                </span>
            </span>

            <a href="blog-detail.html" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                Continue Reading

                <i class="fa fa-long-arrow-right m-l-9"></i>
            </a>
        </div>
    </div>
</div>
@endforeach
{{ $posts->links('vendor.pagination.custom') }}

@endsection


