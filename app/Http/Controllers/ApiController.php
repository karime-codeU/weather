<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function obtenerAlertas(){
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://weatherbit-v1-mashape.p.rapidapi.com/alerts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: weatherbit-v1-mashape.p.rapidapi.com",
                "xrapidapi-key: db38d893a1mshe2cb39199fadf42p1ccf6ajsnc45a09a30a56"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if($err){
            echo "cURL Error #:" . $err;
        } else {
            $objeto = json_decode($response);
            foreach ($objeto -> data as $alerta){
                echo json_encode($alerta);
                $nalerta = Alerta::where('country_code','==',$alerta->country_code)->first();
                if(!$nalerta)
                    $nalerta = new Alerta();
                
                $nalerta->country_code = $alerta->country_code;
                $nalerta->lon = $alerta->lon;
                $nalerta->timezone = $alerta->timezone;
                $nalerta->lat = $alerta->lat;
                $nalerta->alerts = $alerta->alerts;
                $nalerta->city_name = $alerta->city_name;
                $nalerta->state_code = $alerta->state_code;
                $nalerta->save();
            }
        }
    }

    public function mostrarAlertas(){
        $alertas = Alerta::all();
        echo json_encode($alertas);
    }

    
}
