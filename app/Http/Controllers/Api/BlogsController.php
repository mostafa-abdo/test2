<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\BlogState;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ['blogs' => BlogResource::collection(Blog::query()->orderBy('created_at', 'desc')->get()), 'categories' => BlogState::all()];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        if(isset($data['image'])) {
            $relativePath = $data['image'] = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $data['user_id'] = auth()->user()->id;

        $blogstate = BlogState::where('name', $data['state'])->first();

        if($blogstate) {
            $data['state_id'] = $blogstate->id;
        }else {
            $newstate = BlogState::create([
                'name' => $data['state']
            ]);

            $data['state_id'] = $newstate->id;
        }

        $blog = Blog::create($data);

        return response([new BlogResource($blog), 201, []]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return new BlogResource($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        if(isset($data['image'])) {
            $relativePath = $data['image'] = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $data['user_id'] = auth()->user()->id;

        $blogstate = BlogState::where('name', $data['state'])->first();

        if($blogstate) {
            $data['state_id'] = $blogstate->id;
        }else {
            $newstate = BlogState::create([
                'name' => $data['state']
            ]);

            $data['state_id'] = $newstate->id;
        }

        $blog->update($data);
        return new BlogResource($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response('', 204);
    }

    private function saveImage($image)
    {
        if(preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            $image = substr($image, strpos($image, ',') + 1);

            $type = strtolower($type[1]);

            if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('Invalid image type.');
            }

            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if($image === false) {
                throw new \Exception('base64_decode failed.');
            }
        } else {
            throw new \Exception('did not match data URI with image data.');
        }

        $dir = 'uploads/blogs/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;

        if(!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }

        file_put_contents($relativePath, $image);

        return $relativePath;
    }
}
