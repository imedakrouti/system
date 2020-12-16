<?php

namespace App\Http\Controllers\ParentStudent\Student;

use App\Http\Controllers\Controller;
use Learning\Models\Learning\Comment;
use Learning\Models\Learning\Exam;
use Learning\Models\Learning\Like;
use Learning\Models\Learning\Post;
use Student\Models\Settings\Classroom;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $exams = Exam::with('classrooms', 'subjects')->whereHas('classrooms', function ($q) {
            $q->where('classroom_id', classroom_id());
        })
            ->where('start_date', '>', date_format(\Carbon\Carbon::now(), "Y-m-d"))
            ->orderBy('start_date', 'asc')
            ->limit(6)
            ->get();

        $classroom = Classroom::findOrFail(classroom_id());

        $posts = Post::with('admin')->where('classroom_id', classroom_id())
            ->orderBy('created_at', 'desc')->limit(30)->get();
        $title = trans('learning::local.posts');
        return view(
            'layouts.front-end.student.posts',
            compact('title', 'posts', 'exams', 'classroom')
        );
    }

    public function comments()
    {
        if (request()->ajax()) {
            $comments = Comment::where('post_id', request('id'))
                ->leftJoin('admins', 'comments.admin_id', '=', 'admins.id')
                ->leftJoin('users', 'comments.user_id', '=', 'users.id')
                ->select(
                    'comments.*',
                    'admins.name',
                    'admins.ar_name',
                    'users.name as en_student_name',
                    'users.ar_name as ar_student_name'
                )
                ->get();

            $comment_count = Comment::with('user')->where('post_id', request('id'))->count();
            return view(
                'layouts.front-end.student.includes._comments',
                compact('comments', 'comment_count')
            );
        }
    }

    private function attributes()
    {
        return [
            'comment_text',
            'post_id',
        ];
    }

    public function storeComment()
    {        
        if (request()->ajax()) {
            request()->user()->comments()->create(request()->only($this->attributes()));
        }
        return response(['status' => true]);
    }

    public function likePost()
    {
        if (request()->ajax()) {
            $post = Like::with('user')->where('post_id', request('post_id'))
                ->where('user_id', userAuthInfo()->id)->first();
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
            $post = Like::with('user')->where('post_id', request('post_id'))->where('user_id', userAuthInfo()->id)->first();
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

    // posts

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
        $names_dislike = Like::with('admin','user')->where('post_id', request('post_id'))->where('like', 0)->get();
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

    // comments

    public function likeComment()
    {
        if (request()->ajax()) {
            $post = Like::where('comment_id', request('comment_id'))
                ->where('admin_id', userAuthInfo()->id)->first();
            if ($post == null) {
                request()->user()->like()->firstOrCreate([
                    'comment_id' => request('comment_id'),
                    'like'    => true
                ]);
            } else {
                $post->update(['like' => true]);
            }

            $data['like'] = Like::where('comment_id', request('comment_id'))
                ->where('like', 1)
                ->count();

            $data['dislike'] = Like::where('comment_id', request('comment_id'))
                ->where('like', 0)
                ->count();

            return json_encode($data);
        }
    }

    public function dislikeComment()
    {
        if (request()->ajax()) {
            $post = Like::where('comment_id', request('comment_id'))
                ->where('admin_id', userAuthInfo()->id)->first();
            if ($post == null) {
                request()->user()->like()->firstOrCreate([
                    'comment_id' => request('comment_id'),
                    'like'    => false
                ]);
            } else {
                $post->update(['like' => false]);
            }

            $data['like'] = Like::where('comment_id', request('comment_id'))
                ->where('like', 1)
                ->count();

            $data['dislike'] = Like::where('comment_id', request('comment_id'))
                ->where('like', 0)
                ->count();

            return json_encode($data);
        }
    }

    public function showLikeNames()
    {
        if (request()->ajax()) {
            $likes = Like::with('admin', 'user')->where('comment_id', request('comment_id'))->where('like', 1)->get();
            $output = '';
            foreach ($likes as $like) {
                // teacher default image
                $teacher_image = '<img style="width: 50px;height:50px;max-width: 50px;float:right" src="' . asset('images/website/male.png') . '" alt="avatar"> ';

                if (!empty($like->admin->image_profile)) {
                    $teacher_image = '<img class=" editable img-responsive student-image" alt="" id="avatar2" 
                    src="' . asset('images/imagesProfile/' . $like->admin->image_profile) . '" /> ';
                }
                if (isset($like->admin)) {
                    $ar_name = $like->admin->employeeUser->ar_st_name . ' ' . $like->admin->employeeUser->ar_nd_name;
                    $en_name = $like->admin->employeeUser->en_st_name . ' ' . $like->admin->employeeUser->en_nd_name;
                    $output .= session('lang') == 'ar' ? $teacher_image . $ar_name : $teacher_image . $en_name . '<br>';
                }

                if (isset($like->user)) {
                    // default image for student
                    $path_image = $like->user->studentUser->gender == trans('student::local.male') ?
                        'images/studentsImages/37.jpeg' : 'images/studentsImages/39.png';

                    $image = '<img class=" editable img-responsive student-image" alt="" id="avatar2" src="' . asset($path_image) . '" /> ';

                    // student image
                    if (!empty($like->user->studentUser->student_image)) {
                        $image = '<img class=" editable img-responsive student-image" alt="" id="avatar2" 
                        src="' . asset('images/studentsImages/' . $like->user->studentUser->student_image) . '" />';
                    }

                    $ar_name = $like->user->studentUser->ar_student_name . ' ' . $like->user->studentUser->father->ar_st_name;
                    $en_name = $like->user->studentUser->en_student_name . ' ' . $like->user->studentUser->father->en_st_name;
                    $output .= session('lang') == 'ar' ? $image . $ar_name : $image . $en_name . '<br>';
                }
            }
        }
        return json_encode($output);
    }

    public function showDislikeNames()
    {
        if (request()->ajax()) {
            $dislikes = Like::with('admin', 'user')->where('comment_id', request('comment_id'))->where('like', 0)->get();
            $output = '';
            foreach ($dislikes as $dislike) {
                // teacher default image
                $teacher_image = '<img style="width: 50px;height:50px;max-width: 50px;float:right" src="' . asset('images/website/male.png') . '" alt="avatar"> ';

                if (!empty($dislike->admin->image_profile)) {
                    $teacher_image = '<img class=" editable img-responsive student-image" alt="" id="avatar2" 
                    src="' . asset('images/imagesProfile/' . $dislike->admin->image_profile) . '" /> ';
                }
                if (isset($dislike->admin)) {
                    $ar_name = $dislike->admin->employeeUser->ar_st_name . ' ' . $dislike->admin->employeeUser->ar_nd_name;
                    $en_name = $dislike->admin->employeeUser->en_st_name . ' ' . $dislike->admin->employeeUser->en_nd_name;
                    $output .= session('lang') == 'ar' ? $teacher_image . $ar_name : $teacher_image . $en_name . '<br>';
                }

                if (isset($dislike->user)) {
                    // default image for student
                    $path_image = $dislike->user->studentUser->gender == trans('student::local.male') ?
                        'images/studentsImages/37.jpeg' : 'images/studentsImages/39.png';

                    $image = '<img class=" editable img-responsive student-image" alt="" id="avatar2" src="' . asset($path_image) . '" /> ';

                    // student image
                    if (!empty($dislike->user->studentUser->student_image)) {
                        $image = '<img class=" editable img-responsive student-image" alt="" id="avatar2" 
                        src="' . asset('images/studentsImages/' . $dislike->user->studentUser->student_image) . '" />';
                    }

                    $ar_name = $dislike->user->studentUser->ar_student_name . ' ' . $dislike->user->studentUser->father->ar_st_name;
                    $en_name = $dislike->user->studentUser->en_student_name . ' ' . $dislike->user->studentUser->father->en_st_name;
                    $output .= session('lang') == 'ar' ? $image . $ar_name : $image . $en_name . '<br>';
                }
            }
        }
        return json_encode($output);
    }

    public function count()
    {
        if (request()->ajax()) {
            $comment_count = Comment::where('post_id', request('id'))->count();
            return json_encode($comment_count);
        }
    }
}
