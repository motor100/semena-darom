<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use YooKassa\Client;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Common\Exceptions\ApiException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;


class YookassaController extends Controller
{   

    /*
    *
    * Документация
    * https://yookassa.ru/developers/payments/payment-process?lang=php
    * https://github.com/yoomoney/yookassa-sdk-php
    *
    */

    /*
    * Платеж
    * Файлы redirect.php, yookassa.php и yookassa_key.php 
    * Подключение библиотеки из папки lib
    * 1. Передаю из формы данные: сумма (обязательно) и любую вторую строку. Имя, номер заказа и т.д.
    * Файл redirect.php
    * 2. Внутри файла redirect.php подключаю файл yookassa.php
    * 3. В файле yookassa.php формирую запрос и получаю $confirmationUrl для редиректа пользователя для * оплаты
    * 4. Перебрасываю пользователя на confirmationUrl
    * 5. Пользователь платит

    * Уведомление о платеже
    * Файл yookassa_event.php и yookassa_key.php
    * Подключение библиотеки из папки lib
    * 1. Для настройка уведомлений об оплате нужно в кабинете юкассы подписаться на уведомления и указать путь к файлу yookassa_event.php
    * 2. Получаю данные от юкассы
    * 3. Формирую новый запрос и получаю статус платежа по id
    * 4. Сравниваю статус от юкассы и статус из нового запроса.
    * 5. Если все ок - то уведомление заказчиков. Отправка на почту и т.д.

    * Документация
    * https://yookassa.ru/developers/payments/payment-process?lang=php
    * https://github.com/yoomoney/yookassa-sdk-php
    *
    */

    /**
     * Создание платежа
     * 
     * @param string $summ
     * @param string $order_number
     * @return string
     */
    public function create_payment($summ, $order_number): string
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'];

        $description = 'Номер заказа ' . $order_number;

        // создаю экземпляр объекта платежа
        $client = new Client();
        $client->setAuth(config('yookassa.shopId'), config('yookassa.secretKey'));

        try {
            $idempotenceKey = uniqid('', true);
            $response = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => $summ, // Сумма платежа
                        'currency' => 'RUB',
                    ),
                    'confirmation' => array(
                        'type' => 'redirect',
                        'locale' => 'ru_RU',
                        'return_url' => $url, // Вернуться в магазин после оплаты
                    ),
                    'capture' => true,
                    'description' => $description,
                    'metadata' => array(
                        'order_number' => $order_number
                    ),
                ),
                $idempotenceKey
            );

            // Получаю confirmationUrl для дальнейшего редиректа
            return $response->getConfirmation()->getConfirmationUrl();

        } catch (\Exception $e) {
            $response = $e;
        }
    }

    /**
     * Получение url для оплаты и редирект на него
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function redirect(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "summ" => 'required|numeric',
            "order_id" => 'required|numeric'
        ]);

        $confirmation_url = $this->create_payment($validated["summ"], $validated["order_id"]);

        // Если url получен, то перенаправляю на него
        if ($confirmation_url) {
            return redirect($confirmation_url);
        }

        return redirect()->route('thankyou')->withErrors(['error' => 'Something went wrong'])->withInput();
    }

    /**
     * Получение статуса платежа
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function yookassa_event(Request $request): Response
    {
        $method = $request->method();

        // Получите данные из POST-запроса от ЮKassa
        $requestBody = $request->json()->all();

        $event = $requestBody['event'];

        // Создайте объект класса уведомлений в зависимости от события
        require $_SERVER['DOCUMENT_ROOT'] . '/public/vendor/yookassa/lib/autoload.php';

        try {
            $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
                ? new NotificationSucceeded($requestBody)
                : new NotificationWaitingForCapture($requestBody);
        } catch (ApiException $e) {
            // Обработка ошибок при неверных данных
            $error = "Неверные данные: " . $e;
        }
        
        // Получите объект платежа
        $payment = $notification->getObject();

        // $paymentId = $payment['id'];
        $paymentId = $payment->getId();
        $paymentStatus = $payment->getStatus();
        $paymentDescription = $payment['description'];
        $paymentOrderNumber = $payment['metadata']['order_number'];
        $paymentAmountValue = $payment['amount']['value'];

        // $payment_text = $paymentId . " " . $paymentStatus . " " . $paymentDescription . " " . $paymentOrderNumber . " " . $paymentAmountValue;

        // Запрашиваю информацию о статусе платежа по id
        $client = new Client();
        $client->setAuth(config('yookassa.shopId'), config('yookassa.secretKey'));

        $payment1 = $client->getPaymentInfo($paymentId);

        // $status = $payment1['status'];
        $status = $payment1->getStatus();

        // Сравниваю статус из уведомления и из запроса
        if ($status == $paymentStatus) {
            // Действие если статусы одинаковые
            
            // Ищу заказ в таблице orders с id = $paymentOrderNumber
            // Обновляю payment на 1

            $now = date('Y-m-d H:i:s');

            \App\Models\Order::where('id', $paymentOrderNumber)
                            ->update([
                                'payment' => 1,
                                'updated_at' => $now
                            ]);

            // Отправляю в юкассу 200 OK
            return response('OK', 200);

        } else {
            // Действие если статусы разные
            // Отправляю в юкассу 400 Something went wrong
            return response('Something went wrong', 400);
        }
    }
}
