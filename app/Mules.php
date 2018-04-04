<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mules extends Model{
    const MULES = [
        [
            'id'=>1,
            'ip'=>'10.1.129.11',
            'desc'=>'',
            'tipo'=>'prod'
        ],
        [
            'id'=>2,
            'ip'=>'10.1.129.116',
            'desc'=>'',
            'tipo'=>'prod'
        ],
        [
            'id'=>3,
            'ip'=>'10.250.102.66',
            'desc'=>'',
            'tipo'=>'dev'
        ]
    ];

    public static function getMules(){ 
        return collect(SELF::MULES)->filter(function($i){ return $i['tipo']==env('MULE_ENGINE','dev');})->shuffle();
    }
}
