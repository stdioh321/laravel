@extends("layouts/default")
@section("title", "Posts")
@section("b-title", "Posts")
@section("content")
  <style>
    .card-img-top-wrapper {
      position: relative;
      max-height: 300px;
      text-align: center;
    }

    .card-img-top-wrapper .is-mine {
      position: absolute;
      top: -2.5px;
      left: -2.5px;
      width: 7px;
      height: 7px;
      background-color: green;
      border-radius: 100%;
    }

    .card-img-top-wrapper > .card-img-top {
      max-height: inherit;
      /*border: solid red 1px;*/
      max-width: 100% !important;
      width: auto !important;

    }

    .card-img-top-wrapper > .card-img-top-actions {
      position: absolute;
      top: 0;
      right: 0;
      transform: translate(35%, -35%);
    }

    .card-img-top-wrapper > .card-img-top-actions > * {
      transition: 0.5s transform;
    }

    .card-img-top-wrapper > .card-img-top-actions > *:hover {
      transform: scale(1.3);
    }

    .custom-pagination .pagination {
      flex-wrap: wrap;
    }

    .custom-pagination li:not(:first-child):not(:last-child) {
      /*margin: auto 3px;*/
    }

    .custom-pagination .page-item + .page-item {
      /*margin: auto 3px;*/
      /*display: none ;*/
    }


    .custom-pagination li > * {
      border-radius: 50px !important;
    }

    .custom-pagination li:not(:nth-child(-n+3)):not(:nth-last-child(-n+3)):not(.disabled):not(.active) {
      /*border:solid red 1px !important;*/
      /*display: none;*/
    }
  </style>
  <div class="row">

    @if(isset($message))
      <div class="col-12 my-1">
        <div class="alert alert-warning">{{$message}}</div>
      </div>
    @endif
    @if($errors->any())
      <div class="col-12 mt-1">
        @foreach($errors->all() as $err)
          <div class="alert alert-danger">{{$err}}</div>
        @endforeach
      </div>
    @endif
    <div class="col-12 mb-4">
      @auth
        <div class="d-flex justify-content-end mb-1">
          <div class="font-weight-bold font-italic animate__animated animate__lightSpeedInRight">
            <a href="{{route("user.edit")}}">Hello, {{Auth::user()->name}}!</a>
          </div>
        </div>
      @endauth
      <div class="d-flex justify-content-between">
        <a href="{{route("posts.create")}}" class="btn btn-outline-primary ">Add Post</a>

        @auth
          <a href="{{route("auth.logout")}}" class="btn btn-outline-danger ">Logout</a>
        @endauth

      </div>
    </div>
    <div class="col-12">
      <div class="row mb-5">
        <div class="col-12">
          <form action="{{route("posts.index")}}" method="GET">
            <div class="form-group row">
              <div class="col-md-10 col-12">
                <input type="text" class="form-control" name="q" id="q" placeholder="Search..."
                       value="{{old('q') ?? $q ?? ''}}" autocomplete="off"
                />
              </div>

              <div class="col">
                <div class="row flex-row-reverse">
                  <div class="col-md col-6 mt-md-0 mt-1 pl-md-0">
                    <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                  </div>
                  <div class="col-md col-6 mt-md-0 mt-1 pl-md-0">
                    <button class="btn btn-danger btn-block" type="submit" onclick="javascript:document.querySelector('#q').value = null"><i
                        class="fa fa-eraser" aria-hidden="true"></i></button>

                  </div>
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
      <div class="row">
        @if(isset($posts))
          @if(count($posts) < 1)
            {{--            <div class="col-12">--}}
            {{--              <div class="alert alert-warning">No posts found.</div>--}}
            {{--            </div>--}}
          @endif
          @foreach($posts as $post)
            <div class="col-md-3 col-6 mb-md-1 mb-3">
              <div class="card">
                <div class="card-img-top-wrapper">
                  <img
                    src="{{$post['image'] ?? 'https://via.placeholder.com/200x100'}}"
                    alt="" class="card-img-top">
                  <div class="card-img-top-actions">
                    <a href="{{route("posts.show",[$post["id"]])}}"
                       class="btn btn-secondary btn-sm"><i
                        class="fa fa-eye" aria-hidden="true"></i></a>
                  </div>
                  @if($post->id_user == Auth::user()->id)
                    <div class="is-mine animate__animated animate__heartBeat" style="animation-iteration-count: infinite"></div>
                  @endif
                </div>
                <div class="card-body">
                  <div class="card-title">{{$post["id"] ?? ""}}) {{$post["title"] ?? ""}}</div>
                  <div style="max-height: 4.5em;" class="card-text overflow-hidden text-truncate ">{{$post["content"] ?? ""}}</div>

                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>

    <div class="col-12 mt-4">
      <div class="d-flex justify-content-center custom-pagination">
        {{--        @for($i=1;$i<$posts->lastPage();$i++)--}}
        {{--          <a class="btn btn-outline-primary btn-sm mx-1 {{$posts->currentPage() == $i? 'active':''}}" href="{{$posts->url($i)}}">{{$i}}</a>--}}
        {{--        @endfor--}}
        {{ $posts->onEachSide(1)->appends(["q"=>$q??null])->links('pagination::bootstrap-4') }}
      </div>

    </div>
  </div>
@endsection
