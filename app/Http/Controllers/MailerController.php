<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Storage;

class MailerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->has("name") && $request->has("phone") && $request->has("checkbox")) {

            $name = $request->input("name");
            $phone = $request->input("phone");
            $email = $request->input("email");
            $checkbox = $request->input("checkbox");

            $mail = new PHPMailer;
            $mail->CharSet = 'UTF-8';
            
            try {
                
                // Настройки SMTP
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPDebug = 1;

                $mail->Host = 'ssl://' . config('mail.mailers.smtp.host');
                $mail->Port = config('mail.mailers.smtp.port');
                $mail->Username = config('mail.mailers.smtp.username');
                $mail->Password = config('mail.mailers.smtp.password');

                // От кого
                $mail->From = config('mail.from.address');
                $mail->FromName = config('mail.from.name');

                // Кому
                $mail->addAddress('260443@mail.ru', 'info');

                // Тема письма
                $mail->Subject = 'Сообщение с сайта semena-darom.ru';

                $mail->isHTML(true);

                if (strlen($name) >= 3 &&
                    strlen($name) <= 50 &&
                    strlen($phone) == 18 && 
                    $checkbox) {

                    // Тело письма
                    $mail->Body = "Имя: $name<br> Телефон: $phone<br> Email: $email<br>";
                    $mail->AltBody = "Имя: $name\r\n Телефон: $phone\r\n Email: $email\r\n";

                    $mail->send();
                }

                $mail->smtpClose();

                return false;

            } catch (Exception $e) {
                Storage::disk('public')->put('mailer_error.txt', $e);
                return false;
            }

        } else {
            return redirect('/');
        }
    }
}
