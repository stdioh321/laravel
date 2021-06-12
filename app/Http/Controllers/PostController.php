<?php

namespace App\Http\Controllers;

use App\Exceptions\ServerException;
use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use App\Models\User;
use Gregwar\Image\Image;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

  /**
   * @throws \Exception
   */
  public function resizeImage(string $imagePath)
  {

    $tmpImagePath = "/tmp/image_" . Str::uuid();
    $newImage = Image::open($imagePath);
    if (getimagesize($imagePath)[0] > 500)
      $newImage->resize(500);
    else
      $newImage->resize();
    return $newImage->save($tmpImagePath, "guess", 100);
  }

  public function uploadImageImgbb(string $image): ?string
  {

    $apiUrl = "https://api.imgbb.com/1/upload?key=" . env("IMGBB_KEY");


//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $apiUrl);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $curlFile = curl_file_create($image);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, [
//            "image" => $curlFile,
//        ]);
    $client = new Client();
    $resp = null;
    try {
      $cont = fopen($image, 'r');

      $response = $client->request('POST', $apiUrl, [
        'multipart' => [[
          "name" => "image",
          "contents" => $cont,
          "filename" => time(),
        ]],

      ]);
      if ($response->getStatusCode() != 200) throw new \Exception("Not ok");
      $resp = json_decode($response->getBody()->getContents())->data->url;
    } catch (\Throwable $th) {

      //      throw new ServerException("Invalid Image", 422,null,"Validation Error");
    }
    return $resp;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   * @throws ServerException
   */
  public function index(Request $request)
  {
    $q = $request->only("q")["q"] ?? null;

    $posts = Post::orderBy("id", "DESC")->orderBy("created_at", "DESC");
    if (!empty($q))
      $posts = $posts->where("title", "like", "%$q%")->orWhere("content", "like", "%$q%");
    $posts = $posts->paginate(4);
    $params = ["posts" => $posts, "message" => ($posts->count() < 1) ? "No posts found." : null, "q" => $q];

    return view("post.index")->with($params);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("post.create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreUpdatePost $request)
  {
    return $this->update($request);

    $newPost = Post::make($request->input());

    DB::beginTransaction();
    $img = $request->file("image");
    if ($request->hasFile("image") && $img->isValid()) {
      $newPost->image = $this->uploadImageImgbb($img->getPathname());
//      $tmpIdImage = $img->storePubliclyAs("/posts-images", $newPost->id . "." . $img->getClientOriginalExtension());
//      $newPost->image = Storage::disk("s3")->url($tmpIdImage);
    }
    $newPost->save();
    DB::commit();

    return redirect(route("posts.index"));

  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id = null)
  {
    $post = Post::where("id", $id)->get()->first();
    if (isset($post)) return view("post.show", ["post" => $post]);
    return \redirect()->back()->withErrors("Post do not exists.");
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id = null)
  {

    $post = Post::where("id", "$id")
      ->get()->first();
    if (empty($post)) return redirect()->back();
    return view("post.create", ["id" => $id, "post" => $post]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function updatexxx(StoreUpdatePost $request, $id)
  {
    $oldPost = Post::where("id", $id)->get()->first();
    if (empty($oldPost))
      return redirect()->back()->withErrors(["message" => "Post do not exists."]);

    $updatedPost = $request->only(["title", "content"]);


    DB::beginTransaction();

    if ($request->hasFile("image") && $request->file("image")->isValid()) {
      $updatedPost["image"] = $this->uploadImageImgbb($request->file("image")->getPathname());
    }
    $oldPost->update($updatedPost);
    DB::commit();

    return redirect(route("posts.index"));

  }

  public function update(StoreUpdatePost $request, $id = null)
  {


    $p = Post::where("id", $id)->get()->first();
    if (!empty($id) && empty($p)) {
      return redirect()->back()->withErrors(["message" => "Post do not exists."]);
    }
    $newPost = $request->only(["title", "content"]);
    if ($request->hasFile("image") && $request->file("image")) {
      $newPost["image"] = $this->uploadImageImgbb($request->file("image")->getPathname());
    }
    DB::beginTransaction();
    if($p == null){
      $p = Post::make($newPost);
      $p->id_user = \Auth::user()->id;
      $p->save();
    }else
      $p->update($newPost);


    DB::commit();

    return redirect(route("posts.index"));
  }

  public function destroy($id = null)
  {
    $post = Post::where("id", $id)->get()->first();
    if (isset($post)) {
      $post->delete();
      return redirect()->route("posts.index");
    }
    return \redirect(route("posts.index"))->withErrors("Post do not exists.");

  }

  public function restore(Request $request, $id = null)
  {
    $post = Post::onlyTrashed()->where("id", $id)->get()->first();
    if (!isset($post)) return \response(null, Response::HTTP_NOT_FOUND);
    $post->restore();
    return \redirect(route("posts.index"));
  }
}
