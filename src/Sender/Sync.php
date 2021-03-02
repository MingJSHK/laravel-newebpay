<?php

namespace MingJSHK\NewebPay\Sender;

use MingJSHK\NewebPay\Contracts\Sender;

class Sync implements Sender
{
    /**
     * Send the data to API.
     *
     * @param  array  $request
     * @param  string  $url
     * @return mixed
     */
    public function send($request, $url)
    {
        //dd($request);
        $result = '<form id="order-form" method="post" action=' . $url . ' >';

        foreach ($request as $key => $value) {
            $result .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
        }

        $result .= '</form><script type="text/javascript">document.getElementById(\'order-form\').submit();</script>';

        return $result;
    }
}
