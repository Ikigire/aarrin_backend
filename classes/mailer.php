<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Mailer {
    /**
     * @access protected
     * @final HOST relay link para el servidor de correos
     */
    private const HOST = 'a2plcpnl0765.prod.iad2.secureserver.net';

    /**
     * @access protected
     * @final USER_NAME Nombre de usuario a mostrar como remitente
     */
    private const USER_NAME = 'web_app@aarrin.com';

    /**
     * @static
     * Función para crear y configurar un objeto para el manejo de envío de emails
     * @return PHPMailer objeto configurado para el envío de emails
     */
    private static function configMailer()
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                   // Send using SMTP
            $mail->Host       = self::HOST;                    // Set the SMTP server to send through
            $mail->SMTPAuth   = false;                         // Enable SMTP authentication
            $mail->SMTPSecure = 'tls';
        
            //Recipients
            $mail->setFrom(self::USER_NAME, 'ARI APP');
            $mail->addReplyTo('sales@aarrin.com', 'Sales contact');
            $mail->addReplyTo('system@aarrin.com', 'ARI system');
        } catch (Exception $e) {
            throw $e;
        }
        return $mail;
    }

    /**
     * @static
     * Función para enviar un email a un destinatario
     * @param string $to El correo al cual será enviado el correo
     * @param string $subject Asunto del correo
     * @param string $body Cuerpo del mensaje en formato HTML
     * @param string $altBody [opcional] Cuerpo alternativo del mensaje sin formato HTML
     * @return bool true si la operación fue exitosa, false si ocurrió un error
     */
    public static function sendMail(string $to, string $subject, string $body, string $altBody = "To view the message, please use an HTML compatible email viewer!")
    {
        $result = true;
        try {
            $mail = self::configMailer();
            // Content
            $mail->isHTML(true);               // Set email format to HTML
            $mail->addAddress($to);            // Add a recipient (destination email)
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = $altBody;
        
            $mail->send();
        } catch (\Throwable $th) {
            $result = false;
        }
        return $result;
    }
}
?>