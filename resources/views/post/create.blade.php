@extends("layouts/default")
@section("title", "Add Post")
@section("b-title", "Add Post")
@section("content")
    <div class="row">
        <div class="col-12">
            <form action="{{route("posts.store")}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" required minlength="3" maxlength="160" />
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" id="content" rows="4" class="form-control" placeholder="Content..." required minlength="3" maxlength="160"></textarea>
                </div>
                <div class="row form-group">
                    <div class="col-12 col-md  offset-md-8">
                        <button class="btn btn-primary btn-block" type="submit">Send&ensp;<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
