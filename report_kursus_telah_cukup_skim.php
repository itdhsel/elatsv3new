<?php
//require('trymc_table.php');
require('fpdf.php');
include 'files/db.php';

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
//Colors, line width and bold font
	//$this->SetFillColor(255,0,0);
	//$this->SetTextColor(255);
	$this->SetDrawColor(8,0,0);		//frame color of first row of table
	$this->SetLineWidth(.2);		//frame width of first row of table
	//$this->SetFont('','B');
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
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
        $l+=$cw[$c];
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
		//$this->SetFillColor(230,230,0);
    	//$this->SetTextColor(220,50,50);
	
	//Logo
	$this->Image('images/logo.jpg',5,5,33);
	
	//Title
	$jabatan = $_POST['skim_khidmat'];
	$tarikh_belum1 = $_POST['tarikh_mula'];
	$tarikh_belum2 = $_POST['tarikh_tamat'];
	$this->SetFont('Arial','b',12);													//Font: Arial bold 15
	$this->ALIGN == 'center';														//$this->Cell(100); (Move to the right)
	$this->Cell(0,12,'BIL PEGAWAI YANG HADIR KURSUS MELEBIHI 7 HARI SETAHUN MENGIKUT SKIM PERKHIDMATAN',0,0,C);
	$this->Ln(10);
	$this->Cell(0,5,'DARI '.$tarikh_belum1.' HINGGA '.$tarikh_belum2,0,0,C);
	$this->Ln(10);
	
	//Date today
	$today = date("d-m-Y");					//y for dd-mm-yy; Y for dd-mm-yyyy
	$this->SetFont('Arial','b',9);	
	//$this->Cell(130,10,$today,0,0,'L');
	$this->Cell(0,10,'Tarikh Laporan : '.$today.'');
	$this->Ln(10);
	$this->Cell(0,5,'Nama Skim Perkhidmatan: '.$jabatan.'');

	$this->Ln(10);
	//$this->SetDrawColor(0,80,180);
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(220,50,50);
	$this->Cell(7,7,'NO','LRTB',0,'C',true);
	$this->Cell(68,7,'NAMA PEGAWAI','LRTB',0,'C',true);
	$this->Cell(22,7,'NO K/P','LRTB',0,'C',true);
	$this->Cell(60,7,'JAWATAN','LRTB',0,'C',true);
	$this->Cell(15,7,'GRED','LRTB',0,'C',true);
	$this->Cell(68,7,'JABATAN','LRTB',0,'C',true);
	$this->Cell(24,7,'JUM. HARI','LRTB',0,'C',true);
	//$this->Cell(23,7,'STATUS','LRTB',0,'C',true);
	$this->Ln();
}

//Fungsi Untuk Membuat Footer
function Footer()

{

	//Position at 1.5 cm from bottom
	$this->SetY(-15);
	
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	
	//Page number
	$this->Cell(0,10,'Halaman '.$this->PageNo(),0,0,'C');

}

function _putpages()
{
    $nb=$this->page;
    if(!empty($this->AliasNbPages))
    {
        //Replace number of pages
        for($n=1;$n<=$nb;$n++)
        {
            if($this->compress)
                $this->pages[$n]=gzcompress(str_replace($this->AliasNbPages,$nb,gzuncompress($this->pages[$n])));
            else
                $this->pages[$n]=str_replace($this->AliasNbPages,$nb,$this->pages[$n]);
        }
    }
    if($this->DefOrientation=='P')
    {
        $wPt=$this->DefPageFormat[0]*$this->k;
        $hPt=$this->DefPageFormat[1]*$this->k;
    }
    else
    {
        $wPt=$this->DefPageFormat[1]*$this->k;
        $hPt=$this->DefPageFormat[0]*$this->k;
    }
    $filter=($this->compress) ? '/Filter /FlateDecode ' : '';
    for($n=1;$n<=$nb;$n++)
    {
        //Page
        $this->_newobj();
        $this->_out('<</Type /Page');
        $this->_out('/Parent 1 0 R');
        if(isset($this->PageSizes[$n]))
            $this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]',$this->PageSizes[$n][0],$this->PageSizes[$n][1]));
        $this->_out('/Resources 2 0 R');
        if(isset($this->PageLinks[$n]))
        {
            //Links
            $annots='/Annots [';
            foreach($this->PageLinks[$n] as $pl)
            {
                $rect=sprintf('%.2F %.2F %.2F %.2F',$pl[0],$pl[1],$pl[0]+$pl[2],$pl[1]-$pl[3]);
                $annots.='<</Type /Annot /Subtype /Link /Rect ['.$rect.'] /Border [0 0 0] ';
                if(is_string($pl[4]))
                    $annots.='/A <</S /URI /URI '.$this->_textstring($pl[4]).'>>>>';
                else
                {
                    $l=$this->links[$pl[4]];
                    $h=isset($this->PageSizes[$l[0]]) ? $this->PageSizes[$l[0]][1] : $hPt;
                    $annots.=sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]>>',1+2*$l[0],$h-$l[1]*$this->k);
                }
            }
            $this->_out($annots.']');
        }
        $this->_out('/Contents '.($this->n+1).' 0 R>>');
        $this->_out('endobj');
        //Page content
        $p=$this->pages[$n];
        $this->_newobj();
        $this->_out('<<'.$filter.'/Length '.strlen($p).'>>');
        $this->_putstream($p);
        $this->_out('endobj');
    }
    //Pages root
    $this->offsets[1]=strlen($this->buffer);
    $this->_out('1 0 obj');
    $this->_out('<</Type /Pages');
    $kids='/Kids [';
    for($i=0;$i<$nb;$i++)
        $kids.=(3+2*$i).' 0 R ';
    $this->_out($kids.']');
    $this->_out('/Count '.$nb);
    $this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]',$wPt,$hPt));
    $this->_out('>>');
    $this->_out('endobj');
}

function _endpage()
{
    parent::_endpage();
    if($this->compress)
        $this->pages[$this->page] = gzcompress($this->pages[$this->page]);
}

}

ini_set('memory_limit','100M');
ini_set('max_execution_time',0);


$pdf=new PDF('L','mm','A4');
$pdf->AddPage();

$pdf->SetFont('Arial','',7);
//Table width
$pdf->SetWidths(array(7,68,22,60,15,68,24));
$pdf->SetAligns (array(C,L,C,C,C,C,C,C));


include 'files/db.php';

$jabatan = $_POST['skim_khidmat'];
$user_id = $_POST['user_id'];
$level = $_POST['level'];

$tarikh_belum1 = $_POST['tarikh_mula'];
$hari=substr("$tarikh_belum1",0,2);
$bulan=substr("$tarikh_belum1",3,2);
$tahun=substr("$tarikh_belum1",6,4);
$tarikh_mula="$tahun"."-"."$bulan"."-"."$hari";

$tarikh_belum2 = $_POST['tarikh_tamat'];
$hari=substr("$tarikh_belum2",0,2);
$bulan=substr("$tarikh_belum2",3,2);
$tahun=substr("$tarikh_belum2",6,4);
$tarikh_tamat="$tahun"."-"."$bulan"."-"."$hari";

$today = date("Y-m-d");

if($tarikh_mula > $tarikh_tamat)
{
	echo 'Tarikh di medan DARI tidak boleh lebih dari tarikh di medan HINGGA';
	echo '<br> Klik tanda pangkah ( X ) untuk tutup';
}
else
{
	if($tarikh_tamat > $today)
	{
		echo 'Tiada Rekod Dijumpai. Pastikan tarikh di medan DARI tidak melebihi tarikh hari ini';
		echo '<br> Klik tanda pangkah ( X ) untuk tutup';
	}
	else
	{
		if($level == 1)
		{
		$strSQL = "SELECT k.valid, n.namapegawai, n.nokp, n.skim_khidmat,n.gredhakiki, n.kumpulan,n.jabatan,n.status, sum(k.total_jam) DIV 6 as hari, MOD(sum(k.total_jam),6) as jam_tinggal 							
					FROM peribadi n, kursus k
					WHERE k.nokp2 = n.nokp
          AND n.skim_khidmat = '$jabatan'
					AND k.tarikh_mula BETWEEN '$tarikh_mula' AND '$tarikh_tamat'
					AND k.tarikh_tamat BETWEEN '$tarikh_mula' AND '$tarikh_tamat'
          AND n.status = 'AKTIF' AND k.valid = 1
					GROUP BY n.nokp
					ORDER BY k.total_jam desc";
		$result = mysqli_query($strSQL);
		$found = mysqli_num_rows($result);
		
		}
		else
		{
		$strSQL = "SELECT k.valid, n.namapegawai, n.nokp, n.skim_khidmat, n.gredhakiki, n.kumpulan, n.jabatan, n.status, sum(k.total_jam) DIV 6 as hari, MOD(sum(k.total_jam),6) as jam_tinggal		
					FROM peribadi n, kursus k
					WHERE k.nokp2 = n.nokp
          AND n.skim_khidmat = '$jabatan'
					AND k.tarikh_mula BETWEEN '$tarikh_mula' AND '$tarikh_tamat'
					AND k.tarikh_tamat BETWEEN '$tarikh_mula' AND '$tarikh_tamat'
          AND n.status = 'AKTIF' AND k.valid = 1
					GROUP BY n.nokp
					ORDER BY k.total_jam desc";
		$result = mysqli_query($strSQL);
		$found = mysqli_num_rows($result);

		}
	}
}
		
//foreach ($a as $b) {  print $b . " "; } 

//$capture = mysqli_fetch_array ($result);
if($found == 0)
{
	echo 'Tiada Rekod Dijumpai Dari Pangkalan Data Dalam Tempoh Dipilih';
	echo '<br> Klik tanda pangkah ( X ) untuk tutup';
  //echo '<br>SQL:<br>'.$strSQL;
}
else 

{
	while($capture = mysqli_fetch_array($result))
	{
		if( $capture['hari'] >= 7)
		{
					
		$pdf->Row(array(($i = $i+1),$capture['namapegawai'],$capture['nokp'],$capture['skim_khidmat'],$capture['gredhakiki'], $capture['jabatan'],
		$capture['hari']));
					
		}
		//else
		//{
		//	echo 'Tiada Pengawai HSB Yang Belum Cukup Hari Kursus';
		//	echo '<br> Klik tanda pangkah ( X ) untuk tutup';
		//}
	}
		//while($capture2 = mysqli_fetch_array($result2))
		//{if( $capture2['jam'] > 12)
		//{$pdf->Row(array(($i = $i+1), $capture2['jam']));}	
				
	$pdf->Output();

}
?>