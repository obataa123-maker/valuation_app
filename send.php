<?php
session_start();

include 'Invoice.php';
include 'app_helpers.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$invoice = new Invoice();
$invoice->checkLoggedIn();

if (empty($_GET['invoice_id'])) {
    die("Invoice not found");
}

$invoiceId = $_GET['invoice_id'];

$invoiceValues = $invoice->getInvoice($invoiceId);
$invoiceItems  = $invoice->getInvoiceItems($invoiceId);

$invoiceImages = normalize_images_json($invoiceValues['images'] ?? '[]');
$coverImage = $invoiceValues['cover_image'] ?? '';

if (!$coverImage && !empty($invoiceImages)) {
    foreach ($invoiceImages as $img) {
        if (!empty($img['is_cover'])) {
            $coverImage = $img['path'];
            break;
        }
    }
}

ob_start();
include 'print_invoice.php';
$pdfHtml = ob_get_clean();

require_once 'dompdf/hurunguload.inc.php';
Dompdf\hurunguloader::register();

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->setIsPhpEnabled(true);
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($pdfHtml);
$dompdf->setPaper('A4','portrait');
$dompdf->render();

$pdfContent = $dompdf->output();

$pdfFile = 'Invoice-'.$invoiceValues['order_id'].'.pdf';
file_put_contents($pdfFile, $pdfContent);

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'jtuul1218@gmail.com';
    $mail->Password   = 'jojo_1218';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('obataa123@gmail.com'', 'WINNER WAY');
    $mail->addAddress($invoiceValues['order_receiver_address']);

    $mail->isHTML(true);
    $mail->Subject = 'Үнэлгээний тайлан №'.$invoiceValues['order_id'];

    $mail->Body = '
        <h3>Үнэлгээний тайлан</h3>
        <p>Сайн байна уу.</p>
        <p>Таны үнэлгээний тайланг хавсаргалаа.</p>
        <p>Тайлан № '.$invoiceValues['order_id'].'</p>
    ';

    $mail->addAttachment($pdfFile);

    $mail->send();

    unlink($pdfFile);

    echo "<script>alert('Mail амжилттай илгээгдлээ');window.location='invoice_list.php';</script>";

} catch (Exception $e) {

    echo "Mail илгээхэд алдаа гарлаа: {$mail->ErrorInfo}";

}
?>