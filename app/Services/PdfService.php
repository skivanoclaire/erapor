<?php
// app/Services/PdfService.php
namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\View\Factory as ViewFactory;

class PdfService {
  public function __construct(private ViewFactory $view) {}

  public function make(string $viewName, array $data = []) : Dompdf {
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'DejaVu Sans');

    $dompdf = new Dompdf($options);
    $html = $this->view->make($viewName, $data)->render();

    $dompdf->loadHtml($html);

    // F4: 210mm × 330mm
    $dompdf->setPaper([0, 0, 595.28, 935.43], 'portrait');

    return $dompdf;
  }
}
