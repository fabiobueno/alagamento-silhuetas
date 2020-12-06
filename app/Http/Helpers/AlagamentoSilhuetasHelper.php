<?php

namespace App\Http\Helpers;

class AlagamentoSilhuetasHelper
{

    /**
     * Creates the map based on the data in the file
     *
     * @param $data
     * @return array
     */
    public static function createMap($data): array
    {
        $width = count($data);
        $height = max($data);
        $map = [];

        for($h = ($height - 1); $h >= 0; $h--){
            for($w = 0; $w < $width; $w++){
                if($data[$w]){
                    $map[$h][$w] = 1;
                    $data[$w]--;
                    continue;
                }

                $map[$h][$w] = 0;
            }
        }

        ksort($map);

        return $map;
    }


    /**
     * Validates each position of the mapping and calculates the flooded area
     *
     * @param $map
     * @param $data
     * @param $y
     * @return int
     */
    public static function calculateFloods($map, $data, $y): int
    {
        $height = max($data);
        $x = 0;

        $floods = 0;
        for($y; $y < $height; $y++){
            if(isset($map[$y][$x+1])){
                if($map[$y][$x+1]){
                    $y = ($height - $data[$x+1]) - 1;
                    $x++;
                    continue;
                }

                $floods += AlagamentoSilhuetasHelper::countFlood(($x+1), $map[$y]);
            }
        }

        return $floods;
    }

    /**
     * Calculates the amount of flooded areas
     *
     * @param $init
     * @param $mapRow
     * @return int
     */
    private static function countFlood($init, $mapRow): int
    {
        $tmp = 0;
        for($i = $init; $i < count($mapRow); $i++){
            if($mapRow[$i]){
                return $tmp;
            }
            $tmp++;
        }

        return 0;
    }

}
