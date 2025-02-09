<?php
/**
 * Created by PhpStorm.
 * User: msaif
 * Date: 11/14/2019
 * Time: 2:23 PM
 */

namespace App\Helpers;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use App\User;

class General
{

    //Create Product Interval based on min and max quantity.
    public static function CreateProductInterval($min, $max, $interval)
    {
        $intervalArr = [];
        if ($interval > $max)
            return $intervalArr;
        if (isset($min) && isset($max) && isset($interval)) {
            for ($i = $min; $i <= $max; $i += $interval) {
                array_push($intervalArr, "$i");
                if ($i + $interval >= $max) {
                    array_push($intervalArr, "$max");
                    break;
                }
            }

        }
        return $intervalArr;
    }
    //geerate random code
    public static function generateCode($length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //Oauth Client token function
    //Oauth Client token function
    public static function oauthClient($username, $password)
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://127.0.0.1:8000/',
            'timeout' => 10, // Set 10 seconds timeout
        ]);
        $response = $client->request('POST', url('/') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '4',
                'client_secret' => 'rzlYOZdWGg9LLhAzctG7tdZ7gbzzb8TtY9E522To',
                'username' => $username,
                'password' => $password,
                'scope' => '*',
            ],
        ]);
        return $response;
    }

    /**
     * Paginate given array with appending parameters and number of objects per page
     * @param $data
     * @param array $params
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public static function paginateArray($data, $params = array(), $perPage = 12)
    {
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($data);

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);

        // set url path for generated links
        $paginatedItems->setPath(url()->current())->appends($params);

        return $paginatedItems;
    }

    public static function createPaginationArray($resourceCollection)
    {
        $data = array();
        $data['size'] = $resourceCollection->perPage();
        $data['total'] = $resourceCollection->total();
        $data['current'] = $resourceCollection->currentPage();
        $data['first'] = $resourceCollection->url(1);
        $data['last'] = $resourceCollection->url($resourceCollection->lastPage());
        $data['prev'] = $resourceCollection->previousPageUrl();
        $data['next'] = $resourceCollection->nextPageUrl();
        $data['totalPages'] = $resourceCollection->lastPage();
        return $data;
    }

    public static function getMobileUser($request)
    {
        if ($request->hasHeader('deviceId')) {
            $user = User::where('device_id', $request->header('deviceId'))->first();
            if (!$user)
                $user = User::create(['device_id' => $request->header('deviceId'), 'password' => bcrypt($request->header('deviceId'))]);
        }
        elseif (auth('api')->check())
        {
            $user = auth('api')->user();
        }
        else {
            return null;
        }
        return $user;
    }
}
