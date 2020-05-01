<?php
    require_once(__DIR__.'/../vendor/autoload.php');

    use Firebase\JWT\JWT;

class TokenTool {
        private static $SECRET_KEY = 'WPL4*#96/8s?dh587Q@-H446s(ad¡OÑoiñpbvadv4v6s9d_84AAJKH9+8732_Nq$#"523978!#%OI.JUV140';
        private static $ENCRYPTH = ['HS256'];

        public static function createToken($data) {
            $payload = array(
                'iat' => time(),
                'aud' => self::getAud(),
                'data' => $data
            );
            
            return JWT::encode($payload, self::$SECRET_KEY);
        }

        public static function isValid($token){
            if (empty($token)){
                return false;
            }

            try {
                $payload = JWT::decode($token, self::$SECRET_KEY, self::$ENCRYPTH);
                if ($payload->aud === self::getAud()){
                    return true;
                }else{
                    return false;
                }
            } catch (\Throwable $th) {
                return false;
            }
        }

        public static function getData($token) {
            if (empty($token)) {
                throw new Exception("Error: Empty token provided");
            }

            try {
                $payload = JWT::decode($token, self::$SECRET_KEY, self::$ENCRYPTH);
                if ($payload->aud === self::getAud()) {
                    return (array) $payload->data;
                }
            } catch (\Throwable $th) {
                return false;
            }
    
        }

        private static function getAud() {

            $aud = $_SERVER['REMOTE_ADDR'];

            $aud .= @$_SERVER['HTTP_USER_AGENT'];
            $aud .= gethostname();

            return sha1($aud);
        }
    }

?>