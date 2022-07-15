<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\KeywordApi;

use App\Models\KeywordSearch;
use App\Models\OrganicResult;
use App\Models\UserSearch;
use App\Models\Setting;
use App\Models\Post;
use App\Models\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

use Hashids\Hashids;

use App\Mail\ContactUs;

use CyrildeWit\EloquentViewable\Support\Period;

use Illuminate\Support\Facades\Cache;

use Carbon\Carbon;

class PublicController extends Controller
{
    public function admin()
    {
        $posts = Post::query()->where('status', 1)->count();
        $users = User::query()->count();
        $search = UserSearch::query()->count();

        if (!Cache::has('keywords_count')) {
            $keywords = KeywordSearch::query()->where('status', 1)->count();
            Cache::put('keywords_count', $keywords, Carbon::now()->addDays(2));
        } else {
            $keywords = Cache::get('keywords_count');
        }

        return view('admin.dashboard', ['posts' => $posts, 'users' => $users, 'search' => $search, 'keywords' => $keywords]);
    }

    public function home()
    {
        $setting = Setting::find(1);
        $posts = Post::query()->where('status', 1)->limit(6)->orderBy('created_at', 'desc')->get();

        if (!Cache::has('popular_search')) {
            $popularSearch = KeywordSearch::query()->where('status', 1)->orderByViews('desc', Period::pastDays(10))->take(9)->get();
            Cache::put('popular_search', $popularSearch, Carbon::now()->addDays(10));
        } else {
            $popularSearch = Cache::get('popular_search');
        }

        return view('home.home', [
            'setting' => $setting,
            'posts' => $posts,
            'popularSearch' => $popularSearch
        ]);
    }

    public function search(Request $request)
    {   
        $search = $request->search;
        $search_result = null;
        $meta_keywords = '';
        $keywords = KeywordSearch::query()->with('organic')
            ->with('relatedSearch')
            ->where('status', 1)
            ->when(
                $request->search, 
                function ($query, $search) {
                    $query->where('slug', $search);
                }
            )
            ->get();

        if ($keywords->count() === 0) {
            
        } else {
            if ($keywords->first()->organic->count() >= 1) {
                $search_result = $keywords->first();
            }

            $keywords_related = [];

            if ($search_result != null) {
                $keywords_related = $search_result
                    ->relatedSearch
                    ->pluck('keywords')
                    ->toArray();

                array_unshift($keywords_related, $search_result->keywords);

                $meta_keywords = implode(
                    ',',
                    $keywords_related
                );
            }
        }

        $setting = Setting::find(1);

        $keyword = KeywordSearch::query()->where('slug', $search)->first();

        if (!empty($keyword)) {
            $expiresAt = now()->addHours(1);
            
            views($keyword)
                ->cooldown($expiresAt)
                ->record();
        }

        if (!Cache::has('popular_search')) {
            $popularSearch = KeywordSearch::query()->where('status', 1)->orderByViews('desc', Period::pastDays(10))->take(10)->get();
            Cache::put('popular_search', $popularSearch, Carbon::now()->addDays(10));
        } else {
            $popularSearch = Cache::get('popular_search');
        }

        $posts = Post::query()->where('status', 1)->limit(4)->get();

        return view('home.search', [
            'title' => ucwords($search_result->keywords ?? str_replace('-', ' ', $search)),
            'setting' => $setting,
            'search_result' => $search_result,
            'search' => $search,
            'keyword' => strip_tags($meta_keywords),
            'description' => strip_tags($search_result->keywords ?? ''),
            'posts' => $posts,
            'popular_posts' => $popularSearch
        ]);
    }

    public function processSearch(Request $request)
    {
        $title = $request->user_input;

        $search_result = null;
        $meta_keywords = '';
        $keywords = KeywordSearch::query()->with('organic')
            ->with('relatedSearch')
            ->when(
                $request->user_input, 
                function ($query, $search) {
                    $query->where('slug', self::clean($search));
                }
            )
            ->first();

        $setting = Setting::find(1);

        $bannedWords = explode(',', trim($setting->banned_keywords));

        $checker = [];

        foreach ($bannedWords as $key => $bannedWord) {
            $checker[] = str_contains($title, trim($bannedWord));
        }

        if ($keywords == null && !in_array(true, $checker)) {
            UserSearch::firstOrCreate([
                'keywords' => $title,
                'status' => 2
            ]);
        }

        return redirect()->route('search', ['search' => self::clean($title)]);
    }

    public function visitPage(Request $request)
    {
        $result_link = null;
        
        $hashids = new Hashids();

        $visit = $request->visit;
        if ($hashids->decode($request->cid) != null) {
            $result = OrganicResult::find($hashids->decode($request->cid)[0]);
        } else {
            return redirect()->back();
        }
		
		if ($result != null && $result->first()->count() >= 1) {
			$result_link = $result->first();
        } else {
            return redirect()->route('home');
        }
		
        $setting = Setting::find(1);

        if (!Cache::has('popular_search')) {
            $popularSearch = KeywordSearch::query()->where('status', 1)->orderByViews('desc', Period::pastDays(10))->take(10)->get();
            Cache::put('popular_search', $popularSearch, Carbon::now()->addDays(10));
        } else {
            $popularSearch = Cache::get('popular_search');
        }

        $posts = Post::query()->where('status', 1)->limit(4)->get();

        return view('home.show', [
            'title' => ucfirst($result->title),
            'setting' => $setting,
            'result_link' => $result_link,
            'result' => $result,
            'visit' => $visit,
            'keyword' => strip_tags(str_replace(' ', ',', $result->desc)),
            'description' => strip_tags($result->desc),
            'posts' => $posts,
            'popular_posts' => $popularSearch
        ]);
    }

    public function keywordSearch(Request $request)
    {
        $query = $request->search;
        $filterResult = KeywordSearch::query()->where('keywords', 'LIKE', '%'.$query.'%')
            ->where('status', 1)
            ->take(20)
            ->get(['slug', 'keywords']);

        return response()->json($filterResult);
    }

    public static function clean($string)
    {
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower($string));
    }

    public static function viewContactUs()
    {
        $setting = Setting::find(1);

        if (!Cache::has('popular_search')) {
            $popularSearch = KeywordSearch::query()->where('status', 1)->orderByViews('desc', Period::pastDays(10))->take(10)->get();
            Cache::put('popular_search', $popularSearch, Carbon::now()->addDays(10));
        } else {
            $popularSearch = Cache::get('popular_search');
        }

        $posts = Post::query()->where('status', 1)->limit(4)->get();

        return view('home.contact-us', [
            'setting' => $setting,
            'posts' => $posts,
            'popular_posts' => $popularSearch
        ]);
    }

    public static function contactUs(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'subject' => $request->subject,
        ];

        $mail = Mail::to('nitronetdavid@gmail.com')->send(new ContactUs($data));

        return redirect()->back()->with(['message' => 'Email sent']);
    }

    public static function privacyPolicy()
    {
        $setting = Setting::find(1);

        if (!Cache::has('popular_search')) {
            $popularSearch = KeywordSearch::query()->where('status', 1)->orderByViews('desc', Period::pastDays(10))->take(10)->get();
            Cache::put('popular_search', $popularSearch, Carbon::now()->addDays(10));
        } else {
            $popularSearch = Cache::get('popular_search');
        }

        $posts = Post::query()->where('status', 1)->limit(4)->get();
        
        return view('home.privacy-policy', [
            'setting' => $setting,
            'posts' => $posts,
            'popular_posts' => $popularSearch
        ]);
    }
}
