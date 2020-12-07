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

    const LIMIT_FEEDS = 5;

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
    public function index(){

        $this->scrapper->getElMundoFeeds();

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
    public function store(Request $request){

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'source' => 'required',
            'publisher' => 'required'
        ]);

        $input = $request->all();

        $input['article_id'] = sprintf('%s-%s', str_replace(' ', '-', $input['title']), uniqid());

        Feed::create($input);

        Session::flash('flash_message', 'Feed successfully added!');

        return redirect()->back();
    }


    public function edit($id){
        $feed = Feed::findOrFail($id);

        return view('feeds.edit', $feed);
    }


    public function update($device, Request $request){

    }

    public function destroy($id){
        $feed = Feed::findOrFail($id);

        $feed->delete();

        Session::flash('flash_message', 'Feed successfully deleted!');

        return redirect()->route('feeds.index');
    }
}
