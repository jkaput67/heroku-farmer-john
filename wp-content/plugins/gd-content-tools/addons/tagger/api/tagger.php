<?php

if (!defined('ABSPATH')) exit;

class gdcet_tagger_api {
    function __construct() { }

    public function get_tags_from_internal($title, $content) {
        require_once(GDCET_PATH.'addons/tagger/api/extractor.php');

        $phpseo = new gdcet_terms_extractor($title.' '.strip_shortcodes(strip_tags($content)));

        return $phpseo->getKeyWords(256);
    }

    public function get_tags_from_opencalais($title, $content, $timeout = -1, $api_token = '') {
        if (empty($api_token)) {
            return 'api_token_missing';
        }

        $timeout = absint($timeout);
        if ($timeout > -1) {
            $timeout = $timeout < 15 ? 120 : $timeout;
            set_time_limit($timeout);
        }

        if (!function_exists('curl_init')) {
            return array();
        }

        $content = $title.' '.strip_shortcodes(strip_tags($content));
        $tags = '';

        $headers = array(
            'X-AG-Access-Token: '.$api_token,
            'Content-Type: text/raw',
            'Content-length: '.strlen($content),
            'outputFormat: application/json'
        );

        $crl = curl_init();
        curl_setopt($crl, CURLOPT_URL, 'https://api.thomsonreuters.com/permid/calais');
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($crl, CURLOPT_TIMEOUT, 3600);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $content);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($crl, CURLOPT_CAINFO, D4PLIB_CACERT_PATH);

        try {
            $response = @curl_exec($crl);

            if (curl_errno($crl)) {
                $tags = curl_error($crl);
            } else {
                $results = json_decode($response);

                if ($results) {
                    $tags = array();

                    foreach ($results as $data) {
                        if (isset($data->_typeGroup) && isset($data->name) && $data->_typeGroup == 'socialTag') {
                            $tags[] = $data->name;
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            $tags = $exc->getTraceAsString();
        }

        curl_close($crl);
        return $tags;
    }

    public function get_tags_from_dandelion($title, $content, $timeout = -1, $api_token = '', $app_id = '', $app_key = '') {
        if (empty($api_token) && empty($app_id) && empty($app_key)) {
            return 'token_key_or_id_missing';
        }

        $timeout = absint($timeout);
        if ($timeout > -1) {
            $timeout = $timeout < 15 ? 120 : $timeout;
            set_time_limit($timeout);
        }

        if (!function_exists('curl_init')) {
            return array();
        }

        $content = $title."\r\n".strip_shortcodes(strip_tags($content));
        $tags = '';

        $url = 'https://api.dandelion.eu/datatxt/nex/v1/';

        if ($api_token != '') {
            $url.= '?token='.$api_token;
        } else {
            $url.= '?$app_id='.$app_id.'&$app_key='.$app_key;
        }

        $url.= '&min_confidence=0.6&social=False&include=categories,types,abstract&text='.urlencode($content);

        $clean_url = substr($url, 0, 4096);

        $crl = curl_init();
        curl_setopt($crl, CURLOPT_URL, $clean_url);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($crl, CURLOPT_TIMEOUT, 3600);
        curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($crl, CURLOPT_CAINFO, D4PLIB_CACERT_PATH);

        try {
            $response = @curl_exec($crl);

            if (curl_errno($crl)) {
                $tags = curl_error($crl);
            } else {
                $results = json_decode($response);

                if (isset($results->annotations) && is_array($results->annotations) && !empty($results->annotations)) {
                    $tags = array();

                    foreach ($results->annotations as $keyword) {
                        $tags[] = $keyword->title;
                    }
                }
            }
        } catch (Exception $exc) {
            $tags = $exc->getTraceAsString();
        }

        curl_close($crl);
        return $tags;
    }
}
