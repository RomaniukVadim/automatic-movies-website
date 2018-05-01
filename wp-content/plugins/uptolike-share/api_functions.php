<?php
//1.4.8 12/04/16

const HOST = 'https://uptolike.com/';

/**
 * @param $email
 * @param $partnerId 'cms' for cms modules
 * @param $projectId 'cms'.site name
 *
 * @return bool|string 'if false - somthing wrong, if string - it's cryptkey'
 */
function userReg($email, $partnerId, $projectId) {

    if ($email !== '' && $partnerId !== '' && $projectId !== '') {
        $url = 'https://uptolike.com/api/getCryptKeyWithUserReg.json?' . http_build_query(array('email' => $email, 'partner' => $partnerId, 'projectId' => $projectId));

        $jsonAnswer = file_get_contents($url);
        if (false !== $jsonAnswer) {
            $answer = json_decode($jsonAnswer);
            return $answer->cryptKey;
        } else return $jsonAnswer;

    } else return 'one of params is empty';
}

/**
 * @param $partnerId String'cms' for cms modules
 * @param $email String
 * @param $cryptKey String
 */
function statIframe($partnerId, $mail, $cryptKey) {
    $params = array('mail' => $mail, 'partner' => $partnerId);
    $paramsStr = 'mail=' . $mail . '&partner=' . $partnerId;
    $signature = md5($paramsStr . $cryptKey);
    $params['signature'] = $signature;
    $finalUrl = 'https://uptolike.com/api/statistics.html?' . http_build_query($params);

    return $finalUrl;
}

/**
 * @param $mail user email
 * @param $partnerId 'cms' for cms sites
 * @param $projectId 'cms'.site_name
 * @param $cryptKey crypt key, received from server
 *
 * @return string
 */
function constructorIframe($mail, $partnerId, $projectId, $cryptKey) {

    $params = array('mail' => $mail, 'partner' => $partnerId, 'projectId' => $projectId);

    $paramsStr = 'mail=' . $mail . '&partner=' . $partnerId . '&projectId=' . $projectId . $cryptKey;
    $signature = md5($paramsStr);
    $params['signature'] = $signature;
    $finalUrl = 'https://uptolike.com/api/constructor.html?' . http_build_query($params);

    return $finalUrl;
}
