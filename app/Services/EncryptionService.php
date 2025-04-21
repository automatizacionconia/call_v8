<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EncryptionService
{
    public static function encrypt($model)
    {
        $array = $model->toArray();
        foreach ($model::keys as  $item) {
            foreach ($item as $key => $value) {
                if ($array[$key]) {
                    $array[$key] = self::encryptAttribute($array[$key]);
                }
            }
        }
        $model->fill($array);
        return $model;
    }

    public static function decrypt($model, Request $request)
    {
        foreach ($model::keys as $key => $value) {
            if (array_key_exists($value, $request->all())) {
                if ($request[$value]) {
                    $request[$value] = self::decryptAttribute($request[$value]);
                }
            }
        }
        return $request;
    }

    public static function encryptForResource($model, $array)
    {
        foreach ($model::keys as  $key => $value) {
            if (array_key_exists($value, $array)) {
                if ($array[$value]) {
                    $array[$value] = self::encryptAttribute($array[$value]);
                }
            }
        }
        return $array;
    }

    public static function encryptAttribute($value, $serialize = false)
    {
        if ($serialize) {
            return Crypt::encrypt($value);
        }
        return Crypt::encryptString($value);
    }

    public static function decryptAttribute($value, $serialize = false)
    {
        if ($serialize) {
            return Crypt::decrypt($value);
        }
        return Crypt::decryptString($value);
    }
}
