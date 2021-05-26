@php
    $isEdit=false;
    if(isset($id)) $isEdit = true;
    if(old("post") !== null) $post =old("post");
@endphp
@extends("layouts/default")
@section("title", $isEdit? "Edit Post":"Add Post")
@section("b-title", $isEdit? "Edit Post":"Add Post")
@section("content")
    <style>
        .errors-wrapper {
            /*transition: 1s all;*/
            animation: fade-in 0.5s 1;
        }

        .image-preview {

        }

        .image-preview > img {

            max-height: 200px !important;
            max-width: 100%;
        }
    </style>
    <div class="row">
        <div class="col-12 mb-1">
            <div class="row">
                <div class="col-6 col-md-2">
                    <a class="btn btn-success btn-block" href="{{route("posts.index")}}"><i class="fa fa-arrow-left"
                                                                                            aria-hidden="true"></i>&ensp;Back</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <form action="{{ $isEdit ? route("posts.update", [$id]): route("posts.store") }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                @if($isEdit)
                    <input type="text" name="_method" value="PUT" hidden>
                @endif

                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" required
                           minlength="3" maxlength="160"
                           value="{{$post["title"] ?? ''}}"
                    />
                </div>
                <div class="form-group">
                    <label for="content">Content *</label>
                    <textarea name="content" id="content" rows="4" class="form-control" placeholder="Content..."
                              required minlength="3" maxlength="160"

                    >{{$post["content"] ?? ''}}</textarea>
                </div>
                <div class="row form-group">
                    <div class="col-md-6 col-12">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="image">Image <small class="font-weight-bold font-italic text-danger ">(Max
                                        file size 2MB)</small></label>
                                <input type="file" class="form-control" id="image" name="image"/>
                            </div>
                            <div class="col-md-12">
                                <div class="image-preview">
                                    <img src="{{$post['image'] ?? ''}}" alt=""
                                         class=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 ">
                        <div class="row form-group">
                            <div class="col-12"><label for="">&ensp;</label></div>
                            <div class="col-12">
                                <button class="btn btn-primary btn-block" type="submit">Send&ensp;<i
                                        class="fa fa-paper-plane"
                                        aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if($errors->any())
            <div class="col-12 errors-wrapper">
                <div class="row">
                    @foreach($errors->all() as $err)
                        <div class="col-md-3 col-12">
                            <div class="alert alert-danger">{{$err}}</div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif


    </div>
    <script>
        var tit = document.querySelector("#title");
        if (tit) tit.focus();
        var errorsWrapper = document.querySelector(".errors-wrapper");
        if (errorsWrapper) errorsWrapper.scrollIntoView();

        var img = document.querySelector("#image");
        if (img) {
            img.addEventListener("change", function (ev) {
                var files = ev.target.files;
                var imgPreview = document.querySelector(".image-preview img");
                if (imgPreview) imgPreview.src = "";
                if (!files || files.length < 1) return;
                var file = files[0];
                var maxSize = 1024 * 1024 * 2;

                if (file.size > maxSize) {
                    alert("File size greater than 2MB");
                    img.value = "";
                    return;
                }
                var fs = new FileReader();
                fs.readAsDataURL(file);
                fs.onload = function () {

                    if (imgPreview) {
                        imgPreview.src = fs.result;
                    }
                };
            });
        }

    </script>
@endsection
