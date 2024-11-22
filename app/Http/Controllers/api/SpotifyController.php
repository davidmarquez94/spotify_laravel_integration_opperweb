<?php

namespace App\Http\Controllers\api;

use App\Helpers\SpotifyHelper;
use App\Helpers\ValidationHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class SpotifyController extends Controller
{
    //Obtiene los últimos X lanzamientos definidos por el usuario
    public function getLastestReleases(Request $request) {
        //Valida campos de request
        $valid = ValidationHelper::validateLimit($request->all());
        if(!$valid['success']) {
            return response()->json([
                'success' => $valid['success'],
                'errors' => $valid['errors']
            ], 400);
        }

        try {
            $token = SpotifyHelper::getSpotifyToken();
            $limit = $request->limit;
            $offset = $request->offset;
            $result = SpotifyHelper::getSpotifyLastestReleases($token->access_token, $limit, $offset);
            return response()->json([
                'success' => true,
                'data' => $result
            ], 200);
        } catch(Exception $e) {
            //Respuesta de error 500
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
