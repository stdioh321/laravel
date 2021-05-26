@extends("layouts/default")
@section("title", "Posts")
@section("b-title", "Posts")
@section("content")
    <style>
        .card-img-top-wrapper {
            position: relative;
        }

        .card-img-top-wrapper > .card-img-top-actions {
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(50%, -30%);
        }

        .card-img-top-wrapper > .card-img-top-actions > * {
            transition: 0.5s all;
        }

        .card-img-top-wrapper > .card-img-top-actions > *:hover {
            transform: scale(1.3);
        }
    </style>
    <div class="row">
        <div class="col-12 mb-4 text-right ">
            <a href="{{route("posts.create")}}" class="btn btn-outline-primary ">Add Post</a>
        </div>
        <div class="col-12">
            <div class="row ">
                @if(isset($posts))
                    @foreach($posts as $post)
                        <div class="col-md-3 col-6 mb-md-1 mb-3">
                            <div class="card">
                                <div class="card-img-top-wrapper">
                                    <img
                                        src="{{$post['image'] ?? 'https://via.placeholder.com/200x100'}}"
                                        alt="" class="card-img-top">
                                    <div class="card-img-top-actions">
                                        <a href="{{route("posts.edit",[$post["id"]])}}"
                                           class="btn btn-success btn-sm  card-img-top-edit mb-1"><i
                                                class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <form class="card-img-top-delete form-delete"
                                              action="{{route("posts.destroy",[$post["id"]])}}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <label for="delete{{$post["id"]}}">
                                                <button class="btn btn-danger btn-sm "><i class="fa fa-trash  pointer"
                                                                                          aria-hidden="true"></i>
                                                </button>
                                            </label>
                                            <input type="submit" id="delete{{$post["id"]}}" hidden>

                                        </form>
                                    </div>

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
    <script>


        var formDelete = document.querySelectorAll(".form-delete");
        formDelete.forEach((el, idx) => {
            el.addEventListener("submit", function (ev) {
                if (!confirm("Are you sure???")) {
                    ev.preventDefault();
                    return false;
                }

            });
        });
    </script>
@endsection
