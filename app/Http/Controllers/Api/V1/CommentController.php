<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Spatie\QueryBuilder\QueryBuilder;



class CommentController extends Controller
{
    public function index(CommentRequest $request)
    {
        $comments = QueryBuilder::for(Comment::class)
            ->allowedIncludes(['user','task'])
            ->allowedFilters(['name'])
            ->paginate($request->per_page ?? 10)
            ->appends($request->all());
        return $this->respondSuccess(new CommentCollection($comments));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        return $this->respondCreated(
            new CommentResource(Comment::create($request->validated()))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $Comment
     * @return \Illuminate\Http\Response
     */
    public function show(CommentRequest $request, Comment $Comment)
    {
        return $this->respondSuccess(new CommentResource($Comment));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $Comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $Comment)
    {
        $Comment->fill($request->validated())->save();
        return $this->respondSuccess(new CommentResource($Comment));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $Comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommentRequest $request, Comment $Comment)
    {
        if ($Comment->delete()) {
            return $this->respondOk(__('Comment.delete_success', ['resource', 'Comment '.$Comment->name]));
        }
        return $this->respondError(__('Comment.delete_fail',['resource',  'Comment '.$Comment->name]));
    }
}
