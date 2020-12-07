<?php


namespace App\Http\Services;

use App\Models\Feed;
use Goutte\Client;

class Scrapper
{
    /**
     * @var Client
     */
    private $client;

    const MAX_ARTICLES = 5;

    const SOURCES = ['mundo' => 'El mundo', 'pais' => 'El País'];

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getElMundoFeeds()
    {
        $crawler = $this->client->request('GET', 'https://www.elmundo.es/');

        $crawler->filter('article')->each(function ($node, $i) {
            if ($i > self::MAX_ARTICLES - 1) {
                return false;
            }

            $articleID = $node->attr('ue-article-id');

            $feed = Feed::where('article_id', '=', $articleID)->first();

            if (null === $feed) {
                $feed = new Feed();
                $feed->article_id = $articleID;
            }

            $feed->title = $node->filter('h2')->text();
            $feed->body = $node->filter('.ue-c-cover-content__standfirst')->text('');
            $publishers = $node->filter('.ue-c-cover-content__byline-name')->each(function ($publisher) {
                $text = $publisher->text('');
                $text = str_replace('Redacción:', '', $text);
                $text = str_replace('|', ',', $text);

                return $text;
            });
            $feed->publisher = trim(implode(',', $publishers));
            $imageNode = $node->filter('.ue-c-cover-content__image');
            $feed->image = null !== $imageNode->getNode(0) ? $imageNode->attr('src') : null;
            $feed->source = self::SOURCES['mundo'];

            $feed->save();
        });

    }

    public function getElPaisFeeds()
    {
        $crawler = $this->client->request('GET', 'https://elpais.com/');

        $crawler->filter('article')->each(function ($node, $i) {
            if ($i > self::MAX_ARTICLES - 1) {
                return false;
            }

            //This site got all the content in a <script> tag inside the article
            $content = collect(\json_decode($node->filter('script')->first()->text(), true));

            $articleUrl = explode('/', $content->get('url'));
            $articleID = str_replace('.html', '', array_pop($articleUrl));

            $feed = Feed::where('article_id', '=', $articleID)->first();

            if (null === $feed) {
                $feed = new Feed();
                $feed->article_id = $articleID;
            }

            $feed->title = $content->get('headline');
            $feed->body = $content->get('description');
            $authors = $content->get('author');
            $publishers = [];
            foreach ($authors as $publisher) {
                $publishers[] = $publisher['name'];
            };
            $feed->publisher = trim(implode(',', $publishers));

            $image = $content->get('image');
            $feed->image = null !== $image ? $image[0]['url'] : null;
            $feed->source = self::SOURCES['pais'];

            $feed->save();
        });

    }

}
