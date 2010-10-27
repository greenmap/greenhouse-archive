<?php
// $Id: pdf_invoice.php,v 1.1.2.1 2007/01/19 04:50:43 gordon Exp $

/**
 * @file
 * This is an example to creating a PDF invoice for E-Commerce. The
 * functions below are generally appended to the template.php.
 *
 * Also to create the PDF document the TCPDF Class
 * (http://www.tecnick.com/public/code/cp_dpage.php?aiocp_dp=tcpdf) needs to
 * be extracted into the same directory as your theme.
 */

if (!class_exists('TCPDF')) {
  require_once (path_to_theme(). '/tcpdf/tcpdf.php');
}

/**
 * Implementation of theme_store_invoice()
 *
 * This function will replace the default invoice outut format with the pdf
 * version.
 *
 * This is a cut down version which depend. If the $print_mode is TRUE or
 * the $_GET['q'] ends in '/pdf' then the pdf document will be display
 * directly to the page for download, otherwise the system will give a link
 * to be displayed.
 */
function phptemplate_store_invoice($txn, $print_mode = TRUE, $trial = FALSE) {
  if ($print_mode || preg_match('/\/pdf$/i', $_GET['q'])) {
    if (is_a($pdf = _phptemplate_build_invoice($txn, $trial), 'TCPDF')) {
      $pdf->Output('invoice_'. ($trial ? 'trial' : $txn->txnid) .'.pdf', 'I');
      exit();
    }
    drupal_not_found();
    exit();
  }
  $output.= t('Click !here to view this invoice', array('!here' => l(t('here'), "{$_GET['q']}/pdf")));
  return $output;
}

/**
 * invoice_pdf
 *
 * This is a basic class which will remove the default header and footer
 * methods from the TCPDF Class.
 */
class invoice_pdf extends TCPDF {
  public function Header() {
  }

  public function Footer() {
  }
}

/**
 * _phptemplate_build_invoice()
 *
 * @param $txn
 *    The $txn object which is to coverted into a PDF document.
 *
 * @param $trial
 *    indicates that this is a trail invoice and should not a final invoice.
 *    This invoice may change, so it is required that when displaying this
 *    version to display somewhere on the invoice that this is such.
 *
 * @return
 *    This function will return a TCPDF object which can then be printed or
 *    stored, depanding on the requirements of the calling function.
 */
function _phptemplate_build_invoice($txn, $trial) {
  if (!$txn->mail && $txn->uid && ($account = user_load(array('uid' => $txn->uid)))) {
    $txn->mail = $account->mail;
  }

  $pdf = new invoice_pdf('P', 'mm', 'A4', FALSE);

  $pdf->Open();
  $pdf->SetCompression(TRUE);
  $pdf->SetMargins(25, 66.3, 25);
  $pdf->SetAutoPageBreak(TRUE, 50);
  $pdf->SetFont('Helvetica', 'B');
  $pdf->SetFontSize(16);
  $pdf->AddPage();

  $text = t('%site-name Invoice', array('%site-name' => variable_get("site_name", "Drupal")));
  $tw = $pdf->GetStringWidth($text);
  $pdf->SetXY(105 - ($tw/2), 25);
  $pdf->Write(12, $text);

  $pdf->SetFont('', 'B');
  $pdf->SetFontSize(12);

  //$output = ($trial ? 'TRIAL INVOICE' : format_date($txn->created, 'custom', 'j M Y')) ."\n";
  $pdf->SetXY(25, 65);
  $output = t('Shipping to'). "\n";
  $pdf->Cell(80, 5, $output, 0, 1);
  $pdf->SetFont('', '');
  $output = store_format_address($txn, 'shipping', 'text');
  $pdf->MultiCell(80, 5, $output);

  $pdf->SetXY(110, 65);
  $pdf->SetFont('', 'B');
  $output = t('Billing to'). "\n";
  $pdf->Cell(80, 5, $output, 0, 1);
  $pdf->SetX(110);
  $pdf->SetFont('', '');
  $output = store_format_address($txn, 'billing', 'text');
  $pdf->MultiCell(80, 5, $output);

  $pdf->SetFont('', 'B');
  $pdf->SetFontSize(9);
  $pdf->Line(25, 142, 186, 142);
  $pdf->Text(26, 147, 'Description');
  $pdf->Text(140, 147, 'Price');
  $pdf->Text(153, 147, 'Qty');
  $pdf->Text(163, 147, 'Extended Price');

  $pdf->Line(25, 149, 186, 149);
  $y = 150;

  $pdf->SetFont('', '');
  $pdf->SetRightMargin(97);
  if ($txn->items) {
    foreach ($txn->items as $key => $item) {
      $pdf->SetXY(25, $y);
      $pdf->Write(3, $item->title);
      $new_y = $pdf->GetY();

      $price = store_adjust_misc($txn, $item);
      if (product_has_quantity($item)) {
        $has_qty = TRUE;
        $qty = $item->qty;
      }
      else {
        $has_qty = TRUE;
        $qty = 1;
      }
      $extend_price = $price*$qty;

      $text = payment_format($price);
      $pdf->Text(151-$pdf->GetStringWidth($text), $y+2.5, $text);

      if ($has_qty) {
        $pdf->Text(158-$pdf->GetStringWidth($qty), $y+2.5, $qty);
      }

      $text = payment_format($extend_price);
      $pdf->Text(186-$pdf->GetStringWidth($text), $y+2.5, $text);

      $y = $new_y;
      $y+= 3;
    }
  }

  if ($txn->misc) {
    usort($txn->misc, 'store_transaction_misc_sort');
    foreach ($txn->misc as $misc) {
      if (!$misc->seen) {
        $pdf->SetXY(25, $y);
        $pdf->Write(3, $misc->description);
        $new_y = $pdf->GetY();

        $price = $misc->price;
        $extend_price = $price*$misc->qty;

        $text = payment_format($price);
        $pdf->Text(151-$pdf->GetStringWidth($text), $y+2.5, $text);

        if ($misc->qty > 1) {
          $pdf->Text(158-$pdf->GetStringWidth($misc->qty), $y+2.5, $misc->qty);
        }

        $text = payment_format($extend_price);
        $pdf->Text(186-$pdf->GetStringWidth($text), $y+2.5, $text);

        $y = $new_y;
        $y+= 3;
      }
    }
  }

  $y+= 2.5;
  if ($y < 180) {
    $y = 180;
  }

  $pdf->Line(25, $y, 186, $y);

  $pdf->SetFontSize(9);
  $y+= 5;

  $pdf->SetFont('', 'B');
  $gross = store_transaction_calc_gross($txn);

  $pdf->Text(153, $y, 'Total');
  $text = payment_format($gross);
  $pdf->Text(186-$pdf->GetStringWidth($text), $y, $text);
  $y+= 20;

  $pdf->SetFont('', 'B');
  $text = 'Ordered On: ';
  $pdf->Text(25, $y, $text);
  $x = $pdf->GetStringWidth($text)+25;
  $pdf->SetFont('', '');
  $pdf->Text($x, $y, format_date($txn->created));
  $y+= 3;

  if ($txn->duedate) {
    $pdf->SetFont('', 'B');
    $text = 'Due Date: ';
    $pdf->Text(25, $y, $text);
    $x = $pdf->GetStringWidth($text)+25;
    $pdf->SetFont('', '');
    $pdf->Text($x, $y, format_date($txn->duedate));
    $y+= 3;
  }

  $pdf->SetFont('', 'B');
  $text = 'Transaction ID: ';
  $pdf->Text(25, $y, $text);
  $x = $pdf->GetStringWidth($text)+25;
  $pdf->SetFont('', '');
  $pdf->Text($x, $y, $txn->txnid);
  $y+= 3;

  return $pdf;
}
