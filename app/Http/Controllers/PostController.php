<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;

use Gregwar\Image\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

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
      $response = $client->request('POST', $apiUrl, [
        'multipart' => [[
          "name" => "image",
          "contents" => fopen($image, 'r'),
          "filename" => time(),
        ]]
      ]);
      if ($response->getStatusCode() != 200) throw new \Exception("Not ok");
      $resp = json_decode($response->getBody()->getContents())->data->url;
    } catch (\Throwable $th) {

    }
    return $resp;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
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
    $all = Storage::disk("s3")->allFiles();
    Storage::disk("s3")->setVisibility("posts-images/14.gif","private");
    return \response(Storage::disk("s3")->url("posts-images/14.gif"));

    $reqPost = $request->input();

    $validated = Validator::make($reqPost, [
      "title" => 'required|max:160|min:3|string',
      "content" => 'nullable|max:1000|min:3|string'
    ]);

    if ($validated->fails()) return Redirect::back()->withErrors($validated);

    $newPost = Post::make($reqPost);

    DB::beginTransaction();

    $newPost->save();

    if ($request->hasFile("image") && $request->file("image")->isValid()) {
      $img = $request->file("image");

//            $name = $newPost->id . "." . $img->getClientOriginalExtension();
//            $img->move(public_path("/images"), $name);

      $newPost->image = $this->uploadImageImgbb($request->file("image")->getPathname());
//      $tmpIdImage = $img->storePubliclyAs("/posts-images", $newPost->id . "." . $img->getClientOriginalExtension());
//      $newPost->image = Storage::disk("s3")->url($tmpIdImage);
      $newPost->save();
    }

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
    if (isset($post)) return view("post.show", compact("post"));
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

    $post = Post::where("id", "$id")->get()->first();
    if (empty($post)) return redirect()->back();
//            return \response(null, Response::HTTP_NOT_FOUND);


    return view("post.create", ["id" => $id, "post" => $post]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(StoreUpdatePost $request, $id)
  {


    $oldPost = Post::where("id", $id)->get()->first();
    if (empty($oldPost))
      return redirect()->back()->withErrors(["msg" => "Post do not exists."]);
    $updatedPost = $request->only(["title", "content"]);
    $validated = Validator::make($updatedPost, [
      "title" => 'required|max:160|min:3|string',
      "content" => 'nullable|max:10000|min:3|string',
    ]);

    if ($validated->fails()) return redirect()->back()->withErrors($validated)->withInput();

    DB::beginTransaction();

    if ($request->hasFile("image") && $request->file("image")->isValid()) {
//            $img = $request->file("image");
//            $name = $oldPost->id . "." . $img->getClientOriginalExtension();
//            $oldFile = "images/" . $oldPost->image;
//            if (File::isFile($oldFile)) {
//                File::delete($oldFile);
//
//            }
//            $img->move(public_path("/images"), $name);
//      $img = $request->file("image");
//      $tmpIdImage=$img->storePubliclyAs("/posts-images", $oldPost->id . "." . $img->getClientOriginalExtension());
//      $updatedPost["image"] = Storage::disk("s3")->url($tmpIdImage);
      $updatedPost["image"] = $this->uploadImageImgbb($request->file("image")->getPathname());
    }


    $oldPost->update($updatedPost);
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
