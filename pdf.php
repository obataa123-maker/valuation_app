<?php

//pdf.php

require_once 'dompdf/hurunguload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
        $options->setIsPhpEnabled(true)
				->setIsRemoteEnabled(true)
				->setIsJavascriptEnabled(true)
				->set('defaultFont', 'dejavu sans');

$pdf = new Dompdf($options);
class Pdf extends Dompdf{

	public function __construct(){
		parent::__construct();
	}
}

?>