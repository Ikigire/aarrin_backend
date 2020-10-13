<?php
    require_once(__DIR__."/../vendor/autoload.php");

    use Firebase\JWT\JWT;

class TokenTool {
    /**
     * @var string $SECRET_KEY Clave secreta para generación de tokens
     */
    private static $SECRET_KEY = 'WPL4*#96/8s?dh587Q@-H446s(ad¡OÑoiñpbvadv4v6s9d_84AAJKH9+8732_Nq$#"523978!#%OI.JUV140';

    /**
     * @var string $ENCRYPTH Método de encriptación
     */
    private static $ENCRYPTH = ['HS256'];

    /**
     * @param array $data Datos a guardar dentro del token
     * @param int $time El tiempo en horas que será válido el token
     
     * @return string Token generado
     */
    public static function createToken(array $data, int $time = 10) {
        $payload = array(
            'iat' => time(),
            'exp' => (time() + $time *60 *60),
            'aud' => self::getAud(),
            'data' => $data
        );
        
        return JWT::encode($payload, self::$SECRET_KEY);
    }

    /**
     * @param string $token Token para validar
     * 
     * @return boolean true= Token válido; false= Toke no válido
     */
    public static function isValid($token){
        $valid = null;
        if (empty($token)){
            $valid = false;
        }

        try {
            $payload = JWT::decode($token, self::$SECRET_KEY, self::$ENCRYPTH);
            if ($payload->aud === self::getAud()){
                $valid = true;
            }else{
                $valid = false;
            }
        } catch (\Throwable $th) {
            $valid = false;
        }
        return $valid;
    }

    /**
     * @param string $token Token para validar
     * 
     * @return array|boolean Valores guardados dentro del token| el token no contiene datos
     */
    public static function getData($token) {
        if (empty($token)) {
            throw false;
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

    /**
     * @return string Información del cliente que está solicitando la información
     */
    private static function getAud() {

        $aud = $_SERVER['REMOTE_ADDR'];

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}

?>