<?php
require('fpdf.php');

class PDF extends FPDF
{
    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        
        // Safe character width calculation for PHP 8.2
        $cw = [];
        if (isset($this->CurrentFont['cw']) && is_array($this->CurrentFont['cw'])) {
            $cw = $this->CurrentFont['cw'];
        }
        
        while($i<$nb)
        {
            $c=substr($s, $i, 1); // Safe way to get character
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=isset($cw[$c]) ? $cw[$c] : 600; // Default width if not found
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    //Page header
    function Header()
    {
        //Colors of frame, background and text
        $this->SetDrawColor(0,0,0);
        
        //Logo
        if(file_exists('images/logo.jpg')) {
            $this->Image('images/logo.jpg',5,5,33);
        }
  
        //Title
        $nokp = $_POST['nokp'] ?? '';
        
        // Include database connection
        include 'files/db.php';
        
        // Use prepared statement for security
        $querynama = "SELECT nokp, namapegawai FROM peribadi WHERE nokp = ?";
        $stmt = $conn->prepare($querynama);
        if ($stmt) {
            $stmt->bind_param("s", $nokp);
            $stmt->execute();
            $resultnama = $stmt->get_result();
            $capturenama = $resultnama->fetch_assoc();
            $stmt->close();
        } else {
            $capturenama = ['namapegawai' => 'Nama Tidak Ditemui'];
        }
  
        $this->SetFont('Arial','B',12);
        $tarikh_mula = $_POST['tarikh_mula'] ?? '';
        $tarikh_tamat = $_POST['tarikh_tamat'] ?? '';
        $this->Cell(0,12,'LAPORAN KURSUS DIHADIRI DARI '.$tarikh_mula.' HINGGA '.$tarikh_tamat.' BAGI',0,0,'C');
        $this->Ln(10);
        $this->Cell(0,5,($capturenama['namapegawai'] ?? ''),0,0,'C');
        $this->Ln(10);
        
        //Date today
        $today = date("d-m-Y");
        $this->SetFont('Arial','B',9);    
        $this->Cell(0,10,'Tarikh Laporan : '.$today.'');
        $this->Ln(15);
    }

    //Footer function
    function Footer()
    {
        //Position at 1.5 cm from bottom
        $this->SetY(-15);
        
        //Arial italic 8
        $this->SetFont('Arial','I',8);
        
        //Page number
        $this->Cell(0,10,'Halaman '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

ini_set('memory_limit','100M');
ini_set('max_execution_time',0);

// Create PDF instance
$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->AliasNbPages();

include 'files/db.php';   

// Safely get POST data with validation
$nokp = $_POST['nokp'] ?? '';
$user_id = $_POST['user_id'] ?? '';
$level = $_POST['level'] ?? '';

$tarikh_1 = $_POST['tarikh_mula'] ?? '';
$tarikh_2 = $_POST['tarikh_tamat'] ?? '';

// Validate date inputs
if(empty($tarikh_1) || empty($tarikh_2)) {
    die('Tarikh mula dan tarikh tamat diperlukan.');
}

// Improved date parsing with validation
function parseDate($date) {
    if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $date, $matches)) {
        return $matches[3] . '-' . $matches[2] . '-' . $matches[1];
    }
    return false;
}

$tarikh_mula = parseDate($tarikh_1);
$tarikh_tamat = parseDate($tarikh_2);

if(!$tarikh_mula) {
    die('Format tarikh mula tidak sah. Gunakan format DD-MM-YYYY');
}

if(!$tarikh_tamat) {
    die('Format tarikh tamat tidak sah. Gunakan format DD-MM-YYYY');
}

$today = date("Y-m-d");

// Validate dates
if($tarikh_mula > $tarikh_tamat) {
    die('Tarikh di medan DARI tidak boleh lebih dari tarikh di medan HINGGA<br>Klik tanda pangkah (X) untuk tutup');
}

if($tarikh_tamat > $today) {
    die('Tiada Rekod Dijumpai. Pastikan tarikh di medan DARI tidak melebihi tarikh hari ini<br>Klik tanda pangkah (X) untuk tutup');
}

// Use prepared statements for security
$query = "SELECT nokp, namapegawai, jabatan, skim_khidmat, gredhakiki, kumpulan 
        FROM peribadi 
        WHERE nokp = ?";
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param("s", $nokp);
    $stmt->execute();
    $result = $stmt->get_result();
    $found = $result->num_rows;
} else {
    die('Database error: ' . htmlspecialchars($conn->error));
}

if($found == 0) {
    die('Tiada Rekod Dijumpai Dari Pangkalan Data<br>Klik tanda pangkah (X) untuk tutup');
}

// Get course data
$strSQL1 = "SELECT k.valid, p.nokp, k.nama_kursus, k.tarikh_mula, k.tarikh_tamat, k.lokasi, k.cpdpoint, 
                   k.total_jam DIV 6 as hari, MOD(k.total_jam,6) as jam
            FROM peribadi p, kursus k
            WHERE p.nokp = ? AND k.nokp2 = p.nokp 
            AND k.tarikh_mula BETWEEN ? AND ?
            AND k.tarikh_tamat BETWEEN ? AND ?
            AND k.valid = 1
            ORDER BY k.tarikh_mula";
$stmt1 = $conn->prepare($strSQL1);
if ($stmt1) {
    $stmt1->bind_param("sssss", $nokp, $tarikh_mula, $tarikh_tamat, $tarikh_mula, $tarikh_tamat);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $found1 = $result1->num_rows;
} else {
    $result1 = false;
    $found1 = 0;
}

// Get summary data
$strSQL2 = "SELECT k.valid, SUM(k.total_jam) DIV 6 as jum_hari, MOD(SUM(k.total_jam),6) as jum_jam, SUM(k.cpdpoint) as cpd 
            FROM peribadi p, kursus k
            WHERE p.nokp = ? AND k.nokp2 = p.nokp 
            AND k.tarikh_mula BETWEEN ? AND ?
            AND k.tarikh_tamat BETWEEN ? AND ?
            AND k.valid = 1
            GROUP BY k.nokp2";        
$stmt2 = $conn->prepare($strSQL2);
if ($stmt2) {
    $stmt2->bind_param("sssss", $nokp, $tarikh_mula, $tarikh_tamat, $tarikh_mula, $tarikh_tamat);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $found2 = $result2->num_rows;
} else {
    $result2 = false;
    $found2 = 0;
}

// Display staff information
while ($capture = $result->fetch_assoc()) {
    $pdf->Cell(190,10,'','T');
    $pdf->Ln(5);
    $pdf->Cell(10,10,'JABATAN     :  '.($capture['jabatan'] ?? ''));
    $pdf->Cell(100);
    $pdf->Cell(0,10,'NO K/P            :  '.($capture['nokp'] ?? ''));
    $pdf->Ln(5);
    
    $pdf->Cell(10,10,'JAWATAN    :  '.($capture['skim_khidmat'] ?? ''));
    $pdf->Cell(100);
    $pdf->Cell(0,10,'KUMPULAN    :  '.($capture['kumpulan'] ?? '')); 
    $pdf->SetX(10); // Reset X position instead of using negative values
    $pdf->Cell(190,15,'','B');
    $pdf->Ln(28);
}

// Table header
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(220,50,50);
$pdf->Cell(10,7,'NO','LRTB',0,'C',true);
$pdf->Cell(70,7,'NAMA KURSUS','LRTB',0,'C',true);
$pdf->Cell(20,7,'TKH MULA','LRTB',0,'C',true);
$pdf->Cell(20,7,'TKH TAMAT','LRTB',0,'C',true);
$pdf->Cell(18,7,'JUM.HARI','LRTB',0,'C',true);
$pdf->Cell(18,7,'JUM.JAM','LRTB',0,'C',true);
$pdf->Ln();

// Course data
$i = 0;
if ($result1 && $found1 > 0) {
    while($capture1 = $result1->fetch_assoc()) {
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetWidths([10,70,20,20,18,18]);
        $pdf->SetAligns(['C','L','C','C','C','C']);
        $pdf->Row([
            ++$i, 
            $capture1['nama_kursus'] ?? '', 
            $capture1['tarikh_mula'] ?? '', 
            $capture1['tarikh_tamat'] ?? '', 
            $capture1['hari'] ?? 0, 
            $capture1['jam'] ?? 0
        ]);                
    }
}

// Summary
if ($result2 && $found2 > 0) {
    while($capture2 = $result2->fetch_assoc()) {
        $pdf->SetFont('Arial','B',8);
        $pdf->Ln(5);
        $pdf->Cell(0,10,'TEMPOH KURSUS DIHADIRI    :  '.($capture2['jum_hari'] ?? 0).' HARI '.($capture2['jum_jam'] ?? 0).' JAM');
        $pdf->Ln(15);
    }
}

// Close statements
if (isset($stmt)) $stmt->close();
if (isset($stmt1)) $stmt1->close();
if (isset($stmt2)) $stmt2->close();

$pdf->Output();
?>