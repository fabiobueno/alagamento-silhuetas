<?php

namespace App\Http\Controllers;

use App\Http\Helpers\AlagamentoSilhuetasHelper;
use Illuminate\Http\Request;

class AlagamentoController extends Controller
{

    /**
     * Receives the file with the cases and processes
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function processFile(Request $request)
    {
        $request->validate(
            [
                'file' => 'required|mimes:txt|max:2048',
            ],
            [
                'file.mimes' => 'Enviar um arquivo no formato TXT',
                'file.required' => 'É necessário enviar um arquivo',
                'file.max' => 'O tamanho maximo do arquivo é 2mb'
            ]
        );

        $dataFile = file($request->file->path(), FILE_IGNORE_NEW_LINES);

        $casesCount = $dataFile[0];
        $cases = [];
        $next = 1;

        foreach ($dataFile as $key => $fileLine){
            if ($fileLine == '' || $key == 0 || $key != $next){
                continue;
            }

            $cases[] = [
                'length' => $fileLine,
                'data' => explode(' ', $dataFile[$key+1])
            ];

            $next = $key+2;
        }

        if ($casesCount != count($cases)){
            $message = "Quantidade de casos incorreta";
            return view('home', ['message' => $message]);
        }

        //Creat a map
        $results = [];
        foreach($cases as $case){
            $map = AlagamentoSilhuetasHelper::createMap($case['data']);

            $startY = (max($case['data']) - $case['data'][0]);

            //Calculate results
            $results[] = AlagamentoSilhuetasHelper::calculateFloods($map, $case['data'], $startY);
        }

        return view('home', ['results' => $results]);
    }
}
