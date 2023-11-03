<?php

namespace App\Http\Controllers;

use App\Facades\Project\FeedbackService;
use App\Models\Comment;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FeedbackController extends Controller
{

    public function __construct(protected FeedbackService $feedbackService)
    {

    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $feedbacks = $this->feedbackService->getAll();
        return Inertia::render('Feedback/Index', ['feedbacks', $feedbacks]);
    }

    /**
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:bug,feature,improvement',
        ]);
        $request->merge([
            'user_id' => Auth::user()->id,
        ]);
        $this->feedbackService->fill($request->all());
        return redirect(route('feedbacks.index'));
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function show($id): \Inertia\Response
    {
        return Inertia::render('Feedback/Show', ['feedback', $this->feedbackService->getById($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Feedback $feedBack
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedBack)
    {
        //
    }

    /**
     * @param Request $request
     * @param Feedback $feedBack
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->feedbackService->getById($id)->update([
            'can_comment' => $request->get('can_comment')
        ]);
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vote(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $user = User::query()->findOrFail(Auth::id());
        if ($request->get('vote') === 0) $user->feedbacks()->detach($id); else $user->feedbacks()->attach($id);
        return redirect()->back();
    }

    public function comments(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'message' => 'required'
        ]);
        $this->feedbackService->fillComments($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Feedback $feedBack
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->feedbackService->getById($id)->delete();
        return redirect()->route('feedbacks.index');
    }
}
