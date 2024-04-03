<?php
require_once('tcpdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'3GMED.jpg';
        
        // Calculate X position to center the image
        $pageWidth = $this->getPageWidth();
        $imageWidth = 100; // Adjust as needed
        $xPos = ($pageWidth - $imageWidth) / 2;

        $this->Image($image_file, $xPos, 10, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        // Calculate X positions to center the line
        $lineStartX = $xPos - 90;
        $lineEndX = $xPos + 190; // Adjust line length as needed

        // Draw a line below the logo
        $this->Line($lineStartX, 75, $lineEndX, 75); // Adjust Y position to move the line below the logo

        // Set font
        $this->SetFont('times', 'B', 30);
        
        // Add Inventory Reports text
        $this->SetY(40); // Adjust the Y position as needed
        $this->Cell(0, 90, 'Inventory Reports', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
        // Move Y position below the text
        $this->SetY(100); // Adjust the Y position based on your requirements
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 100, PDF_MARGIN_RIGHT); // Increased top margin to accommodate the header

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// Set font
$pdf->SetFont('helvetica', 'B', 11); // Set font to bold

// Add a page
$pdf->AddPage();

// Set table header
$pdf->SetY(100);
$pdf->SetX(38);
$pdf->SetFillColor(48, 75, 27);
$pdf->SetTextColor(255);
$pdf->Cell(10, 8, 'ID', 1, 0, 'C', 1); // Adjust cell width
$pdf->Cell(31, 8, 'SKU', 1, 0, 'C', 1); // Adjusted width for SKU
$pdf->Cell(30, 8, 'Product Name', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Description', 1, 0, 'C', 1);
$pdf->Cell(20, 8, 'Quantity', 1, 0, 'C', 1); // Adjust cell width
$pdf->Cell(20, 8, 'Price', 1, 0, 'C', 1);
$pdf->Cell(24, 8, 'Branch', 1, 0, 'C', 1);
$pdf->Cell(36, 8, 'Batch Number', 1, 0, 'C', 1); // Adjust cell width
$pdf->Cell(26, 8, 'Expiry Date', 1, 0, 'C', 1);
$pdf->Cell(26, 8, 'Date Added', 1, 1, 'C', 1);

// Fetch data from the database
$connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
// Filter branch
$selectedBranch = isset($_GET['branch']) ? $_GET['branch'] : 'All';

$query = "SELECT * FROM add_stock_list";
if ($selectedBranch !== 'All') {
    $query .= " WHERE branch = '$selectedBranch'";
}
$query .= " ORDER BY id"; // Add ORDER BY clause to sort by ID column
$result = mysqli_query($connection, $query);

// Data rows
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->SetX(38); // Set X position to 40
$fill = false;

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->SetFont('helvetica', '', 10); // Set font to regular (no bold or italic)
    $pdf->Cell(10, 8, $row['id'], 1, 0, 'C', $fill); // Adjust cell width
    $pdf->Cell(31, 8, $row['sku'], 1, 0, 'C', $fill); // Adjusted width for SKU
    $pdf->Cell(30, 8, $row['product_stock_name'], 1, 0, 'C', $fill);
    $pdf->Cell(30, 8, $row['descript'], 1, 0, 'C', $fill);
    $pdf->Cell(20, 8, $row['quantity'], 1, 0, 'C', $fill); // Adjust cell width
    $pdf->Cell(20, 8, $row['price'], 1, 0, 'C', $fill);
    $pdf->Cell(24, 8, $row['branch'], 1, 0, 'C', $fill);
    $pdf->Cell(36, 8, $row['batch_number'], 1, 0, 'C', $fill); // Adjust cell width
    $pdf->Cell(26, 8, $row['expiry_date'], 1, 0, 'C', $fill);
    $pdf->Cell(26, 8, $row['date_added'], 1, 1, 'C', $fill);
    $pdf->SetX(38); // Reset X position after each row
    $fill = !$fill;
}

// Close and output PDF document
$pdf->Output('stocks_report.pdf', 'I');

// Close database connection
mysqli_close($connection);
?>
