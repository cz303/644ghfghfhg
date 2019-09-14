<?php

class Freekassa
{
    private $event;

    public function __construct(FreekassaEvent $event)
    {
        $this->event = $event;
    }

    public function getResult()
    {
        $request = $_REQUEST;
        
        if (!empty($request['account'])
            AND !empty($request['sum'])
            AND $request['action'] == 'fk_go'
        ) return $this->GoTofreekassa($request);

        if (empty($request['MERCHANT_ID'])
            || empty($request['us_account'])
            || empty($request['SIGN'])
            || empty($request['AMOUNT'])
            || empty($request['intid'])
        )
        {
            return $this->getResponseError('Invalid request');
        }

        if ($request['SIGN'] != md5(Config::MERCHANT_ID.':'.$request['AMOUNT'].':'.Config::SECRET_KEY_2.':'.$request['MERCHANT_ORDER_ID']))        
        {
            return $this->getResponseError('Incorrect digital signature');
        }

        $freekassaModel = FreekassaModel::getInstance();
        
        if ($freekassaModel->getPaymentByFreekassaId($request['intid']))
        {
            // Платеж уже существует
            return $this->getResponseSuccess('Payment already exists');
        }
       
        $itemsCount = floor($request['AMOUNT'] / Config::ITEM_PRICE);
        if ($itemsCount <= 0)
        {
            return $this->getResponseError('Суммы ' . $request['AMOUNT'] . ' руб. не достаточно для оплаты товара ' .
                'стоимостью ' . Config::ITEM_PRICE . ' руб.');
        }
        if (!$freekassaModel->createPayment(
            $request['intid'],
            $request['us_account'],
            $request['AMOUNT'],
            $itemsCount
        ))
        {
            return $this->getResponseError('Unable to create payment database');
        }
        
        $checkResult = $this->event->check($request);
        if ($checkResult !== true)
        {
            return $this->getResponseError($checkResult);
        }
        
        $payment = $freekassaModel->getPaymentByFreekassaId($request['intid']);
        
        if ($payment && $payment->status == 1)
        {
            return $this->getResponseSuccess('Payment has already been paid');
        }

        if (!$freekassaModel->confirmPaymentByFreekassaId($request['intid']))
        {
            return $this->getResponseError('Unable to confirm payment database');
        }

        $this->event->pay($request);

        return $this->getResponseSuccess('YES');
    }
    
    private function GoTofreekassa($request)
    {
        $m = Config::MERCHANT_ID;
        $oa = $request['sum'];
        $o = 'Пополнение счета';
        $us_account = $request['account'];
        $s = md5(implode(':', array($m, $oa, Config::SECRET_KEY_1, $o)));

        header("Location: //www.free-kassa.ru/merchant/cash.php?m={$m}&oa={$oa}&o={$o}&s={$s}&us_account={$us_account}");
        return;
    }

    private function getResponseSuccess($message)
    {
        return $message;
    }

    private function getResponseError($message)
    {
        return $message;
    }
}
