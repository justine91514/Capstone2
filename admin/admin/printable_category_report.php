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
        $this->Cell(0, 90, 'Category Reports', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
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

// set font
$pdf->SetFont('helvetica', 'B', 11); // Set font to bold

// add a page
$pdf->AddPage();

// Set table header
$pdf->SetY(100);
$pdf->SetX(108.5);
$pdf->SetFillColor(37, 158, 158); // Change the fill color to #259E9E
$pdf->SetTextColor(255);
$pdf->Cell(10, 8, 'ID', 1, 0, 'C', 1); // Adjust cell width
$pdf->Cell(70, 8, 'Category Name', 1, 1, 'C', 1); // Adjusted width for Category Name

// Fetch data from the database
$connection = mysqli_connect("localhost", "root", "", "dbpharmacy");
$query = "SELECT * FROM category_list"; // Modify to your actual table name
$result = mysqli_query($connection, $query);

// Data rows
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->SetX(108.5); // Set X position to 40
$fill = false;

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->SetFont('helvetica', '', 10); // Set font to regular (no bold or italic)
    $pdf->Cell(10, 8, $row['id'], 1, 0, 'C', $fill); // Adjust cell width
    $pdf->Cell(70, 8, $row['category_name'], 1, 1, 'C', $fill); // Adjusted width for Category Name
    $pdf->SetX(108.5);

    $fill = !$fill;
}

// Close and output PDF document
$pdf->Output('category_report.pdf', 'I');

// Close database connection
mysqli_close($connection);
?>
