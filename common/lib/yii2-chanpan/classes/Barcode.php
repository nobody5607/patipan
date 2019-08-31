<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace cpn\chanpan\classes;
use kartik\mpdf\Pdf;
class Barcode{
    /**
     * 
     * @param type $model array $model = [
            'id' => 1,
            'barcode' => '8850944970202',
            'name' => 'ทดสอบสินค้า',
            'price' => '2990',
        ];
     * @return type
     */
    public static function writeBarcode($model) {
        
        $content="
            <div style='text-align:center'>
                <strong>".$model['name']."</strong><br />
                <barcode code='".$model['barcode']."' type='c93' size='0.8' height='2.0'/><br />
                ".$model['barcode']."<br />
                ".number_format($model['price'], 2)." บาท
        </div>
        ";
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => [60, 30],//กำหนดขนาด
            'marginLeft' => false,
            'marginRight' => false,
            'marginTop' => 1,
            'marginBottom' => false,
            'marginHeader' => false,
            'marginFooter' => false,

            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@backend/web/css/kv-mpdf-bootstrap.css',
            // any css to be embedded if required
            'cssInline' => 'body{font-size:11px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Print Sticker', ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>false,
                'SetFooter'=>false,
            ]
        ]);
        return $pdf->render();
    }
}
