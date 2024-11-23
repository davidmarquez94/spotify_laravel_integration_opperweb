<?php

namespace App\Helpers;

class SpotifyHelper {
    public static function getSpotifyToken() {
        $endpoint = env('SPOTIFY_TOKEN_URL');
        $client_id = env('SPOTIFY_CLIENT_ID');
        $client_secret = env('SPOTIFY_CLIENT_SECRET');
        $auth_string = self::prepareAuthString($client_id, $client_secret);

        $result = self::consumeSpotifyTokenService($endpoint, $auth_string);
        return $result;
    }

    private static function prepareAuthString($client_id, $client_secret) {
        $auth_string = $client_id . ':' . $client_secret;
        $encoded_auth_string = base64_encode($auth_string);

        return $encoded_auth_string;
    }

    private static function consumeSpotifyTokenService($endpoint, $auth_string) {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . $auth_string,
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    public static function getSpotifyLastestReleases($access_token, $limit, $offset) {
        $endpoint = env('SPOTIFY_URL') . env('SPOTIFY_LASTEST_RELEASES_ENDPOINT') . '?limit=' . $limit . '&offset=' . $offset;
        $result = self::consumeSpotifyApi($endpoint, $access_token);

        return $result;
    }

    public static function getSpotifyAlbum($access_token, $album_id) {
        $endpoint = env('SPOTIFY_URL') . env('SPOTIFY_ALBUM_ENDPOINT') . $album_id;
        $result = self::consumeSpotifyApi($endpoint, $access_token);

        return $result;
    }

    public static function getSpotifyArtist($access_token, $artist_id) {
        $endpoint = env('SPOTIFY_URL') . env('SPOTIFY_ARTISTS_ENDPOINT') . $artist_id;
        $result = self::consumeSpotifyApi($endpoint, $access_token);

        return $result;
    }

    private static function consumeSpotifyApi($endpoint, $access_token) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $access_token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}