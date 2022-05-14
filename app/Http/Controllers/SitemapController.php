<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\KeywordSearch;

use Illuminate\Http\Request;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function create()
    {
        try {
            $sitemapIndex = SitemapIndex::create();

            $productChunks = KeywordSearch::select(['slug', 'updated_at'])
                ->where('status', 1)
                ->orderBy('updated_at', 'desc')
                ->chunk(25000, function ($products, $chunk) use ($sitemapIndex) {
                    $sitemapName = 'keywords_sitemap'.$chunk.'.xml';
                    $sitemap = Sitemap::create();

                    foreach ($products as $product) {
                        $sitemap->add(Url::create($product->slug)
                                ->setLastModificationDate($product->updated_at));
                    }

                    $sitemap->writeToFile(public_path($sitemapName));
                    $sitemapIndex->add($sitemapName);
                });

            $sitemapIndex->writeToFile(public_path('sitemap.xml'));

            return redirect('sitemap.xml');
        } catch (\Exception $e) {
            logger($e);
        }  catch (\Throwable $e) {
            logger($e);
        } catch (\InvalidArgumentException $th) {
            logger(json_encode($th));
        }
    }
}
