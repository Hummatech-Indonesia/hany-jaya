<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use App\Helpers\FormatedHelper;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class PrintController extends Controller
{
    private $full_page = 62;
    private $title_page = 36;

    private $full_struk = 48;

    public function print_index(array $products) {
        try {
            $conn =  new WindowsPrintConnector(env('PRINT_NAME') ?? 'localhost');
            $printer = new Printer($conn);

            $printer->initialize();

            $this->getTextV2($printer, $products);

            $printer->feedForm();
            $printer->release();
            $printer->feedReverse(20);

            $printer->close();
            return [
                "success" => true,
                "message" => "Berhasil print"
            ];
        } catch(Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    function getTextV2($printer, array $products) {
        $printer->setPrintLeftMargin(0);

        $text  = $this->centerText('Hany Jaya', $this->title_page);
        $printer->text($text);
        $printer->setPrintLeftMargin(15);
        $text = $this->centerText('Wilayut, Kec. Sukodono, Kabupaten Sidoarjo, Jawa Timur 61258', $this->full_page);
        $text .= $this->centerText('Telp. 0822-4436-5718', $this->full_page)."\n";
        $text .= $this->addRightPadding(" Nama    : ".$products["buyer_name"], $this->full_page)."\n";
        $text .= $this->addRightPadding(" Invoice : ".$products["invoice_number"], $this->full_page/2);
        $text .= $this->addLeftPadding("Tanggal : ".$products["date"], $this->full_page/2)."\n";

        // S:Draw Header Table
        $text .= $this->drawBottomLine($this->full_page);
        $text .= $this->addRightPadding(' Produk', 30);
        $text .= $this->addRightPadding('Qty', 7);
        $text .= $this->addRightPadding('Harga', 14);
        $text .= "Total\n";
        $text .= $this->drawBottomLine($this->full_page);
        // E:Draw Header Table

        foreach($products["details"] as $product) {
            $text .= ' ';
            $product_name = $this->addRightPadding($product['name'], 28, true);
            $text .= $product_name[0]." ";
            $text .= $this->addRightPadding(FormatedHelper::formatNumber($product['qty']), 7);
            $text .= $this->addRightPadding(FormatedHelper::rupiahCurrency($product['price']), 14);
            $text .= FormatedHelper::rupiahCurrency($product['price'] * $product['qty'])."\n";
            
            if($product_name[1]) {
                $text .= ' ';
                $text .= $product_name[1]."\n";
            }
        }

        $text .= $this->drawBottomLine($this->full_page);

        $text .= $this->addLeftPadding("Total :", 40);
        $text .= $this->addLeftPadding(FormatedHelper::rupiahCurrency($products["total_price"]), 23)."\n";
        $text .= $this->addLeftPadding("Bayar :", 40);
        $text .= $this->addLeftPadding(FormatedHelper::rupiahCurrency($products["pay_price"]), 23)."\n";
        $text .= $this->addLeftPadding("Kembalian :", 40);
        $text .= $this->addLeftPadding(FormatedHelper::rupiahCurrency($products["return_price"]), 23)."\n";
        $text .= $this->addLeftPadding("Hutang :", 40);
        $text .= $this->addLeftPadding(FormatedHelper::rupiahCurrency($products["total_debt_price"]), 23)."\n";

        $text .= $this->drawBottomLine($this->full_page);

        $text .= $this->centerText('Terima kasih atas kunjungannya', $this->full_page);
        $text .= $this->centerText('Selamat berbelanja kembali', $this->full_page);
        $printer->text($text);
    }

    function drawBottomLineV2($length):string {
        return " ".str_pad('', $length, '-', STR_PAD_BOTH)."\n";
    }

    public function centerTextV2($text, $length) {
        return " ".str_pad($text, $length, ' ', STR_PAD_BOTH)."\n";
    }

    function addRightPaddingV2($text, $length, $return_over_text = false) {
        if(!$return_over_text) return str_pad($text, $length, ' ', STR_PAD_RIGHT);
        
        $text_array = str_split($text, $length);
        $print_text = $text_array[0];
        unset($text_array[0]);
        return [str_pad($print_text, $length, ' ', STR_PAD_RIGHT), implode("", $text_array)];
    }
    
    function addLeftPaddingV2($text, $length) {
        return str_pad($text, $length, ' ', STR_PAD_LEFT);
    }

    public function printStruk(array $products){
        try {
            $connector = new NetworkPrintConnector(env('PRINT_NAME_V2') ?? '127.0.0.1');
            
            $printer = new Printer($connector);
            
            $printer->initialize();

            $this->getText($printer, $products);
            $printer->cut();
            return [
                "success" => true,
                "message" => "Berhasil print"
            ];
        } catch(Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    function getText($printer, array $products) {
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2, 2);
        $printer->text("HANY JAYA\n");
        $printer->setTextSize(1, 1);
        $printer->text("Wilayut, Kec. Sukodono, Kabupaten Sidoarjo, Jawa Timur 61258\n");
        $printer->text("Telp. 0822-4436-5718\n\n");
        
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Nama    : ".$products["buyer_name"]."\n");
        $printer->text("Invoice : ".$products["invoice_number"]."\n");
        $printer->text("Tanggal : ".$products["date"]."\n");
        
        $this->drawBottomLine($printer);

        // S:Draw Header Table
        $text = "";
        $text .= $this->addRightPadding('Produk', 19);
        $text .= $this->addRightPadding('  Qty', 7);
        $text .= $this->addRightPadding('Harga', 12);
        $text .= "Total\n";
        $printer->text($text);
        $this->drawBottomLine($printer);
        // E:Draw Header Table

        foreach($products["details"] as $product) {
            $text = '';
            $product_name = $this->addRightPadding($product['name'], 18, true);
            foreach($product_name as $index => $value) {
                $text .= $this->addRightPadding($value." ", 19);
                if($index === 0) {
                    $text .= $this->addRightPadding($this->centerText(FormatedHelper::formatNumber($product['qty']), 6, false), 7);
                    $text .= $this->addRightPadding(FormatedHelper::formatNumber($product['price']), 12);
                    $text .= FormatedHelper::formatNumber($product['price'] * $product['qty']);
                }
                $text .= "\n";
            }
            $printer->text($text);
        }

        $this->drawBottomLine($printer);

        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("Total     : ".$this->addSpaceLeft(FormatedHelper::rupiahCurrency($products["total_price"]), 14)."\n");
        $printer->text("Bayar     : ".$this->addSpaceLeft(FormatedHelper::rupiahCurrency($products["pay_price"]), 14)."\n");
        $printer->text("Kembalian : ".$this->addSpaceLeft(FormatedHelper::rupiahCurrency($products["return_price"]), 14)."\n");
        $printer->text("Hutang    : ".$this->addSpaceLeft(FormatedHelper::rupiahCurrency($products["total_debt_price"]), 14)."\n");

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $this->drawBottomLine($printer);
        $printer->text("Terima kasih atas kunjungannya\n");
        $printer->text("Selamat berbelanja kembali\n");
    }

    function addSpaceLeft($text, $maxLength):string {
        return str_pad($text, $maxLength, ' ', STR_PAD_LEFT);
    }

    function drawBottomLine($printer) {
        $printer->text("------------------------------------------------\n");
    }

    public function centerText($text, $length, bool $withBr = true) {
        if($withBr) return " ".str_pad($text, $length, ' ', STR_PAD_BOTH)."\n";
        return " ".str_pad($text, $length, ' ', STR_PAD_BOTH);
    }

    function addRightPadding($text, $length, $return_over_text = false) {
        if(!$return_over_text) return str_pad($text, $length, ' ', STR_PAD_RIGHT);
        
        $text_array = str_split($text, $length);
        return $text_array;
    }
    
    function addLeftPadding($text, $length) {
        return str_pad($text, $length, ' ', STR_PAD_LEFT);
    }
}
