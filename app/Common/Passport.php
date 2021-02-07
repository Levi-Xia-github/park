<?php


namespace app\Common;


class Passport
{
    public static function createUserToken($sessionId, $userId) {
        $version = 9;
        $createTime = time();
        $originToken = "{$version}%{$sessionId}%{$userId}%{$createTime}";

        $sign = self::sign($originToken, $version, $userId);
        $seperate = mt_rand(4,12);
        $signPart1 = substr($sign, 0,$seperate);
        $signPart2 = substr($sign, $seperate);

        $accessToken = "{$signPart2}%{$version}%{$sessionId}%{$signPart1}%{$userId}%{$createTime}";
        return $accessToken;
    }

    public static function translateUserToken($accessToken) {
        $tokenParts = explode("%", $accessToken);
        if (!is_array($tokenParts) || count($tokenParts) < 6) {
            return false;
        }
        $sign2 = $tokenParts[0];
        $version = $tokenParts[1];
        $sessionId = $tokenParts[2];
        $sign1 = $tokenParts[3];
        $userId = $tokenParts[4];
        $createTime = $tokenParts[5];
        $inputSign = "{$sign1}{$sign2}";

        $originToken = "{$version}%{$sessionId}%{$userId}%{$createTime}";
        $sign = self::sign($originToken, $version, $userId);

        if ($sign !== $inputSign) {
            return false;
        }
        return array(
            'userId' => $userId,
            'sessionId' => $sessionId,
            'createTime' => $createTime,
        );
    }

    private static function sign($accessToken, $version, $userId) {

        $str = 'f2d242522ba21237534c8e9647248e0a';

        $salt = "{$userId}.{$version}.$str";
        $sign = md5($accessToken.$salt);
        $sign = substr($sign, 0, 8) . substr($sign, -8);
        return $sign;
    }
}