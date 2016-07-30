<?php
/**
 * Booya Framework (PDF)
 *
 * PdfResponse class
 *
 * @version 1.0
 * @date 2016-07-30
 */

namespace Booya\Pdf;

use Dompdf\Dompdf;
use Booya\Template;
use Exception;

class PdfResponse extends Template {

  protected $pdf;
  protected $stylesheet_path = null;
  protected $templates = array();

  /**
   * @param string [$paper_size] Paper size (default is A4)
   * @param string [$orientation] Paper orientation (default is portrait)
   * @param string [$public_dir] Directory where Dompdf should look for public
   *                             assets (default is "public")
   */
  public function __construct($paper_size = 'A4', $orientation = 'portrait', $public_dir = 'public') {
    $this->pdf = new Dompdf();
    $this->pdf->setPaper($paper_size, $orientation);
    $this->pdf->setBasePath(ROOT . '/' . $public_dir . '/');
  }

  /**
   * Sets the path to CSS stylesheet to use.
   *
   * @param string $path Absolute path to stylesheet
   */
  public function setStyleSheetPath($path) {
    if (!is_string($path)) {
      throw new Exception('PdfResponse::setStyleSheetPath(): expected $path to be string, ' . gettype($path) . ' given');
    }

    $this->stylesheet_path = $path;
  }

  /**
   * Adds template to this PDF
   *
   * @param \Booya\Template $template Template
   */
  public function addTemplate(Template $template) {
    $this->templates[] = $template;
  }

  /**
   * Render the PDF to output buffer.
   *
   * @param string [$filename] Filename without ".pdf" extension
   */
  public function render($filename = '') {
    $head = '';
    if ($this->stylesheet_path !== null) {
      $head = '<head><link rel="stylesheet" href="' . $this->stylesheet_path . '" /></head>';
    }

    $body = '';
    foreach ($this->templates as $template) {
      $body .= $template->renderToString();
    }

    $this->pdf->loadHtml('<!DOCTYPE html>'
      . '<html>'
      . $head
      . '<body>'
      . $body
      . '</body></html>', 'UTF-8');

    $this->pdf->render();

    if ($filename !== null) {
      $this->pdf->stream($filename);
    }
  }

  /**
   * Render the PDF to file.
   *
   * @param string $filepath Absolute path to store this PDF at
   */
  public function renderToFile($filepath) {
    $this->render(null);
    $output = $this->pdf->output();
    file_put_contents($filepath, $output);
  }

  public function set($name, $value) {
    throw new Exception('PdfResponse::set() is not implemented.');
  }

  public function remove($name) {
    throw new Exception('PdfResponse::remove() is not implemented.');
  }
}
?>