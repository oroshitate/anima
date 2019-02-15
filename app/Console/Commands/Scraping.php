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
        // シーズンリストクロール
        $season_list_crawler = GoutteFacade::request('GET', 'https://anime.eiga.com/program/');
        $season_list_crawler->filter('select#anime_term > option')->each(function ($season_list){
            $anime_list_url = $season_list->attr('value');
            $anime_list_url = 'https://anime.eiga.com'.$anime_list_url;

            var_dump('season list url');
            var_dump($anime_list_url);

            // シーズン毎アニメリストクロール
            $anime_list_crawler = GoutteFacade::request('GET', $anime_list_url);
            $anime_list_crawler->filter('div.seasonBoxImg > p.seasonAnimeTtl > a')->each(function ($anime_list){
                $anime_url = $anime_list->attr('href');
                $anime_url = 'https://anime.eiga.com'.$anime_url;

                // アニメリスト毎アニメクロール
                $anime_crawler = GoutteFacade::request('GET', $anime_url);

                var_dump('anime url');
                var_dump($anime_url);

                var_dump('title');
                $title = $anime_crawler->filter('div.animeDetailBox > div.animeDetailL > h2')->text();
                $title = strstr($title,'  Check-in',true);
                var_dump($title);

                var_dump('image');
                $image_text = $anime_crawler->filter('div.animeDetailBox > div.animeDetailImg > img');
                $image_url = $image_text->attr('src');
                $image_url = strstr($image_url,'?',true);
                $image_contents = file_get_contents($image_url);
                $image_encode = base64_encode($title);
                $image = str_replace(array('+','=','/'),array('_','-','.'),$image_encode);
                $image_name = $image.'.jpg';
                //画像を保存
                Storage::put('public/images/items/'.$image_name, $image_contents);
                var_dump($image);

                var_dump('season');
                $season = $anime_crawler->filter('div.animeDetailBox > div.animeDetailL > p.animeSeasonTag > span.seasonText > a')->text();
                var_dump($season);

                var_dump('company');
                $companys = [];
                $company_main = $anime_crawler->filter('div.animeDetailBox > div.animeDetailL > dl.animeDetailList :not(#detailStaff) > dd > ul > li')->each(function ($company) use(&$companys){
                    $company_name = $company->text();
                    array_push($companys, $company_name);
                });
                $company = implode(',', $companys);
                var_dump($company);

                var_dump('staff main');
                $staffs = [];
                $staff_main = $anime_crawler->filter('div.animeDetailBox > div.animeDetailL > dl#detailStaff > dd > ul > li')->each(function ($staff) use(&$staffs){
                    $staff_name = $staff->text();
                    array_push($staffs, $staff_name);
                });
                $staff = implode(',', $staffs);
                var_dump($staff);

                var_dump('story');
                $story_text = $anime_crawler->filter('div.animeDetailBox > dl#detailSynopsis > dd');
                $story = null;
                if(count($story_text) > 0){
                    $story = $story_text->text();
                    var_dump($story);
                }

                var_dump('music');
                $music_text = $anime_crawler->filter('div.animeDetailBox > dl#detailMusic > dd');
                $music = null;
                if(count($music_text) > 0){
                    $music = $music_text->text();
                    var_dump($music);
                }

                var_dump('cast main');
                $casts = [];
                $cast_main = $anime_crawler->filter('div.animeDetailBox > dl#detailCast > dd > ul > li')->each(function ($cast) use(&$casts){
                    $cast_name = $cast->text();
                    array_push($casts, $cast_name);
                });
                $cast = implode(",", $casts);
                var_dump($cast);

                var_dump('link');
                $link_text = $anime_crawler->filter('div.animeDetailBox > dl#detailLink > dd > ul > li > a');
                $link = null;
                if(count($link_text) > 0){
                    $link = $link_text->attr('href');
                    var_dump($link);
                }

                $item = new Item;

                $item->title = $title;
                $item->image = $image;
                $item->season = $season;
                $item->company = $company;
                $item->staff = $staff;
                $item->story = $story;
                $item->music = $music;
                $item->cast = $cast;
                $item->link = $link;

                $item->save();
            });
        });
    }
}
