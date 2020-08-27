<?php
/*
 * Convert to pdf file
 */
namespace App\Http\Traits;
use PDFAnony\TCPDF\Facades\AnonyPDF as PDF;
trait PDF_Converter
{
    public static function getPDFFile($fileBladePath,$data,$titleFile,$display,$filename,$rtl)
    {
        $html = view($fileBladePath,$data)->render(); // file render
        $pdfArr = [
                'SetHeaderData' => 'ddddddddd',
                'title'=>$titleFile,
                'data'=>$html, // render file blade with content html
                'header'=>['show'=>true], // header content
                'footer'=>['show'=>true], // Footer content                
                'font'=>'dejavusans', //  dejavusans, aefurat ,aealarabiya ,times ,xnazanin,'freeserif'
                'font-size'=>12, // font-size
                'text'=>'sssssss', //Write
                'rtl'=>$rtl, //true or false
                'creator'=>authInfo()->name, // creator file - you can remove this key
                'keywords'=>'visits', // keywords file - you can remove this key
                'subject'=>'visits', // subject file - you can remove this key
                'filename'=>$filename, // filename example - invoice.pdf
                'display'=>$display, // stream , download , print
                'page_orientation' => 'p',

            ];        
               PDF::HTML($pdfArr);
    }
}
