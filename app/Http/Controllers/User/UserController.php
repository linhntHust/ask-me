<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Auth;
use App\Models\Question;

class UserController extends Controller
{
    protected $modelQuestion;
    protected $modelBlog;
    public function __construct(Question $question, Blog $blog)
    {
        $this->modelBlog = $blog;
        $this->modelQuestion = $question;
    }

    public function userQuestion()
    {
        $user = Auth::user();
        $userQuestions = $this->modelQuestion->getUserQuestion($user->id);
        return view('user.question.user_question', compact('user', 'userQuestions'));
    }

    public function questionDetail($id)
    {
        $user = Auth::user();
        $questionDetail = $this->modelQuestion->getQuestionDetail($id);
        if ($questionDetail->question_poll == 0) {
            return view('user.question.question_detail', compact('questionDetail', 'user'));
        } else{
            return view('user.question.question_poll_detail', compact('questionDetail', 'user'));
        }
    }

    public function userHome()
    {
        $user = Auth::user();
        $recentQuestions = $this->modelQuestion->getRecentQuestions();
        return view('home', compact('recentQuestions', 'user'));
    }

    public function userBlog()
    {
        $user = Auth::user();
        $userBlogs = $this->modelBlog->getUserBlog($user->id);
        return view('user.blog.user_blog', compact('user', 'userBlogs'));
    }
}
