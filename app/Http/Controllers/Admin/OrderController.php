<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function PHPSTORM_META\type;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search_query' => 'nullable|numeric|digits:13'
        ]);

        if(isset($validated['search_query'])) {

            // $number = intval($validated['search_query']);

            // Генерация числа 13 знаков для штрихкода
            // Справа число из $validated['search_query'], остальное слева заполняю нолями
            // $barcode = (new \App\Services\Barcode())->int_to_barcode($order->id);;

            // Штрихкод 13 знаков
            // Справа число из id заказа, остальное слева заполняю нолями
            // Число в штрихкод - добавить ноли слева функция str_pad
            // Штрихкод в число - у строки убрать ноли слева

            // Убираю ноли в начале строки
            $id = (new \App\Services\Barcode())->barcode_to_int($validated['search_query']);

            $orders = Order::where('id', $id)
                            ->paginate(50)
                            ->onEachSide(1);
        } else {
            $orders = Order::orderBy('id', 'desc')
                            ->paginate(50)
                            ->onEachSide(1);
        }

        // Добавляю свойство barcode
        foreach($orders as $order) {
            $order->barcode = (new \App\Services\Barcode())->int_to_barcode($order->id);
        }

        return view('dashboard.orders', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id): View
    {
        $order = Order::findOrFail($id);

        // Число в номер телефона
        $order->phone = (new \App\Services\Phone())->int_to_phone($order->phone);

        // id в штрихкод
        $order->barcode = (new \App\Services\Barcode())->int_to_barcode($order->id);

        // Разные квитанции в зависимости от метода доставки
        if ($order->delivery == 'sdek') { // доставка СДЕК

            // Получаю модель CdekOrder по номеру заказа
            $cdek_order = \App\Models\CdekOrder::where('order_id', $id)->first();

            $is_waybill = false;

            // Если есть модель СdekOrder с таким order_id
            if ($cdek_order) {
                // Сравниваю updated_at с текущей датой и получаю разницу в минутах
                $diff_minutes = $cdek_order->updated_at->diffInMinutes(now());

                // 1 минута - время на формирование квитанции
                // 60 минут - ссылка на файл с квитанцией действует 1 час
                if ($diff_minutes > 1 && $diff_minutes < 60) {
                    $is_waybill = true;
                }
            }

            return view('dashboard.order-show', compact('order', 'is_waybill'));

        } else { // доставка Почта России
            return view('dashboard.order-show', compact('order'));

        }



        

        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => 'required|numeric',
            'status'  => 'required',
            'comment'  => 'nullable'
        ]);

        Order::where('id', $validated['id'])
                ->update([
                    'status' => $validated['status'],
                    'comment' => $validated['comment'],
                    'updated_at' => now()
                ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Страница для печати
     * @param string $id
     * @return Illuminate\View\View
     */
    public function print(string $id): View
    {
        // Получаю модель заказа
        $order = Order::findOrFail($id);

        // Добавляю штрихкод
        $order->barcode = (new \App\Services\Barcode())->int_to_barcode($order->id);

        // Сортировка товаров
        $products = (new \App\Services\ProductSort($order))->get();

        return view('dashboard.order-print', compact('order', 'products'));
    }

    /**
     * Check order and listing products
     * @param string $id
     * @return Illuminate\View\View
     */
    public function check(string $id): View
    {
        // Получаю модель заказа
        $order = Order::findOrFail($id);
        
        // Сортировка товаров в отдельном классе
        $products = (new \App\Services\ProductSort($order))->get();

        $total = [
            "quantity" => 0,
            "summ" => 0
        ];

        foreach($products as $product) {
            // Расчет количества всех товаров
            $total["quantity"] += $product->pivot->quantity;
            // Расчет суммы всех товаров
            $total["summ"] += $product->summ;
        }
        
        return view('dashboard.order-check', compact('id', 'products', 'total'));
    }
}
