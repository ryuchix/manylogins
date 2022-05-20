<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\KeywordSearch;
use App\Models\Post;

use Illuminate\Http\Request;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Hashids\Hashids;

class SitemapController extends Controller
{
    public function create()
    {
        try {
            $sitemapIndex = SitemapIndex::create();

            $posts = Post::where('status', 1)->get();

            $productChunks = KeywordSearch::with('organic')->select(['slug', 'updated_at'])->offset(0)->take(100)
                ->where('status', 1)
                ->orderBy('updated_at', 'desc')
                ->chunk(25000, function ($products, $chunk) use ($sitemapIndex) {
                    $sitemapName = 'keywords_sitemap'.$chunk.'.xml';
                    $sitemap = Sitemap::create();

                    foreach ($products as $product) {
                        $sitemap->add(Url::create($product->slug)
                                ->setLastModificationDate($product->updated_at));

                        foreach ($product->organic as $organic) {
                            $hashids = new Hashids();
                            $sitemap->add(Url::create($product->slug . '/' . $hashids->encode($organic->id))
                                    ->setLastModificationDate($organic->updated_at));
                        }
                    }

                    $sitemap->writeToFile(public_path($sitemapName));
                    $sitemapIndex->add($sitemapName);
                });
            $sitemapPageName = 'pages.xml';    
            $_sitemap = Sitemap::create();

            $_sitemap->add(Url::create('/')
                    ->setLastModificationDate(Carbon::now()));

            $_sitemap->add(Url::create('guides')
                    ->setLastModificationDate(Carbon::now()));

            foreach ($posts as $post) {
                $_sitemap->add(Url::create('guide/'.$post->slug)
                        ->setLastModificationDate($post->updated_at));
            }

            $_sitemap->writeToFile(public_path($sitemapPageName));
            $sitemapIndex->add($sitemapPageName);

            $sitemapIndex->writeToFile(public_path('sitemap.xml'));

            return redirect('sitemap.xml');
        } catch (\Exception $e) {
            logger($e->getMessage());
        }  catch (\Throwable $e) {
            logger($e->getMessage());
        } catch (\InvalidArgumentException $th) {
            logger(($th->getMessage()));
        }
    }
}
