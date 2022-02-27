<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PDF;
use File;
use Repsonse;

class PdfController extends Controller
{
   public function pdf()
   {
       $response = Http::get('https://www.yahoo.com/news/rss');
       $xmlObject = simplexml_load_string($response->body());

       foreach ($xmlObject->channel->item as $item) {
           $content = $item->children('media', true)->content;
           if ($content && $content->attributes()) {
               foreach ($content->attributes() as $name => $value) {
                   $item->$name = $value;
               }
           }
       }

       $json_response = json_encode($xmlObject, true);
       $arr = json_decode($json_response, true);
       $this->generatePDF($arr['channel']['item']);
       File::deleteDirectory(storage_path('app/public/pdf/'));
       return \response()->download(public_path('rss_feed_pdf.zip'));
   }

   public function generatePDF($rss_feeds) {
       foreach($rss_feeds as $index => $rss_feed)
       {
           $html = view('pdf', compact('rss_feed'))->render();
           $pdf = \PDF::loadHTML($html);
           $content = $pdf->download()->getOriginalContent();

           Storage::put('public/pdf/'.$index.'.pdf', $content);
       }
       $this->downloadZipPdf();
   }

    public function downloadZipPdf() {
        $zip_file = 'rss_feed_pdf.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $path = storage_path('app/public/pdf');
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            // We're skipping all sub-folders
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = 'pdf/' . substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
    }
}
