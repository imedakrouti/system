<?php

namespace Learning\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Learning\Models\Learning\Post;
use Illuminate\Http\Request;
use Learning\Models\Learning\Exam;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Like;
use Student\Models\Settings\Classroom;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;

class PostController extends Controller
{
    private $file_name;
    /**
     * 
     * Admin Posts
     */

    public function allPosts()
    {
        $classrooms = Classroom::sort()->where('year_id', currentYear())->get();
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $posts = Post::orderBy('created_at', 'desc')->get();
        $title = trans('learning::local.posts');
        return view(
            'learning::posts.all-posts',
            compact('title', 'posts', 'classrooms', 'divisions', 'grades')
        );
    }

    public function allPostsByClassroom($classroom_id)
    {
        $classrooms = Classroom::sort()->where('year_id', currentYear())->get();
        $classroom = Classroom::findOrFail($classroom_id);
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $posts = Post::where('classroom_id', $classroom_id)->orderBy('created_at', 'desc')->get();
        $title = trans('learning::local.posts');
        return view(
            'learning::posts.all-posts-by-class',
            compact('title', 'posts', 'classrooms', 'divisions', 'grades', 'classroom_id', 'classroom')
        );
    }

    public function adminStorePost(Request $request)
    {
        if ($request->hasFile('file_name')) {
            $image_path = '';
            $this->file_name = uploadFileOrImage($image_path, request('file_name'), 'images/posts_attachments');
        }
        foreach (request('classroom_id') as $classroom_id) {
            $request->user()->posts()->firstOrCreate($request->only($this->attributes()) +
                [
                    'file_name'     => $this->file_name,
                    'classroom_id'  => $classroom_id,
                ]);
        }
        toast(trans('msg.stored_successfully'), 'success');
        return redirect()->route('admin.posts');
    }

    public function adminEditPost($id)
    {
        $post = Post::findOrFail($id);
        $title = trans('learning::local.edit_post');
        return view(
            'learning::posts.edit',
            compact('title', 'post')
        );
    }

    public function adminUpdatePost($id)
    {
        $post = Post::findOrFail($id);
        $post->update(request()->only($this->attributes()));
        toast(trans('msg.updated_successfully'), 'success');
        return redirect()->route('admin.posts');
    }

    public function adminDestroyPost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        toast(trans('msg.delete_successfully'), 'success');
        return redirect()->route('admin.posts');
    }

    // End admin posts 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($classroom_id)
    {
        $exams = Exam::with('classrooms')->whereHas('classrooms', function ($q) use ($classroom_id) {
            $q->where('classroom_id', $classroom_id);
        })
            ->where('start_date', '>=', \Carbon\Carbon::today())
            ->where('admin_id', authInfo()->id)
            ->get();

        $classroom = Classroom::findOrFail($classroom_id);

        $classrooms = Classroom::with('employees')->whereHas('employees', function ($q) {
            $q->where('employee_id', employee_id());
        })->get();

        $lessons = Lesson::with('subject')->where('admin_id', authInfo()->id)->orderBy('lesson_title')->get();

        $where = [
            ['classroom_id', $classroom_id],
        ];
        $all_admins = Admin::where('domain_role', '!=', 'teacher')->get();
        $admins = [];
        foreach ($all_admins as $admin) {
            $admins[] = $admin->id;
        }

        $posts = Post::with('comments', 'likes', 'dislikes', 'admin')
            ->where($where)
            ->where('admin_id', authInfo()->id)
            ->orWhereIn('admin_id', $admins)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $title = trans('learning::local.posts');
        return view(
            'learning::teacher.posts.index',
            compact('title', 'classroom', 'posts', 'exams', 'lessons')
        );
    }

    private function attributes()
    {
        return [
            'post_text',
            'youtube_url',
            'url',
            'post_type',
            'description',
            'admin_id',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('file_name')) {
            $image_path = '';
            $this->file_name = uploadFileOrImage($image_path, request('file_name'), 'images/posts_attachments');
        }
        foreach (request('classroom_id') as $classroom_id) {
            $request->user()->posts()->firstOrCreate($request->only($this->attributes()) +
                [
                    'file_name'     => $this->file_name,
                    'classroom_id'  => $classroom_id,
                ]);
        }
        toast(trans('msg.stored_successfully'), 'success');
        return redirect()->route('posts.index', request('classroom_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Learning\Models\Learning\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $title = trans('learning::local.edit_post');
        return view(
            'learning::teacher.posts.edit-post',
            compact('title', 'post')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Learning\Models\Learning\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update(request()->only($this->attributes()));
        toast(trans('msg.updated_successfully'), 'success');
        return redirect()->route('posts.index', $post->classroom_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Learning\Models\Learning\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        toast(trans('msg.delete_successfully'), 'success');
        return redirect()->route('posts.index', request('classroom_id'));
    }

    public function likePost()
    {
        if (request()->ajax()) {
            $post = Like::with('admin')->where('post_id', request('post_id'))
                ->where('admin_id', authInfo()->id)->first();
            if ($post == null) {
                request()->user()->like()->firstOrCreate([
                    'post_id' => request('post_id'),
                    'like'    => true
                ]);
            } else {
                $post->update(['like' => true]);
            }

            $data['like'] = Like::where('post_id', request('post_id'))
                ->where('like', 1)
                ->count();

            $data['dislike'] = Like::where('post_id', request('post_id'))
                ->where('like', 0)
                ->count();

            $data['like_names'] = $this->getLikeNames();
            $data['dislike_names'] = $this->getDislikeNames();

            return json_encode($data);
        }
    }

    public function dislikePost()
    {
        if (request()->ajax()) {
            $post = Like::with('admin')->where('post_id', request('post_id'))->where('admin_id', authInfo()->id)->first();
            if ($post == null) {
                request()->user()->like()->firstOrCreate([
                    'post_id' => request('post_id'),
                    'like'    => false
                ]);
            } else {
                $post->update(['like' => false]);
            }

            $data['like'] = Like::where('post_id', request('post_id'))
                ->where('like', 1)
                ->count();

            $data['dislike'] = Like::where('post_id', request('post_id'))
                ->where('like', 0)
                ->count();

            $data['like_names'] = $this->getLikeNames();
            $data['dislike_names'] = $this->getDislikeNames();

            return json_encode($data);
        }
    }

    public function show($id)
    {
        $post = Post::with('comments', 'likes', 'dislikes', 'admin')->where('id', $id)->first();
        $classroom = Classroom::findOrFail($post->classroom_id);
        $title = trans('learning::local.show_post');
        return view(
            'learning::teacher.posts.show',
            compact('title', 'post', 'classroom')
        );
    }

    private function getLikeNames()
    {
        $names_like = Like::with('admin', 'user')->where('post_id', request('post_id'))->where('like', 1)->get();
        $names = [];
        foreach ($names_like as $name) {
            // teachers
            if (isset($name->admin->employeeUser)) {
                $names[] = session('lang') == 'ar' ? $name->admin->employeeUser->ar_st_name . ' ' . $name->admin->employeeUser->ar_nd_name :
                    $name->admin->employeeUser->en_st_name . ' ' . $name->admin->employeeUser->en_nd_name . '</br>';
            }
            // students
            if (isset($name->user->studentUser)) {
                $names[] = session('lang') == 'ar' ? $name->user->studentUser->ar_student_name . ' ' . $name->user->studentUser->father->ar_st_name :
                    $name->user->studentUser->en_student_name . ' ' . $name->user->studentUser->father->en_st_name . '</br>';
            }
        }
        return $names;
    }

    private function getDislikeNames()
    {
        $names_dislike = Like::with('admin', 'user')->where('post_id', request('post_id'))->where('like', 0)->get();
        $names = [];
        foreach ($names_dislike as $name) {
            // teachers
            if (isset($name->admin->employeeUser)) {
                $names[] = session('lang') == 'ar' ? $name->admin->employeeUser->ar_st_name . ' ' . $name->admin->employeeUser->ar_nd_name :
                    $name->admin->employeeUser->en_st_name . ' ' . $name->admin->employeeUser->en_nd_name . '</br>';
            }
            // students
            if (isset($name->user->studentUser)) {
                $names[] = session('lang') == 'ar' ? $name->user->studentUser->ar_student_name . ' ' . $name->user->studentUser->father->ar_st_name :
                    $name->user->studentUser->en_student_name . ' ' . $name->user->studentUser->father->en_st_name . '</br>';
            }
        }

        return $names;
    }
}
