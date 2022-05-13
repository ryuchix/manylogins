<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App;

use App\Models\KeywordSearch;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function create()
    {
        try {
            $keywords = KeywordSearch::where('status', 1)
                ->orderBy('created_at', 'desc')
                ->get();

            // create new sitemap object
            $sitemap = App::make('sitemap');

            // counters
            $counter = 0;
            $sitemapCounter = 0;

            // add every product to multiple sitemaps with one sitemap index
            foreach ($keywords as $keyword) {
                if ($counter == 15000) {
                    // generate new sitemap file
                    $sitemap->store('xml', 'sitemap-' . $sitemapCounter, '');
                    // add the file to the sitemaps array
                    $sitemap->addSitemap(secure_url('sitemap-' . $sitemapCounter . '.xml'));
                    // reset items array (clear memory)
                    $sitemap->model->resetItems();
                    // reset the counter
                    $counter = 0;
                    // count generated sitemap
                    $sitemapCounter++;
                }

                $sitemap->add(url($keyword->slug), $keyword->created_at, 'weekly', '0.5');
                // count number of elements
                $counter++;
            }

            // you need to check for unused items
            if (!empty($sitemap->model->getItems())) {
                // generate sitemap with last items
                $sitemap->store('xml', 'sitemap-' . $sitemapCounter, '');
                // add sitemap to sitemaps array
                $sitemap->addSitemap(secure_url('sitemap-' . $sitemapCounter . '.xml'));
                // reset items array
                $sitemap->model->resetItems();
            }

            // generate new sitemapindex that will contain all generated sitemaps above
            $sitemap->store('sitemapindex', 'sitemap', '');

            // return redirect('sitemap.xml');
        
        } catch (\Exception $e) {
            //
        }
    }
}
