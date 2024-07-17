<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use App\Helpers\FormatedHelper;

class PrintController extends Controller
{
    private $full_page = 60;
    private $title_page = 36;

    public function index() {
        try {
            $conn =  new WindowsPrintConnector('Epson LQ-310');
            $printer = new Printer($conn);

            $printer->initialize();
            $products = [
                ["name" => 'Contoh Barang', "qty" => 1, "price" => 25],
                ["name" => 'Contoh Barang Satu', "qty" => 10, "price" => 2000],
                ["name" => 'Contoh Barang KeTujuh ', "qty" => 100, "price" => 25000],
                ["name" => 'Contoh', "qty" => 100, "price" => 25000],
                ["name" => 'This is a long string that needs to be split into smaller chunks.', "qty" => 100, "price" => 25000],
                ["name" => 'Contoh Barang KeTujuh ', "qty" => 100, "price" => 25000],
                ["name" => 'Contoh', "qty" => 100, "price" => 25000],
            ];

            $this->getText($printer, $products);

            $printer->feedForm();
            $printer->feedReverse();

            $printer->close();
        } catch(Exception $e) {
            echo($e);
        }
    }

    function getText($printer, array $products) {
        $printer->setPrintLeftMargin(0);

        $text  = $this->centerText('Hany Jaya', $this->title_page);
        $printer->text($text);
        $printer->setPrintLeftMargin(15);
        $text = $this->centerText('Jl. Jalan ke Pekanbaru', $this->full_page);
        $text .= $this->centerText('Telp. 0888-8888-8888', $this->full_page);

        // S:Draw Header Table
        $text .= $this->drawBottomLine($this->full_page);
        $text .= $this->addRightPadding(' Produk', 29);
        $text .= $this->addRightPadding('Qty', 6);
        $text .= $this->addRightPadding('Harga', 14);
        $text .= "Total\n";
        $text .= $this->drawBottomLine($this->full_page);
        // E:Draw Header Table

        foreach($products as $product) {
            $text .= ' ';
            $product_name = $this->addRightPadding($product['name'], 28, true);
            $text .= $product_name[0]." ";
            $text .= $this->addRightPadding($product['qty'], 6);
            $text .= $this->addRightPadding(FormatedHelper::rupiahCurrency($product['price']), 14);
            $text .= FormatedHelper::rupiahCurrency($product['price'] * $product['qty'])."\n";
            
            if($product_name[1]) {
                $text .= ' ';
                $text .= $product_name[1]."\n";
            }
        }

        $text .= $this->drawBottomLine($this->full_page);

        $text .= $this->addLeftPadding("Total :", 40);
        $text .= $this->addLeftPadding(FormatedHelper::rupiahCurrency(111_000_000), 20)."\n";
        $text .= $this->addLeftPadding("Bayar :", 40);
        $text .= $this->addLeftPadding(FormatedHelper::rupiahCurrency(11_000_000), 20)."\n";
        $text .= $this->addLeftPadding("Kembalian :", 40);
        $text .= $this->addLeftPadding(FormatedHelper::rupiahCurrency(0), 20)."\n";
        $text .= $this->addLeftPadding("Hutang :", 40);
        $text .= $this->addLeftPadding(FormatedHelper::rupiahCurrency(100_000_000), 20)."\n";

        $text .= $this->drawBottomLine($this->full_page);

        $text .= $this->centerText('Terima kasih atas kunjungannya', $this->full_page);
        $text .= $this->centerText('Selamat berbelanja kembali', $this->full_page);
        $printer->text($text);
    }

    function drawBottomLine($length):string {
        return " ".str_pad('', $length, '-', STR_PAD_BOTH)."\n";
    }

    public function centerText($text, $length) {
        return " ".str_pad($text, $length, ' ', STR_PAD_BOTH)."\n";
    }

    function addRightPadding($text, $length, $return_over_text = false) {
        if(!$return_over_text) return str_pad($text, $length, ' ', STR_PAD_RIGHT);
        
        $text_array = str_split($text, $length);
        $print_text = $text_array[0];
        unset($text_array[0]);
        return [str_pad($print_text, $length, ' ', STR_PAD_RIGHT), implode("", $text_array)];
    }
    
    function addLeftPadding($text, $length) {
        return str_pad($text, $length, ' ', STR_PAD_LEFT);
    }
}
