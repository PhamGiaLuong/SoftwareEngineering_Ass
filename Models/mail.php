<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'gialuongpham70@gmail.com';
            $this->mail->Password = 'uynq mamk jiyu wrey';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;
            $this->mail->setFrom('no-reply@example.com', 'BK Study Space');

            // Cấu hình email gửi dạng HTML
            $this->mail->isHTML(true);
        } catch (Exception $e) {
            die("Mailer Error: " . $this->mail->ErrorInfo);
        }
    }

    public function sendEmail($to, $title, $content) {
        try {
            $this->mail->clearAddresses(); // Xóa địa chỉ cũ (nếu có)
            $this->mail->addAddress($to);
            $this->mail->Subject = $title;
            $this->mail->Body = $content;

            return $this->mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}

?>