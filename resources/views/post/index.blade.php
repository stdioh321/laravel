@extends("layouts/default")
@section("title", "Posts")
@section("b-title", "Posts")
@section("content")
    <style>
        .card-img-top-wrapper {
            position: relative;
        }

        .card-img-top-wrapper > .card-img-top-wrapper-delete {
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(30%,-30%);
            z-index: 1000;
            transition: 1s all;
        }
        .card-img-top-wrapper > .card-img-top-wrapper-delete:hover{
            /*transform: translate(0%,-10%) scale(1.5);*/
        }

        .card-img-top-wrapper > .card-img-top-wrapper-delete  .fa {
            /*background: #cbd5e0;*/
            /*border-radius: 3px;*/
        }
    </style>
    <div class="row">
        <div class="col-12 mb-2 text-right">
            <a href="{{route("posts.create")}}" class="btn btn-outline-primary ">Add Post</a>
        </div>
        <div class="col-12">
            <div class="row align-items-center">
                @if(isset($posts))
                    @foreach($posts as $post)
                        <div class="col-md-3 col-6 mb-md-1 mb-3">
                            <div class="card">
                                <div class="card-img-top-wrapper">
                                    <img src="https://picsum.photos/200/100?rand={{\Illuminate\Support\Str::random()}}"
                                         alt="" class="card-img-top">

                                        <form class="card-img-top-wrapper-delete" action="{{route("posts.destroy",[$post["id"]])}}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <label for="delete{{$post["id"]}}">
                                                <button class="btn btn-danger  "><i class="fa fa-trash  pointer" aria-hidden="true"></i></button>
                                            </label>
                                            <input type="submit" id="delete{{$post["id"]}}" hidden>

                                        </form>

                                </div>
                                <div class="card-body">
                                    <div class="card-title">{{$post["id"] ?? ""}}) {{$post["title"] ?? ""}}</div>
                                    <small class="card-text">{{$post["content"] ?? ""}}</small>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
