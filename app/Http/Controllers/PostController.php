<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\KeywordSearch;
use App\Models\Setting;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::get();

        return view('admin.blogs.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::get();

        return view('admin.blogs.create', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['slug'] = $this->getSlug($request->title);

        $request->validate([
            'title' => 'required|max:200',
            'content' => 'required',
            'category' => 'nullable',
            'slug' => 'required|unique:posts,slug',
            'cover' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
        ]);

        $data = array_filter($request->all());
        $data['status'] = isset($request->status) && $request->status == 'on' ? 1 : 0;

        $post = Post::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $data['content'],
            'user_id' => auth()->user()->id,
            'status' => $data['status'],
        ]);

        if ($request->category != null) {
            foreach ($request->category as $cat) {
                $category = Category::where('name', $cat)->first();

                if (!empty($category)) {
                    $post->categories()->attach($category);
                } else {
                    $category = Category::create([
                        'name' => $cat,
                        'slug' => $this->getSlug($cat),
                        'user_id' => auth()->user()->id
                    ]);
                    $post->categories()->attach($category);
                }
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $category = Category::get();

        $selected_catogories = [];

        foreach ($post->categories as $cat) {
            $selected_catogories[] = $cat->name;
        }

        return view('admin.blogs.edit', ['post' => $post, 'category' => $category, 'selected_catogories' => $selected_catogories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request['slug'] = $this->getSlug($request->title);

        $request->validate([
            'title' => 'required|max:200',
            'content' => 'required',
            'category' => 'nullable',
            'slug' => 'required|unique:posts,slug,'.$post->id,
            'cover' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
        ]);

        $data = array_filter($request->all());
        $data['status'] = isset($request->status) && $request->status == 'on' ? 1 : 0;
        $data['user_id'] = auth()->user()->id;

        $post->update([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $data['content'],
            'user_id' => $data['user_id'],
            'status' => $data['status'],
        ]);
        
        if ($request->category != null) {
            
            $post->categories()->detach();

            foreach ($request->category as $cat) {
                $category = Category::where('name', $cat)->first();

                if (!empty($category)) {
                    $post->categories()->attach($category);
                } else {
                    $category = Category::create([
                        'name' => $cat,
                        'slug' => $this->getSlug($cat),
                        'user_id' => auth()->user()->id
                    ]);
                    $post->categories()->attach($category);
                }
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (!empty($post)) {
            $post->delete();
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        }
        
        return redirect()->route('posts.index')->with('error', 'An error has occured.');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->image;
            $imageName = time().'.'.$image->extension();  
    
            $image->move(public_path('images/posts'), $imageName);

            $response = [
                'success' => true,
                'link' => asset('images/posts/'.$imageName)
            ];

            return response()->json($response);
        }
    }

    public function coverUpload($image, $id)
    {
        $imageName = time().'.'.$image->extension();  
   
        $image->move(public_path('images/posts'), $imageName);

        $user = Post::find($id);
        $user->cover = $imageName;
        $user->save();
    }

    public function getSlug($title)
    {
        $string = str_slug($title, '-');
        return preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
    }

    public function blogLists()
    {
        $blogs = Post::where('status', 1)->paginate(20);

        $popularSearch = KeywordSearch::where('status', 1)->orderByViews()->take(10)->get();

        $posts = Post::where('status', 1)->orderByViews()->take(10)->get();

        $setting = Setting::find(1);

        return view('home.blogs', [
            'blogs' => $blogs,
            'posts' => $posts,
            'popular_posts' => $popularSearch,
            'setting' => $setting
        ]);
    }

    public function showBlog($blog)
    {
        $blog = Post::where('slug', $blog)->where('status', 1)->first();

        if (empty($blog)) {
            return abort(404);
        }

        $popularSearch = KeywordSearch::where('status', 1)->orderByViews()->take(10)->get();

        $setting = Setting::find(1);

        $posts = Post::where('status', 1)->orderByViews()->take(10)->get();

        $related = Post::whereHas('categories', function ($q) use ($blog) {
            return $q->whereIn('name', $blog->categories->pluck('name')); 
        })
        ->where('id', '!=', $blog->id) // So you won't fetch same post
        ->get();

        if (!empty($blog)) {
            $expiresAt = now()->addHours(1);
            
            views($blog)
                ->cooldown($expiresAt)
                ->record();
        }

        return view('home.blog', [
            'blog' => $blog,
            'posts' => $posts,
            'popular_posts' => $popularSearch,
            'setting' => $setting,
            'related' => $related
        ]);
    }
}
