<?php
require_once('tcpdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
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
        $this->Cell(0, 90, 'Product Reports', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
        // Move Y position below the text
        $this->SetY(100); // Adjust the Y position based on your requirements
    }

    //Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 100, PDF_MARGIN_RIGHT); // Increased top margin to accommodate the header

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// Fetch data from the database based on selected branch
$selectedBranch = isset($_GET['branch']) ? $_GET['branch'] : 'All';

$connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
$query = "SELECT * FROM product_list";
$result = mysqli_query($connection, $query);

// Add a page
$pdf->AddPage();

// Set font for the table headers
// Set font for the table headers
$pdf->SetFont('helvetica', 'B', 11);

// Set fill color for header row
$pdf->SetFillColor(37, 158, 158); // Change the fill color to #259E9E
$pdf->SetTextColor(255);
$pdf->SetX(25); // Set X position to 40

// Header row
$pdf->Cell(20, 10, 'ID', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Product Name', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Category', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Type', 1, 0, 'C', 1);
$pdf->Cell(45, 10, 'Measurement', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Stocks Available', 1, 0, 'C', 1);
$pdf->Cell(25, 10, 'Prescription', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Has Discount', 1, 1, 'C', 1);

// Set font for the table data
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(0);
$pdf->SetX(25); // Set X position to 40

// Data rows
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(20, 10, $row['id'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['prod_name'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['categories'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['type'], 1, 0, 'C');
    $pdf->Cell(45, 10, $row['measurement'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['stocks_available'], 1, 0, 'C');
    $pdf->Cell(25, 10, ($row['prescription'] == 1 ? 'Yes' : 'No'), 1, 0, 'C');
    $pdf->Cell(40, 10, ($row['discounted'] == 1 ? 'Yes' : 'No'), 1, 1, 'C');
    $pdf->SetX(25); // Set X position to 40
}


// Close database connection
mysqli_close($connection);

// Close and output PDF document
$pdf->Output('user_management_report.pdf', 'I');
?>

