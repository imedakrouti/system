<?php

namespace Learning\Http\Controllers\Post;

use App\Http\Controllers\Controller;

use Learning\Models\Learning\Comment;
use Illuminate\Http\Request;
use Learning\Models\Learning\Like;

class CommentController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $comments = Comment::with('likes', 'dislikes')->where('post_id', request('id'))
                ->leftJoin('admins', 'comments.admin_id', '=', 'admins.id')
                ->leftJoin('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'admins.name', 'admins.ar_name', 'users.name as en_student_name', 'users.ar_name as ar_student_name')
                ->take(15)
                ->orderBy('id', 'desc')
                ->get();
            $comments = $comments->reverse();
            return view(
                'learning::teacher.posts.includes._comments',
                compact('comments')
            );
        }
    }

    private function attributes()
    {
        return [
            'comment_text',
            'file_name',
            'post_id',
            'user_id',
            'admin_id',
        ];
    }

    public function store(Request $request)
    {
         dd(request()->all());
        if (request()->ajax()) {
            $request->user()->comments()->create($request->only($this->attributes()));
        }
        return response(['status' => true]);
    }

    public function count()
    {
        if (request()->ajax()) {
            $comment_count = Comment::where('post_id', request('id'))->count();
            return json_encode($comment_count);
        }
    }

    public function destroy()
    {
        if (request()->ajax()) {
            $comment = Comment::findOrFail(request('comment_id'));
            $post_id = $comment->post_id;
            $comment->delete();
            return json_encode($post_id);
        }
    }

    public function likeComment()
    {
        if (request()->ajax()) {
            $post = Like::where('comment_id', request('comment_id'))
                ->where('admin_id', authInfo()->id)->first();
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
                ->where('admin_id', authInfo()->id)->first();
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
}
