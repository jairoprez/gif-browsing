<?php

namespace App\Http\Controllers;

use App\SearchLog;
use App\FavoriteGif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class GifController extends Controller
{
    const BASE_URI = 'https://api.giphy.com/v1/';

    protected $http;
    protected $giphyApiKey;

    public function __construct()
    {
        $this->http = new Client(['base_uri' => self::BASE_URI]);
        $this->giphyApiKey = env('GIPHY_API_KEY');
    }

    /**
     * Allow user to perform a keyword search against the GIF database via the API
     * @param  Request $request
     * @return json
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        $keyword = $request->input('keyword'); 

        SearchLog::create([
            'user_id' => auth()->user()->id,
            'keyword' => $keyword,
        ]);

        $response = $this->http->request('GET', 'gifs/search', [
            'query' => [
                'api_key' => $this->giphyApiKey,
                'q' => $keyword,
                'limit' => 16
            ]
        ]);

        return $this->responseHandler($response->getBody());
    }

    /**
     * Return search history of a logged user
     * @return json
     */
    public function searchHistory()
    {
        $searchHistory = SearchLog::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();

        return response()->json($searchHistory, 200);
    }

    /**
     * Store favorite gif of a logged user
     * @param  Request $request
     * @return json
     */
    public function storeFavoriteGif(Request $request)
    {
        $validator = Validator::make($request->all(), ['gif_id' => 'required',]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            FavoriteGif::updateOrCreate(
                ['user_id' => auth()->user()->id, 'gif_id' => $request->input('gif_id')],
                ['user_id' => auth()->user()->id, 'gif_id' => $request->input('gif_id')]
            );

            return response()->json([
                'response' => true,
                'message' => 'Gif saved as favorite successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'response' => false,
                'message' => 'Gif not saved as favorite - ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Return favorite gifs of a logged user
     * @return json
     */
    public function favoriteGifs()
    {
        $favoriteGifs = FavoriteGif::where('user_id', auth()->user()->id)->get();

        if (count($favoriteGifs) > 0) {
            $ids = [];
            foreach ($favoriteGifs as $favorite) {
                array_push($ids, $favorite->gif_id);
            }
         
            $response = $this->http->request('GET', 'gifs', [
                'query' => [
                    'api_key' => $this->giphyApiKey,
                    'ids' => implode(',', $ids)
                ]
            ]);

            return $this->responseHandler($response->getBody());
        }
        
        return response()->json(['data' => []], 200);
    }

    public function responseHandler($response)
    {
        if ($response) {
            return json_decode((string) $response, true);
        }
        
        return [];
    }
}
