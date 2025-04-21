<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class DeviceIdentifier
{
    public static function get()
    {
        $data = [
            'ip' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
            'accept_language' => Request::header('Accept-Language'),
            'referer' => Request::header('Referer'),
            'timestamp' => time(),
        ];
        
        // Generar un hash único basado en la información recopilada
        $identifier = hash('sha256', json_encode($data));
        
        // Extraer información básica del User-Agent
        $userAgent = $data['user_agent'];
        $deviceInfo = [
            'browser' => self::getBrowser($userAgent),
            'platform' => self::getPlatform($userAgent),
            'device_type' => self::getDeviceType($userAgent),
        ];
        
        return [
            'identifier' => $identifier,
            'ip' => $data['ip'],
            'device_info' => json_encode(array_merge($data, $deviceInfo))
        ];
    }
    
    private static function getBrowser($userAgent)
    {
        $browser = "Desconocido";
        $browserList = [
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
        ];

        foreach ($browserList as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $browser = $value;
                break;
            }
        }
        return $browser;
    }
    
    private static function getPlatform($userAgent)
    {
        $os = "Desconocido";
        $osList = [
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile',
        ];

        foreach ($osList as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $os = $value;
                break;
            }
        }
        return $os;
    }
    
    private static function getDeviceType($userAgent)
    {
        $deviceType = "Desconocido";
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($userAgent))) {
            $deviceType = "Tablet";
        }
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($userAgent))) {
            $deviceType = "Móvil";
        }
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > -1) {
            $deviceType = "Móvil";
        }
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'ipod') > -1) {
            $deviceType = "Móvil";
        }
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'iphone') > -1) {
            $deviceType = "Móvil";
        }
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'ipad') > -1) {
            $deviceType = "Tablet";
        }
        if ($deviceType == "Desconocido") {
            $deviceType = "Desktop";
        }
        return $deviceType;
    }
}