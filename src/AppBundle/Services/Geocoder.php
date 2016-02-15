<?php
/**
 * Created by Extellient.
 * User: goto
 * Date: 12/02/16
 * Time: 10:37
 */

namespace AppBundle\Services;


class Geocoder
{

    static private  $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBudmeEvv-AOHYG2Vp0xjJ758gEPkhGjn8&latlng=";

    static public function getLocation($lat, $lng){
        $url = self::$url . urlencode($lng).','.urlencode($lat);

        $resp_json = self::curl_file_get_contents($url);
        $resp = json_decode($resp_json, true);

        if($resp['status']='OK'){
            return $resp["results"][0]["address_components"];
        }else{
            return [];
        }
    }


    static private function curl_file_get_contents($URL){
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
    }


    static public function getCountryFromAddress(array $results) {
        foreach( $results as $result) {
            if(isset($result["types"][0]) and $result["types"][0] == "country" ) {
                return $result["long_name"];
            }
        }
        return false;
    }

    static public function getCityFromAddress(array $results) {
        foreach( $results as $result) {
            if(isset($result["types"][0]) and $result["types"][0] == "locality" ) {
                return $result["long_name"];
            }
        }
        return false;
    }

    static public function getDepartmentFromAddress(array $results) {
        foreach( $results as $result) {
            if(isset($result["types"][0]) and $result["types"][0] == "administrative_area_level_2" ) {
                return $result["long_name"];
            }
//            if(isset($result["types"][0]) and $result["types"][0] == "postal_code" ) {
//                return substr( $result["long_name"] ,0,2 );
//            }
        }
        return false;
    }
}