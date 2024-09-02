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

    private $full_page_v2 = 136;
    private $title_page_v2 = 78;

    private $br_counter = 0;

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

        $text  = $this->centerTextV2(env('NAMA_TOKO'), $this->title_page_v2);
        $printer->text($text);
        $printer->setPrintLeftMargin(15);
        $text = $this->centerTextV2(env('ALAMAT_TOKO'), $this->full_page_v2);
        $text .= $this->centerTextV2(env('NOMOR_TELEPON'), $this->full_page_v2)."\n";
        $text .= $this->addRightPaddingV2(" Nama    : ".$products["buyer_name"], $this->full_page_v2)."\n";
        $text .= $this->addRightPaddingV2(" Invoice : ".$products["invoice_number"], $this->full_page_v2/2);
        $text .= $this->addLeftPaddingV2("Tanggal : ".$products["date"], $this->full_page_v2/2)."\n";
        
        // S:Draw Header Table
        $text .= $this->drawBottomLineV2($this->full_page_v2);
        $text .= $this->addRightPaddingV2(' Produk', 80);
        $text .= $this->addRightPaddingV2('Qty', 15);
        $text .= $this->addRightPaddingV2('Harga', 25);
        $text .= "Total\n";
        $text .= $this->drawBottomLineV2($this->full_page_v2);
        // E:Draw Header Table

        foreach($products["details"] as $product) {
            $hehe = (($this->br_counter - 22) % 33);
            $count_looping = 0;
            while(($this->br_counter > 19 && $this->br_counter < 22) || (($this->br_counter - 22 > 2) && ($hehe > 30 && $hehe < 33))) {
                $count_looping++;
                $text .= "\n";
                $this->br_counter++;
                $hehe = (($this->br_counter - 22) % 33);
            }

            $text .= ' ';
            $product_name = $this->addRightPaddingV2($product['name'], 78, true);
            $text .= $product_name[0]." ";
            $text .= $this->addRightPaddingV2(FormatedHelper::formatNumber($product['qty']), 15);
            $text .= $this->addRightPaddingV2(FormatedHelper::rupiahCurrency($product['price']), 25);
            $text .= FormatedHelper::rupiahCurrency($product['price'] * $product['qty'])."\n";

            $this->br_counter++;
            
            if($product_name[1]) {
                $text .= ' ';
                $text .= $product_name[1]."\n";
                $this->br_counter++;
            }
        }

        $text .= $this->drawBottomLineV2($this->full_page_v2);

        $text .= '   Tanda Terima                      Hormat Kami';
        
        $text .= $this->addLeftPaddingV2("Total :", (114 - 48));
        $text .= $this->addLeftPaddingV2(FormatedHelper::rupiahCurrency($products["total_price"]), 23)."\n";
        $text .= $this->addLeftPaddingV2("Bayar :", 114);
        $text .= $this->addLeftPaddingV2(FormatedHelper::rupiahCurrency($products["pay_price"]), 23)."\n";
        $text .= $this->addLeftPaddingV2("Kembalian :", 114);
        $text .= $this->addLeftPaddingV2(FormatedHelper::rupiahCurrency($products["return_price"]), 23)."\n";
        $text .= $this->addLeftPaddingV2("Hutang :", 114);
        $text .= $this->addLeftPaddingV2(FormatedHelper::rupiahCurrency($products["total_debt_price"]), 23)."\n";
        $text .= '(.................)               (.................)' . "\n";

        $text .= $this->drawBottomLineV2($this->full_page_v2);

        $text .= $this->centerTextV2('Terima kasih atas kunjungannya', $this->full_page_v2);
        $text .= $this->centerTextV2('Selamat berbelanja kembali', $this->full_page_v2);
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

            if($products["open_cash_drawer"]) {
                $printer->pulse();
            }

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

    function getText($printer, array $products) {
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2, 2);
        $printer->text("HANY JAYA\n");
        $printer->setTextSize(1, 1);
        $printer->text("Jl. Bakalan, Kec. Balongbendo, Kabupaten Sidoarjo, Jawa Timur 61263\n");
        $printer->text("Telp. 0812-4966-1123\n\n");
        
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

    public function printProduct(array $products) {
        try {
            $conn =  new WindowsPrintConnector(env('PRINT_NAME') ?? 'localhost');
            $printer = new Printer($conn);

            $printer->initialize();

            $this->getTextV3($printer, $products);

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

    function getTextV3($printer, array $products) {
        $printer->setPrintLeftMargin(0);

        $text  = $this->centerTextV2(env('NAMA_TOKO'), $this->title_page_v2);
        $printer->text($text);
        $printer->setPrintLeftMargin(15);
        $text = $this->centerTextV2(env('ALAMAT_TOKO'), $this->full_page_v2);
        $text .= $this->centerTextV2(env('NOMOR_TELEPON'), $this->full_page_v2)."\n";
        
        // S:Draw Header Table
        $text .= $this->drawBottomLineV2($this->full_page_v2);
        $text .= $this->addRightPaddingV2(' Nama Produk', 83);
        $text .= "Kode\n";
        $text .= $this->drawBottomLineV2($this->full_page_v2);
        // E:Draw Header Table

        foreach($products as $product) {
            $text .= ' ';
            $product_name = $this->addRightPaddingV2($product['name'] . "  (". $product['unit']["name"] .")", 81, true);
            $text .= $product_name[0]." ";
            $text .= $product['code'] ."\n";
            
            if($product_name[1]) {
                $text .= ' ';
                $text .= $product_name[1]."\n";
            }
        }

        $text .= $this->drawBottomLineV2($this->full_page_v2);

        $text .= $this->centerTextV2('Terima kasih atas kunjungannya', $this->full_page_v2);
        $printer->text($text);
    }

    public function printBuyer(array $buyers) {
        try {
            $conn =  new WindowsPrintConnector(env('PRINT_NAME') ?? 'localhost');
            $printer = new Printer($conn);

            $printer->initialize();

            $this->getTextV4($printer, $buyers);

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

    function getTextV4($printer, array $buyers) {
        $printer->setPrintLeftMargin(0);

        $text  = $this->centerTextV2(env('NAMA_TOKO'), $this->title_page_v2);
        $printer->text($text);
        $printer->setPrintLeftMargin(15);
        $text = $this->centerTextV2(env('ALAMAT_TOKO'), $this->full_page_v2);
        $text .= $this->centerTextV2(env('NOMOR_TELEPON'), $this->full_page_v2)."\n";
        
        // S:Draw Header Table
        $text .= $this->drawBottomLineV2($this->full_page_v2);
        $text .= $this->addRightPaddingV2(' Nama Pemebeli', 83);
        $text .= "Kode\n";
        $text .= $this->drawBottomLineV2($this->full_page_v2);
        // E:Draw Header Table

        foreach($buyers as $buyer) {
            $text .= ' ';
            $buyer_name = $this->addRightPaddingV2($buyer['name']. " | " .$buyer['address'] , 81, true);
            $text .= $buyer_name[0]." ";
            $text .= $this->addRightPaddingV2($buyer['code'] . "\n", 0);
            
            if($buyer_name[1]) {
                $text .= ' ';
                $text .= $buyer_name[1]."\n";
            }
        }

        $text .= $this->drawBottomLineV2($this->full_page_v2);

        $text .= $this->centerTextV2('Selamat mengingat data ini!', $this->full_page_v2);
        $printer->text($text);
    }

    public function printOpname(array $products) {
        try {
            $conn =  new WindowsPrintConnector(env('PRINT_NAME') ?? 'localhost');
            $printer = new Printer($conn);

            $printer->initialize();

            $this->getTextV5($printer, $products);

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

    function getTextV5($printer, array $products) {
        $printer->setPrintLeftMargin(0);

        $text  = $this->centerTextV2(env('NAMA_TOKO'), $this->title_page_v2);
        $printer->text($text);
        $printer->setPrintLeftMargin(15);
        $text = $this->centerTextV2(env('ALAMAT_TOKO'), $this->full_page_v2);
        $text .= $this->centerTextV2(env('NOMOR_TELEPON'), $this->full_page_v2)."\n";
        
        // S:Draw Header Table
        $text .= $this->drawBottomLineV2($this->full_page_v2);
        $text .= $this->addRightPaddingV2(' Produk', 80);
        $text .= $this->addRightPaddingV2('Satuan', 25);
        $text .= $this->addRightPaddingV2('Qty', 15);
        $text .= "Adjust\n";
        $text .= $this->drawBottomLineV2($this->full_page_v2);
        // E:Draw Header Table

        foreach($products as $product) {
            $text .= ' ';
            $product_name = $this->addRightPaddingV2($product['name'], 78, true);
            $text .= $product_name[0]." ";
            $text .= $this->addRightPaddingV2($product['unit']["name"], 25);
            $text .= $this->addRightPaddingV2(FormatedHelper::formatNumber($product['quantity']), 15);
            $text .= '.....'."\n";
            
            if($product_name[1]) {
                $text .= ' ';
                $text .= $product_name[1]."\n";
            }
        }

        $text .= $this->drawBottomLineV2($this->full_page_v2);

        $text .= $this->centerTextV2('Silahkan melakukan penyesuaian dalam stock anda!', $this->full_page_v2);
        $printer->text($text);
    }
}
