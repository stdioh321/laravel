<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

class PostController extends Controller
{

    public function uploadImageImgbb(string $image): ?string
    {
        $apiUrl = "https://api.imgbb.com/1/upload?key=".env("IMGBB_KEY");
        $apiUrl = "https://api.imgbb.com/1/upload?key=".env("IMGBB_KEY");
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
                    "filename" => "tmp.png",
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
        $posts = Post::all()->reverse();
        return view("post.index", compact("posts"));
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
    public function store(Request $request)
    {

        $reqPost = $request->only(["title", "content"]);

        foreach ($reqPost as $col) {
            $col = trim($col);
        }
        $validated = Validator::make($reqPost, [
            "title" => 'required|max:160|min:3|string',
            "content" => 'required|max:160|min:3|string',
        ]);

        if ($validated->fails()) return Redirect::back()->withErrors($validated)->withInput(["post" => $reqPost]);
        $newPost = Post::make($reqPost);
        DB::beginTransaction();

        $newPost->save();

        if ($request->hasFile("image")) {
//            $img = $request->file("image");
//            $name = $newPost->id . "." . $img->getClientOriginalExtension();
//            $img->move(public_path("/images"), $name);
            $newPost->image = $this->uploadImageImgbb($request->file("image")->getPathname());
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
        $p = Post::where("id", $id)->get()->first();
        if (isset($p)) return response($p);
        return response(null, Response::HTTP_NOT_FOUND);
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
    public function update(Request $request, $id)
    {


        $oldPost = Post::where("id", $id)->get()->first();
        if (empty($oldPost))
            return redirect(route("posts.index"));
        $updatedPost = $request->only(["title", "content"]);
        $validated = Validator::make($updatedPost, [
            "title" => 'required|max:160|min:3|string',
            "content" => 'required|max:160|min:3|string',
        ]);

        if ($validated->fails()) return redirect()->back()->withErrors($validated)->withInput();

        DB::beginTransaction();

        if ($request->hasFile("image")) {
//            $img = $request->file("image");
//            $name = $oldPost->id . "." . $img->getClientOriginalExtension();
//            $oldFile = "images/" . $oldPost->image;
//            if (File::isFile($oldFile)) {
//                File::delete($oldFile);
//
//            }
//            $img->move(public_path("/images"), $name);

            $updatedPost["image"] = $this->uploadImageImgbb($request->file("image")->getPathname());
        }


        $oldPost->update($updatedPost);
        DB::commit();
        return redirect(route("posts.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = null)
    {
        $post = Post::where("id", $id)->get()->first();
        if (isset($post)) {
            \response($post->delete());
            return redirect(route("posts.index"));
        }
        return \response(null, Response::HTTP_NOT_FOUND);

    }
}
