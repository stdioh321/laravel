@extends("layouts/default")
@section("title", "Edit Post")
@section("b-title", "Edit Post")
@section("content")
    <div class="row">
        <div class="col-12">
            <form action="{{route("posts.update", [$id])}}">
                <div class="form-group"></div>
            </form>
        </div>
    </div>
@endsection
