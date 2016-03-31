<?php
define('LOGIN_FAIL', 4);
define('USER_IS_FREE', 5);
define('USER_IS_PREMIUM', 6);
define('ERR_FILE_NO_EXIST', 114);
define('ERR_REQUIRED_PREMIUM', 115);
define('ERR_NOT_SUPPORT_TYPE', 116);
define('DOWNLOAD_STATION_USER_AGENT', "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36");
define('DOWNLOAD_URL', 'downloadurl'); // Real download url
define('DOWNLOAD_FILENAME', 'filename'); // Saved file name define('DOWNLOAD_COUNT', 'count'); // Number of seconds to wait
define('DOWNLOAD_ISQUERYAGAIN', 'isqueryagain'); // 1: Use the original url query from the user again. 2: Use php output url query again.
define('DOWNLOAD_ISPARALLELDOWNLOAD', 'isparalleldownload');//Task can download parallel flag.
define('DOWNLOAD_COOKIE', 'cookiepath');
define('API_URL', 'https://api.real-debrid.com/rest/1.0');

class RealDebridV2FileHost
{
    private $url, $user, $pass, $hostInfo;

    public function __construct($url, $user, $pass, $hostInfo) {
        $this->url = $url;
        $this->user = $user;
        $this->pass = $pass;
        $this->hostInfo = $hostInfo;
    }

    public function GetDownloadInfo() {
        $res = $this->curl('POST', '/unrestrict/link', array('link' => $this->url));

        return array(
            //INFO_NAME                 => $this->hostInfo[INFO_NAME],
            DOWNLOAD_FILENAME           => $res['filename'],
            DOWNLOAD_URL                => $res['download'],
            DOWNLOAD_ISPARALLELDOWNLOAD => true,
        );
    }

    public function Verify($clearCookie) {
        $res = $this->curl('GET', '/user');

        return (isset($res['type']) && $res['type'] == 'premium') ? USER_IS_PREMIUM : LOGIN_FAIL;
    }

    // private

    private function curl($method, $uri, $params=array()) {
        $curl = curl_init();

        // generic options
        curl_setopt_array($curl, array(
            CURLOPT_USERAGENT           => DOWNLOAD_STATION_USER_AGENT,
            CURLOPT_SSL_VERIFYPEER      => FALSE,
            CURLOPT_RETURNTRANSFER      => TRUE,
            CURLOPT_HTTPHEADER          => array("Authorization: Bearer $this->user"),
        ));

        // method (POST or GET)
        if($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        elseif(!empty($params)) { // Get => add params to
            $uri .= '?' . http_build_query($params);    
        }
        curl_setopt($curl, CURLOPT_URL, API_URL . $uri);

        // execute
        $res = curl_exec($curl);
        curl_close($curl);

        return json_decode($res, TRUE);
    }
}

