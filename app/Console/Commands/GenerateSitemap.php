<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KeywordSearch;
use App;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $sitemapIndex = SitemapIndex::create();

            $productChunks = KeywordSearch::select(['slug', 'updated_at'])
                ->where('status', 1)
                ->where('deleted', '!=', 1)
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
