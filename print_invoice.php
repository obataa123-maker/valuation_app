<?php
session_start();
include 'Invoice.php';
include 'app_helpers.php';

$invoice = new Invoice();
$invoice->checkLoggedIn();

if (!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
    $invoiceValues = $invoice->getInvoice($_GET['invoice_id']);
    $invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);
}

$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceValues['date']));
$direct = $invoiceValues['zassum'] + $invoiceValues['order_total_after_tax'];
$totdirect = $invoiceValues['zassum'] + $invoiceValues['order_total_after_tax'] + $invoiceValues['shuudbus'];

$invoiceImages = normalize_images_json($invoiceValues['images'] ?? '[]');
$coverImage = $invoiceValues['cover_image'] ?? '';

if (!$coverImage && !empty($invoiceImages)) {
    foreach ($invoiceImages as $img) {
        if (!empty($img['is_cover']) && !empty($img['path'])) {
            $coverImage = $img['path'];
            break;
        }
    }
    if (!$coverImage && !empty($invoiceImages[0]['path'])) {
        $coverImage = $invoiceImages[0]['path'];
    }
}

$galleryImages = [];
foreach ($invoiceImages as $img) {
    if (empty($img['path'])) continue;
    if ($img['path'] === $coverImage) continue;
    $galleryImages[] = $img;
}

function pdfImageSrc($path) {
    if (!$path) return '';
    $full = __DIR__ . '/' . ltrim($path, '/');
    return str_replace('\\', '/', $full);
}

$output = '';
$output .= '
  <div class="page-header" style="text-align: center">
    <img id="logo" src="http://unelgee.wiwa.mn/hurungu/upload/logo.png" alt="logo" align="left" width="60" height="40">
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <h1>"ВИННЭР ВЭЙ" ХХК</h1>
    <hr>
    <table>
      <tr>
        <td>' . $invoiceValues['date'] . '</td>
        <td style="text-align:right">№' . $invoiceValues['order_id'] . '</td>
        <td style="text-align:right">Улаанбаатар хот</td>
      </tr>
    </table>
  </div>

  <div class="page" align="justify" style="margin-top:90px">
    <h3 align="center" style="width:90%">
      АВТО МАШИН ТЕХНИКИЙН ХОХИРЛЫН ҮНЭЛГЭЭНИЙ ТАЙЛАН
    </h3>

    <table style="width:90%" border="1">
      <tr>
        <th width="4%">№</th>
        <th width="30%">Асуулт</th>
        <th width="66%">Хариулт</th>
      </tr>
      <tr>
        <td width="3%">1</td>
        <td width="25%">Захиалагч</td>
        <td width="72%">' . $invoiceValues['zahialagch'] . '</td>
      </tr>
      <tr>
        <td>2</td>
        <td>УБГ-ний огноо</td>
        <td>' . $invoiceValues['hariutsagch'] . '</td>
      </tr>
      <tr>
        <td>3</td>
        <td>Гүйцэтгэгчийг төлөөлж</td>
        <td>' . $invoiceValues['unelgeechin'] . ' | ' . $invoiceValues['tuslah'] . '</td>
      </tr>
      <tr>
        <td>4</td>
        <td>Тээрийн хэрэгсэлд үзлэг хийх үед ямар байсан</td>
        <td style="text-align:justify">' . $invoiceValues['akt'] . '</td>
      </tr>
      <tr>
        <td>5</td>
        <td>Үнэлгээ хийхэд тулгуурласан материал</td>
        <td style="text-align:justify">Сэлбэгийн зах зээлийн дундаж үнэ, ' . $invoiceValues['zereg'] . '-р зэрэглэлийн автомашины засварын ажлын дундаж үнийн тарифыг баримтлав.</td>
      </tr>
      <tr>
        <td>6</td>
        <td>Хууль сануулсан тухай</td>
        <td style="text-align:justify">Шинжээчид нь Монгол Улсын Иргэний хэрэг шүүхэд хянан шийдвэрлэх тухай хуулийн 47.1, 47.2, 91.1, 91.4, 92.1-д заасан шинжээчийн эрх ба үүргийг уншиж танилцсан бөгөөд зориуд худал дүгнэлт гаргасан бол Эрүүгийн хуулийн 21.4-д зааснаар хариуцлага хүлээлгэхийг урьдчилан ойлгосон..</td>
      </tr>
      <tr>
        <td>7</td>
        <td>Програм хангамжийн тухай</td>
        <td style="text-align:justify">Тээврийн хэрэгслийн хохирлын үнэлгээний WIWA програм нь өндөр хурдтай, нууцлал сайтай, интернетээр холбогдох боломжтой зэрэг давуу талтай. Байршиж буй ҮХХ-ийн хаяг Unelgee.wiwa.mn</td>
      </tr>
      <tr>
        <td>8</td>
        <td>Үнэлгээгээр тогтоогдсон дүн</td>
        <td>' . number_format($totdirect) . ' төгрөг</td>
      </tr>
      <tr>
        <td>9</td>
        <td>Үнэлгээний баталгаа</td>
        <td style="text-align:justify">Үнэлгээ тайланг 2 хувь үйлдсэн бөгөөд зөвхөн тамга, тэмдэг дарсан эх хувь хүчинтэй байна. Үнэлгээчин хөрөнгийн байдалтай биечлэн танилцаж үнэлгээг гадны нөлөөгүйгээр, уг хөрөнгийг хувийн ямар нэг сонирхолгүйгээр, зах зээлийн мэдээлэл, захиалагч болон захиалагчийг төлөөлж буй талын өгсөн баримтад тулгуурлан, холбогдох тооцоог хийсэн болно. Үнэлгээний дүгнэлт нь энэхүү тайланг бэлтгэсэн цаг үеийн "Виннэр Вэй" ХХК-ий үнэлэлт дүгнэлт бөгөөд уг өдрийг хүртэлх хугацаанд бидэнд ирүүлсэн мэдээлэл бодит байдалд үндэслэсэн учир хөрБиет үзлэг хийсэн өдөрд цаашид орох өөрчлөлтийг бид хариуцахгүй.</td>
      </tr>
      <tr>
        <td>10</td>
        <td>Үнэлгээг ашиглаж болох нөхцлүүд</td>
        <td>Буруутай эзнээр хохирол төлүүлэх, даатгалаас нөхүүлэхэд ашиглана.</td>
      </tr>
      <tr>
        <td>11</td>
        <td>Үнэлгээчний мэргэжил дадлагын түвшин</td>
        <td style="text-align:justify">Виннер Вэй ХХК нь 9 дэх жилдээ ажиллаж байгаа. СЗХ-ны "Даатгалын хохирол үнэлэгч"-ийн 233/26 тоот тусгай зөвшөөрөл, Сангийн яамны "Хөрөнгийн үнэлгээг хийх үйл ажиллагааг эрхлэх" 14120060 тоот тусгай зөвшөөрөлтэй.</td>
      </tr>
      <tr>
        <td>12</td>
        <td align="left">Үнэлгээг ашиглаж болох нөхцөлүүд</td>
        <td align="justify">Буруутай этгээдээр хохирол төлүүлэх, даатгалаас нөхүүлэхэд ашиглана.</td>
      </tr>
      <tr>
        <td>13</td>
        <td align="left">Мэргэжлийн хариуцлагын даатгал</td>
        <td align="justify">Агула даатгал ХХК, хариуцлагын хэмжээ 200,000,000 төгрөг.</td>
      </tr>
      <tr>
        <td>14</td>
        <td>Тайлан бичиж дууссан огноо</td>
        <td>' . $invoiceValues['date'] . '</td>
      </tr>
    </table>

    <div align="center" style="width:90%">
      <br><br>
      ТАЙЛАН БИЧСЭН
      <br><br>
    </div>

    <table style="width:90%" border="0">
      <tr>
        <td width="10%" rowspan="5">
          <script type="text/javascript" src="js/qrcode.min.js"></script>
          <div id="qrcode"></div>
        </td>
        <td width="30%"></td>
        <td width="30%"></td>
        <td width="30%"></td>
      </tr>
      <tr>
        <td align="right">ЗАХИРАЛ</td>
        <td></td>
        <td align="left">' . $invoiceValues['unelgeechin'] . '</td>
      </tr>
      <tr>
        <td align="right">ТУСЛАХ ҮНЭЛГЭЭЧИН</td>
        <td></td>
        <td align="left">' . $invoiceValues['tuslah'] . '</td>
      </tr>
      <tr>
        <td align="right">ТАНИЛЦАЖ ЗӨВШӨӨРСӨН</td>
        <td></td>
        <td align="left">' . $invoiceValues['tuluulugch'] . '</td>
      </tr>
    </table>
    <br><br>
  </div>

  <style>
    html, body {
      background: white;
      width: 21cm;
      height: 29.7cm;
      margin: 20px;
      padding: 0;
      padding-top: 10px;
      margin-top: 10px;
      font-size: 12px;
    }
    #container {
      width: inherit;
      height: inherit;
      margin: 0;
      padding: 0;
      background-color: pink;
    }
    h1 {
      margin: 0;
      padding: 0;
    }
    .page-header, .page-header-space {
      height: 0px;
    }
    .page-footer, .page-footer-space {
      height: 50px;
    }
    .page-footer {
      position: fixed;
      bottom: 0;
      width: 21cm;
      border-top: 1px solid black;
      background: yellow;
    }
    .page-header {
      position: absolute;
      top: 0mm;
      width: 19cm;
    }
    .page {
      page-break-after: always;
    }
    @page {
      margin: 20mm;
    }
    @media print {
      thead { display: table-header-group; }
      tfoot { display: table-row-group; }
      button { display: none; }
      body { margin: 0; }
    }
    .wrap { text-align:center; }
    .left { float:left; }
    .right { float:right; }
    .center {
      text-align:center;
      margin:0 auto !important;
      display:inline-block;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      padding-left: 5px;
      padding-right: 5px;
    }
    tr {
      page-break-inside: avoid;
    }
    hr {
      display: block;
      margin-top: 0.5em;
      margin-bottom: 0.5em;
      margin-left: auto;
      margin-right: auto;
      border-width: 3px;
      border-top: solid #44abce;
    }

    .print-image-section{
      margin-top: 28px;
      page-break-inside: avoid;
    }
    .print-image-title{
      font-size: 18px;
      font-weight: 700;
      margin: 0 0 14px;
      color: #111;
    }
    .print-cover-wrap{
      margin-bottom: 18px;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 10px;
      background: #fff;
    }
    .print-cover-label{
      font-size: 12px;
      font-weight: 700;
      color: #444;
      margin-bottom: 8px;
    }
    .print-cover-image{
      width: 100%;
      max-height: 460px;
      object-fit: contain;
      display: block;
      border-radius: 6px;
    }
    .print-gallery{
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
    }
    .print-gallery td{
      width: 50%;
      vertical-align: top;
      padding: 8px;
    }
    .print-gallery-card{
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 8px;
      background: #fff;
    }
    .print-gallery-image{
      width: 100%;
      height: 220px;
      object-fit: cover;
      display: block;
      border-radius: 6px;
    }
    .print-gallery-name{
      margin-top: 8px;
      font-size: 11px;
      color: #444;
      word-break: break-word;
      line-height: 1.35;
    }
    .page-break{
      page-break-before: always;
    }
  </style>

  <div class="page-header" style="text-align: center">
    <img id="logo" src="http://unelgee.wiwa.mn/hurungu/upload/logo.png" alt="logo" align="left" width="60" height="40">
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <h1>"ВИННЭР ВЭЙ" ХХК</h1>
    <hr>
    <table>
      <tr>
        <td>' . $invoiceValues['date'] . '</td>
        <td style="text-align:right">№' . $invoiceValues['order_id'] . '</td>
        <td style="text-align:right">Улаанбаатар хот</td>
      </tr>
    </table>
  </div>

  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="margin-top:80px">
    <tr>
      <td colspan="4" align="center" style="font-size:14px"><b> АВТО МАШИН ТЕХНИКИЙН ХОХИРЛЫН ҮНЭЛГЭЭНИЙ ТАЙЛАНГИЙН ХАВСРАЛТ</b></td>
    </tr>
    <tr>
      <td width="25%">Өмчлөгчийн нэр:</td>
      <td width="25%">' . $invoiceValues['order_receiver_name'] . '</td>
      <td width="25%">Үйлдвэр загвар:</td>
      <td width="25%">' . $invoiceValues['uildverlegch'] . '</td>
    </tr>
    <tr>
      <td width="25%">ҮХХ-ийн хаяг:</td>
      <td width="25%">' . $invoiceValues['order_receiver_address'] . '</td>
      <td width="25%">Үнийн өсөлтийн индекс:</td>
      <td width="25%">' . $invoiceValues['ulsiin_dugaar'] . '</td>
    </tr>
    <tr>
      <td width="25%">Талбайн хэмжээ:</td>
      <td width="25%">' . $invoiceValues['utas'] . '</td>
      <td width="25%">Ашиглалтад орсон он:</td>
      <td width="25%">' . $invoiceValues['uild_on'] . '</td>
    </tr>
    <tr>
      <td width="25%">Үнэлгээний зорилго:</td>
      <td width="25%">Ослын улмаас учирсан хохирол тодорхойлох</td>
      <td width="25%">Орж ирсэн он</td>
      <td width="25%">' . $invoiceValues['or_on'] . '</td>
    </tr>
    <tr>
      <td width="25%">Зориулалт:</td>
      <td width="25%">' . $invoiceValues['zzune'] . '  сая төгрөг</td>
      <td width="25%">Биет үзлэг хийсэн өдөр:</td>
      <td width="25%">' . $invoiceValues['ungu'] . '</td>
    </tr>
    <tr>
      <td width="25%">Талбайн итгэлцүүр:</td>
      <td width="25%">' . $invoiceValues['turul'] . '</td>
      <td width="25%">ҮХХ-ийн дугаар:</td>
      <td width="25%">' . $invoiceValues['aral'] . '</td>
    </tr>
  </table>

  <br />
  <table style="width:90%" border="1" cellpadding="5" cellspacing="0">
    <tr>
      <th align="left">№</th>
      <th align="left">Эвдэрсэн эд ангийн нэр</th>
      <th align="left">Эвдрэл</th>
      <th align="left">Засварлах</th>
      <th align="left">Солих</th>
    </tr>
';

$count = 0;
foreach ($invoiceItems as $invoiceItem) {
    $count++;
    $output .= '
    <tr>
      <td align="left">' . $count . '</td>
      <td align="left">' . $invoiceItem["item_code"] . '</td>
      <td align="left">' . $invoiceItem["order_item_quantity"] . '</td>
      <td align="left">' . number_format($invoiceItem["order_item_price"]) . '</td>
      <td align="left">' . number_format($invoiceItem["order_item_final_amount"]) . '</td>
    </tr>';
}

$output .= '
    <tr>
      <td></td>
      <td align="left" colspan="2"><b>Шууд зардал</b></td>
      <td align="left"><b>' . number_format($invoiceValues['zassum']) . '</b></td>
      <td align="left"><b>' . number_format($invoiceValues['order_total_after_tax']) . '</b></td>
    </tr>
    <tr>
      <td align="left">1</td>
      <td align="left" colspan="2">Эд анги солих зардал</td>
      <td align="left">' . number_format($invoiceValues['order_total_tax']) . '</td>
      <td align="left"></td>
    </tr>
    <tr>
      <td align="left">2</td>
      <td align="left" colspan="2">Эд анги будах зардал</td>
      <td align="left">' . number_format($invoiceValues['order_amount_paid']) . '</td>
      <td align="left"></td>
    </tr>
    <tr>
      <td align="left">3</td>
      <td align="left" colspan="2">' . number_format($invoiceValues['order_total_amount_due']) . ' гр будаг тус.мат.лак</td>
      <td align="left">' . number_format($invoiceValues['niitbudag']) . '</td>
      <td align="left"></td>
    </tr>
    <tr>
      <td align="left"></td>
      <td align="left" colspan="2"><b>Шууд бус зардал</b></td>
      <td align="left"><b>' . number_format($invoiceValues['shuudbus']) . '</b></td>
      <td align="left"></td>
    </tr>

    <table cellpadding="5">
      <tr>
        <td width="10%" rowspan="3"></td>
        <td></td>
      </tr>
      <tr>
        <td><b align="left">Шууд зардлын дүн: ' . number_format($direct) . '</b></td>
      </tr>
      <tr>
        <td><b align="left">Үнэлгээгээр тогтоогдсон дүн:' . number_format($totdirect) . '</b></td>
      </tr>
    </table>

  </table>
  </td>
  </tr>
  </table>
';

if (!empty($invoiceImages)) {
    $output .= '<div class="page-break"></div>';
    $output .= '<div class="print-image-section">';
    $output .= '<div class="print-image-title">Үл хөдлөх хөрөнгийн зураг</div>';

    if (!empty($coverImage)) {
        $output .= '
        <div class="print-cover-wrap">
          <div class="print-cover-label">Cover зураг</div>
          <img class="print-cover-image" src="' . htmlspecialchars(pdfImageSrc($coverImage), ENT_QUOTES, 'UTF-8') . '" alt="Cover image">
        </div>';
    }

    if (!empty($galleryImages)) {
        $output .= '<table class="print-gallery"><tbody>';
        $chunks = array_chunk($galleryImages, 2);

        foreach ($chunks as $row) {
            $output .= '<tr>';

            foreach ($row as $img) {
                $imgSrc = pdfImageSrc($img['path']);
                $imgName = $img['name'] ?? basename($img['path']);

                $output .= '
                <td>
                  <div class="print-gallery-card">
                    <img class="print-gallery-image" src="' . htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8') . '" alt="">
                    <div class="print-gallery-name">' . htmlspecialchars($imgName, ENT_QUOTES, 'UTF-8') . '</div>
                  </div>
                </td>';
            }

            if (count($row) < 2) {
                $output .= '<td></td>';
            }

            $output .= '</tr>';
        }

        $output .= '</tbody></table>';
    }

    $output .= '</div>';
}

$invoiceFileName = 'Invoice-' . $invoiceValues['order_id'] . '.pdf';
require_once 'dompdf/hurunguload.inc.php';
Dompdf\hurunguloader::register();

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->setIsPhpEnabled(true)
        ->setIsRemoteEnabled(true)
        ->setIsJavascriptEnabled(true)
        ->set('defaultFont', 'dejavu sans');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($output);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$f = null;
$l = null;
if (headers_sent($f, $l)) {
    echo $f, '<br/>', $l, '<br/>';
    die('now detect line');
}

$dompdf->stream($invoiceFileName, array("Attachment" => false));
?>