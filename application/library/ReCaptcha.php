<?php


/**
 * Description of ReCaptcha
 *
 * @author chintanm87
 */
class ReCaptcha {

    private $site_key = 'SITE_Key';
    private $secret_key = 'SECRET_KEY';
    private $url = "https://www.google.com/recaptcha/api/siteverify";
    private $remote_ip = '';
    private $response = '';

    public function __construct() {
        
    }

    public function set_remote_ip($remoteip) {
        $this->remote_ip = $remoteip;
    }

    public function get_site_key() {
        return $this->site_key;
    }

    public function set_response($resoponse) {
        $this->response = $resoponse;
    }

    public function verify_captcha($param = array()) {
        $data = array(
            'secret' => $this->secret_key
        );
        if (array_key_exists('response', $param)) {
            $data['response'] = $param['response'];
        } else {
            $data['response'] = $this->response;
        }
        if (array_key_exists('remoteip', $param)) {
            //       $data['remoteip'] = $param['remoteip'];
        } else {
            $data['remoteip'] = $this->remote_ip;
        }

        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, $this->url);
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($verify, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($verify);
        if (curl_errno($verify)) {
            return 0;            
        }
        $response_arr = json_decode($response);
        return $response_arr->success;
    }

}
