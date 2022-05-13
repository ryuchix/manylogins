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
            // $keywords = KeywordSearch::where('status', 1)
            //     ->get(0)->limit(300)
            //     ->orderBy('created_at', 'desc')
            //     ->get();


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


            // // create new sitemap object
            // $sitemap = \App::make('sitemap');

            // // counters
            // $counter = 0;
            // $sitemapCounter = 0;

            // // add every product to multiple sitemaps with one sitemap index
            // foreach ($keywords as $keyword) {
            //     if ($counter == 15000) {
            //         // generate new sitemap file
            //         $sitemap->store('xml', 'sitemap-' . $sitemapCounter, '');
            //         // add the file to the sitemaps array
            //         $sitemap->addSitemap(secure_url('sitemap-' . $sitemapCounter . '.xml'));
            //         // reset items array (clear memory)
            //         $sitemap->model->resetItems();
            //         // reset the counter
            //         $counter = 0;
            //         // count generated sitemap
            //         $sitemapCounter++;
            //     }

            //     $sitemap->add(url($keyword->slug), $keyword->created_at, 'weekly', '0.5');
            //     // count number of elements
            //     $counter++;
            // }

            // // you need to check for unused items
            // if (!empty($sitemap->model->getItems())) {
            //     // generate sitemap with last items
            //     $sitemap->store('xml', 'sitemap-' . $sitemapCounter, '');
            //     // add sitemap to sitemaps array
            //     $sitemap->addSitemap(secure_url('sitemap-' . $sitemapCounter . '.xml'));
            //     // reset items array
            //     $sitemap->model->resetItems();
            // }

            // // generate new sitemapindex that will contain all generated sitemaps above
            // $sitemap->store('sitemapindex', 'sitemap', '');

            // return redirect('sitemap.xml');
        
        } catch (\Exception $e) {
            logger($e);
        }  catch (\Throwable $e) {
            logger($e);
        } catch (\InvalidArgumentException $th) {
            logger(json_encode($th));
        }
    }
}
