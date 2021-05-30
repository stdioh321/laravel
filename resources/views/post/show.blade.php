@extends("layouts/default")
@section("title", "Post Detail")
@section("b-title", "Post Detail")
@section("content")
    <style>
        .img-preview {
            box-shadow: 0px 0px 3px 0px black;
            padding: 2px;
            /*max-height: 100px;*/
        }

        .img-preview > img {
            max-height: 400px;
        }


    </style>
    <div class="row">
        <div class="col-12 mb-2">
            <div class="row mb-3">
                <div class="col-3">
                    <a href="{{route("posts.index")}}" class="btn btn-sm btn-outline-success"><span
                            class="show-on-hover">Back&nbsp;</span><i
                            class="fa fa-arrow-circle-left" aria-hidden="true"></i></a>
                </div>
                <div class="col-9 d-flex justify-content-end">
                    <a href="{{route("posts.edit",$post->id)}}" class="btn btn-primary btn-sm"><span
                            class="show-on-hover">Edit&nbsp;</span><i
                            class="fa fa-edit" aria-hidden="true"></i></a>

                    <form action="{{route("posts.destroy", $post->id)}}" method="POST" class="form-delete ml-1">
                        {!! method_field("delete") !!}
                        <button class="btn btn-sm btn-danger" type="submit"><span
                                class="show-on-hover">Delete&nbsp;</span><i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </form>

                </div>

            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="font-weight-bold">Title</div>
                    <div class="">{{$post->title}}</div>
                    <hr/>
                </div>
                <div class="col-12">
                    <div class="font-weight-bold">Content</div>
                    <small>{{$post->content}}</small>
                    <hr/>
                </div>
                <div class="col-12">
                    <div class="font-weight-bold">Image</div>
                    @if(isset($post->image))
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="img-preview">
                                    <img lazy-src="{{$post->image}}" alt=""
                                         class="img-fluid img-spinner animate__animated animate__jello"/>
                                </div>

                            </div>
                        </div>
                    @else
                        <div class="text-danger font-weight-bold">No Image</div>
                    @endif

                </div>
            </div>
        </div>
        <script>
            var formDelete = document.querySelector(".form-delete");
            if (formDelete) {
                formDelete.addEventListener("submit", (ev) => {

                    if (!confirm("Are you sure?")) {
                        ev.preventDefault();
                        return;
                    }
                });
            }
            var imgPreview = document.querySelector(".img-preview > img");
            if (imgPreview) {
                // imgPreview.addEventListener("load", function (ev) {
                //     console.log(ev);
                // });
                imgPreview.src = imgPreview.getAttribute("lazy-src");
            }
        </script>
@endsection
