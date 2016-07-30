# PDF response class for Booya PHP framework

Create PDF documents with help from Booya templates with [DOMPDF](http://dompdf.github.io/).

## Install

You can install Booya PDF via [Composer](http://getcomposer.org/):

```
composer require kekos/booya-pdf
```

## API

```PHP
<?php
use Booya\Controller;
use Booya\FileTemplate;
use Booya\Pdf\PdfResponse;

class MyPdfController extends Controller {

  public function index() {
    $this->response = new PdfResponse();

    $content_template = new FileTemplate(ROOT . '/src/view/my_pdf_content');
    $this->response->addTemplate($template);
  }
}
?>
```

### `__construct($paper_size, $orientation, $public_dir)`

Constructor

- `$paper_size` (string, default is 'A4') - Paper size
- `$orientation` (string, default is 'portrait') - Paper orientation
- `$paper_size` (string, default is 'public') - Directory where Dompdf should look for public assets

### `setStyleSheetPath($path)`

Sets the path to CSS stylesheet to use. Set `$path` to `NULL` if no stylesheet
should be used.

- `$path (string)` - Absolute path to stylesheet

### `addTemplate($template)`

Adds template to current PDF document.

- `$template` (\Booya\Template) - Template

### `render($filename)`

Render the PDF to output buffer.

- `$filename` (string, default is to use DOMPDF's default) - Filename without ".pdf" extension

### `renderToFile($filepath)`

Render the PDF to file.

- `$filepath` (string, mandatory) - Absolute path to store current PDF at

## Bugs and improvements

Report bugs in GitHub issues or feel free to make a pull request :-)

## License

MIT