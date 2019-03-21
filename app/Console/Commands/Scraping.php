<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Weidner\Goutte\GoutteFacade;
use App\Item;

class Scraping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scraping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scraping anime data';

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
     * @return mixed
     */
    public function handle()
    {
        \Log::info('Scraping start');
        // シーズンリストクロール
        $season_list_crawler = GoutteFacade::request('GET', 'https://anime.eiga.com/program/');
        $season_list_crawler->filter('select#anime_term > option')->each(function ($season_list){
            $anime_list_url = $season_list->attr('value');
            $anime_list_url = 'https://anime.eiga.com'.$anime_list_url;

            // シーズン毎アニメリストクロール
            $anime_list_crawler = GoutteFacade::request('GET', $anime_list_url);
            $anime_list_crawler->filter('div.seasonBoxImg > p.seasonAnimeTtl > a')->each(function ($anime_list){
                $anime_url = $anime_list->attr('href');
                $anime_url = 'https://anime.eiga.com'.$anime_url;

                // アニメリスト毎アニメクロール
                $anime_crawler = GoutteFacade::request('GET', $anime_url);

                $title = $anime_crawler->filter('div.animeDetailBox > div.animeDetailL > h2')->text();
                $title = strstr($title,'  Check-in',true);

                $item = new Item();
                if($item->getSearchByItemCount($title) == 0){
                    $image_text = $anime_crawler->filter('div.animeDetailBox > div.animeDetailImg > img');
                    $image_url = $image_text->attr('src');
                    if(strpos($image_url,'https://eiga.k-img.com/anime/images/shared/noimg/') !== false){
                        $image = null;
                    }else {
                        $image_url = strstr($image_url,'?',true);
                        $image_contents = file_get_contents($image_url);
                        $image_encode = base64_encode($title);
                        $image_name = str_replace(array('+','=','/'),array('_','-','.'),$image_encode);
                        $image = $image_name.'.jpg';
                        /*
                         * production : AWS_S3
                        */
                        if(\App::environment('production')){
                            // AWS_S3に保存
                            $disk = Storage::disk('s3');
                            $exists = $disk->exists('images/items/'.$image);
                            if(!$exists){
                                $disk->put('images/items/'.$image, $image_contents, 'public');
                            }
                        }else {
                            // ローカルストレージに保存
                            Storage::put('public/images/items/'.$image, $image_contents);
                        }
                    }

                    $season = $anime_crawler->filter('div.animeDetailBox > div.animeDetailL > p.animeSeasonTag > span.seasonText > a')->text();

                    $companys = [];
                    $company_main = $anime_crawler->filter('div.animeDetailBox > div.animeDetailL > dl.animeDetailList:not(#detailStaff) > dd > ul > li')->each(function ($company) use(&$companys){
                        $company_name = $company->text();
                        array_push($companys, $company_name);
                    });
                    $company = implode(',', $companys);

                    $link_text = $anime_crawler->filter('div.animeDetailBox > dl#detailLink > dd > ul > li > a');
                    $official_link = null;
                    if(count($link_text) > 0){
                        $official_link = $link_text->attr('href');
                    }

                    $data = [
                      'title' => $title,
                      'image' => $image,
                      'season' => $season,
                      'company' => $company,
                      'link' => $anime_url,
                      'official_link' => $official_link
                    ];

                    Item::create($data);
                    // // continueと同義(break : return false;)
                    // return true;
                }
            });
        });
    }
}
