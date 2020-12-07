<?php

namespace App\Http\Controllers;

use App\Http\Services\Scrapper;
use App\Models\Feed;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FeedController extends Controller
{

    /**
     * @var Scrapper
     */
    private $scrapper;

    const LIMIT_FEEDS = 10;

    /**
     * FeedController constructor.
     * @param Scrapper $scrapper
     */
    public function __construct(Scrapper $scrapper)
    {
        $this->scrapper = $scrapper;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->scrapper->getElMundoFeeds();
        $this->scrapper->getElPaisFeeds();

        $feeds = Feed::all()->sortByDesc('id')->take(self::LIMIT_FEEDS);

        return view('feeds.index', ['items' => $feeds]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('feeds.create');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'source' => 'required',
            'publisher' => 'required'
        ]);

        $input = $request->all();

        $input['article_id'] = sprintf('%s-%s', str_replace(' ', '-', $input['title']), uniqid());

        if (Feed::create($input)) {
            Session::flash('flash_message_succeed', 'Feed successfully added!');
        } else {
            Session::flash('flash_message_error', 'Feed create error!');
        }

        return redirect()->back();
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $feed = Feed::findOrFail($id);

        return view('feeds.edit', ['feed' => $feed]);
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {
        $feed = Feed::findOrFail($id);

        $this->validate($request, [
            'title' => 'required',
            'source' => 'required',
            'publisher' => 'required'
        ]);

        $input = $request->all();

        $input['article_id'] = sprintf('%s-%s', str_replace(' ', '-', $input['title']), uniqid());


        if ($feed->fill($input)->save()) {
            Session::flash('flash_message_succeed', 'Feed successfully updated!');
        } else {
            Session::flash('flash_message_error', 'Feed update error!');
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $feed = Feed::findOrFail($id);

        $feed->delete();

        Session::flash('flash_message_error', 'Feed successfully deleted!');

        return redirect()->route('feeds.index');
    }
}
