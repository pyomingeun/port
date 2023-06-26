<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Str;
use File;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $column = request()->column? request()->column : 'id';; 
        $order = request()->order? request()->order : 'desc';
        $query = Post::orderBy($column, $order);
        if (request()->q) {
            $searchQuery = request()->q;
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('content', 'like', '%' . $searchQuery . '%')
                    ->orWhere('type', 'like', '%' . $searchQuery . '%');
            });
        }
        if (request()->status) {
            $query->where('status', request()->status);
        }
        if (request()->post) {
            $query->where('type', request()->post);
        }
        $posts = $query->paginate(10);
        return view('admin.post_listing', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required',
            'PostType' => 'required',
            'post_content' => 'required_if:PostType,==,magazine',
            'thumbimage' => 'required',
        ]);
        $slug = Str::slug($request->post_title);
        $checkSlug = Post::where('slug', $slug)->first();
        if ($checkSlug) {
            return redirect()->back()->with('error', 'Post title already exists');
        } else {
            $posts = Post::create([
                'title' => $request->post_title,
                'slug' => $slug,
                'content' => $request->post_content,
                'status' => $request->PostStatus,
                'type' => $request->PostType,
            ]);
            if ($posts) {
                if ($request->thumbimage) {
                    $image = $request->thumbimage;
                    $folderPath = 'post_images/' . $posts->id . '/';
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath);
                    }
                    $image_parts = explode(";base64,", $image);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_base64 = base64_decode($image_parts[1]);
                    $img = uniqid() .uniqid() . '.png';
                    $file = $folderPath . $img;
                    file_put_contents($file, $image_base64);
                    $posts->image = $file;
                    $posts->save();
                }
                $otherImages = json_decode($request->otherimageP);
                $insertOther = [];
                foreach ($otherImages as $otherImage) {
                    $image = $otherImage->image;
                    $folderPath = 'post_images/' . $posts->id . '/';
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath);
                    }
                    $image_parts = explode(";base64,", $image);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_base64 = base64_decode($image_parts[1]);
                    $img = uniqid() .uniqid() . '.png';
                    $file = $folderPath . $img;
                    file_put_contents($file, $image_base64);
                    $insertOther[] = [
                        'post_id' => $posts->id,
                        'image' => $file,
                        'is_featured' => $otherImage->isFeatured,
                        'status' => 'active',
                    ];
                }
                PostImage::insert($insertOther);
                return redirect()->route('admin-post-list')->with('success', 'Post created successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $postImages = PostImage::where('post_id', $id)->get();
        $images = [];
        foreach ($postImages as $postImage) {
            $images[] = (object)[
                'image' => $postImage->image,
                'isFeatured' => $postImage->is_featured,
                'type' => 'old',
            ];
        }
        // dd($post);
        return view('admin.post_create', compact('post', 'images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'post_title' => 'required',
            'PostType' => 'required',
            'post_content' => 'required_if:PostType,==,magazine',
            'thumbimage' => 'required',
        ]);
        $post = Post::find($id);
        $post->title = $request->post_title;
        $post->slug = Str::slug($request->post_title);
        $post->content = $request->post_content;
        $post->status = $request->PostStatus;
        $post->type = $request->PostType;
        if ($post->save()) {
            $imageparts = explode(";base64,", $request->thumbimage);
            if ($request->thumbimage && count($imageparts) > 1) {
                $image = $request->thumbimage;
                $folderPath = 'post_images/' . $id . '/';
                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath);
                }
                $image_parts = explode(";base64,", $image);
                $image_base64 = base64_decode($image_parts[1]);
                $img = uniqid() .uniqid() . '.png';
                $file = $folderPath . $img;
                file_put_contents($file, $image_base64);
                $post->image = $file;
                $post->save();
            }
            $otherImages = json_decode($request->otherimageP);
            $insertOther = [];
            foreach ($otherImages as $otherImage) {
                if ($otherImage->type == 'base64') {
                    $image = $otherImage->image;
                    $folderPath = 'post_images/' . $id . '/';
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath);
                    }
                    $image_parts = explode(";base64,", $image);
                    $image_base64 = base64_decode($image_parts[1]);
                    $img = uniqid() .uniqid() . '.png';
                    $file = $folderPath . $img;
                    file_put_contents($file, $image_base64);
                    $insertOther[] = [
                        'post_id' => $id,
                        'image' => $file,
                        'is_featured' => $otherImage->isFeatured,
                        'status' => 'active',
                    ];
                }
            }
            if (count($insertOther) > 0) {
                PostImage::insert($insertOther);
            }
            return redirect()->route('admin-post-list')->with('success', 'Post updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $post = Post::find($request->post_id);
        if ($post) {
            $post->delete();
            return redirect()->back()->with('success', 'Post deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
