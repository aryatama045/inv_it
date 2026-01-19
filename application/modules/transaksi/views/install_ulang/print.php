
<?php

class PDF extends Pdf_javascript
{
    private $jml_baris;
    private $grand_total;
    private $total;
    private $halaman;
    private $total_halaman;

    function setData($data){
        $this->data     = $data;
        $this->header   = $this->data['header'];
        $this->detail   = $this->data['detail'];
        $this->halaman=0;
    }

	function Header(){
        //Lebar A4 = 190 + margin 10
        $this->total_halaman =  ceil(count($this->detail)/41);
        $this->halaman++;

        $this->Ln(1);
        $this->setFont('Arial','B',10);
        $this->cell(100,1,'PT. Optik Tunggal Sempurna',0,0,'L');
        $this->setFont('Arial','B',12);
        $this->cell(0,1,$this->data['lampiran'],0,0,'R');
        $this->Ln(4);
        $this->setFont('Arial','',8);
        $this->cell(0,2,'Jl. Pintu Air Raya No. 36 KL',0,0,'L');
        $this->Ln(4);
        $this->cell(90,2,'Jakarta Pusat 10710',0,0,'L');
        $this->cell(0,2,'Page '.$this->halaman." of ".$this->total_halaman,0,0,'R');
        $this->Ln(4);
        $this->Line(11,$this->GetY(),199,$this->GetY());
        $this->Ln(0.8);
        $this->Line(11,$this->GetY(),199,$this->GetY());
        $this->setFont('Arial','BU',8);
        $this->cell(0,6,'INSTALL ULANG ',0,0,'C');
        $this->Ln(10);
        $this->setFont('Arial','',8);
        $this->cell(30,1,'Kepada',0,0,'L');
        $this->cell(100,1,': '.$this->header['pc_tujuan'],0,0,'L');
        $this->cell(25,1,'Nomor',0,0,'L');
        $this->cell(0,1,': '.$this->header['nomor_transaksi'],0,0,'L');
        $this->Ln(4);
        $this->cell(30,1,'PC OS',0,0,'L');
        $this->cell(100,1,': '.$this->header['pc_os'],0,0,'L');
        
        $this->cell(25,1,'Tanggal Dokumen',0,0,'L');
        $this->cell(0,1,': '.$this->header['tanggal_dokumen'],0,0,'L');
        $this->Ln(4);

        $this->cell(30,1,'PC - IP',0,0,'L');
        $this->cell(100,1,': '.$this->header['pc_ip'],0,0,'L');
        $this->cell(25,1,'Tanggal Install',0,0,'L');
        $this->cell(0,1,': '.$this->header['tanggal_mulai'],0,0,'L');
        $this->Ln(4);

        $this->cell(30,1,'',0,0,'L');
        $this->cell(100,1,' ',0,0,'L');
        $this->cell(25,1,'Tanggal Check',0,0,'L');
        $this->cell(0,1,': '.$this->header['tanggal_check'],0,0,'L');
        $this->Ln(4);

        $this->cell(30,1,'Mengetahui',0,0,'L');
        $this->cell(100,1,': '.$this->header['pic_approve'],0,0,'L');
        $this->cell(25,1,'Tanggal Selesai',0,0,'L');
        $this->cell(0,1,': '.$this->header['tanggal_selesai'],0,0,'L');
        $this->Ln(4);


        $this->cell(30,1,'',0,0,'L');
        $this->cell(100,1,'',0,0,'L');
        $this->Ln(4);
        $this->HeaderList();
    }

    function HeaderList(){
        $this->Ln(4);
        $this->Line(11,$this->GetY(),199,$this->GetY());
        $this->Ln(3);
        $this->cell(6,1,'NO.',0,0,'C');
        $this->cell(60,1,'PROGRAM',0,0,'L');
        $this->cell(70,1,'BARANG',0,0,'L');
        $this->cell(55,1,'KETERANGAN',0,0,'L');
        $this->Ln(3);
        $this->Ln(4);
        $this->Line(11,$this->GetY(),199,$this->GetY());
        $this->Ln(4);
    }
    function Data(){
        $baris  = 1;
        $urut   = 1;
        foreach ($this->detail as $value) {
            if($baris==41){
                $this->FooterSubTotal();
                $this->AddPage();
                $baris = 1;
            }
            if($value['no_urut']!=0){
                $this->cell(6,1,$urut,0,0,'C');
                $this->cell(60,1,$value['program'],0,0,'L');
                $this->cell(70,1,$value['barang'],0,0,'L');
                $this->cell(55,1,$value['keterangan_detail'],0,0,'L');
                $this->Ln(4);
                $baris++;
                $urut++;
            }
        }
        $this->jml_baris = $baris;

        $this->FooterTotal();

    }

    function FooterTotal(){
        // Go to 1.5 cm from bottom
        if($this->jml_baris <= 13){
            $this->SetY(-195);
        }else{
            $this->SetY(-75);
        }

        $this->Ln(4);
        $this->Line(11,$this->GetY(),200,$this->GetY());
        $this->Ln(4);
        $this->cell(18,1,'Keterangan :',0,0,'L');
        $this->cell(130,1,$this->header['keterangan_header'],0,0,'L');
        $this->cell(10,1,' ',0,0,'L');
        $this->cell(25,1,'',0,0,'R');
        $this->Ln(4);
        $this->Line(11,$this->GetY(),200,$this->GetY());
        $this->Ln(4);
        $this->cell(60,1,'Di Install Oleh,',0,0,'C');
        $this->cell(30,1,'',0,0,'C');
        $this->cell(40,1,'',0,0,'C');
        $this->cell(45,1,'Di Check Oleh,',0,0,'C');
        $this->Ln(18);
        $this->cell(155,1,'',0,0,'C');
        $this->Ln(4);
        $this->cell(60,1,'('.$this->header['pic_install'].')',0,0,'C');
        $this->cell(30,1,'',0,0,'C');
        $this->cell(40,1,'',0,0,'C');
        $this->cell(45,1,'('.$this->header['pic_check'].')',0,0,'C');
        $this->Ln(4);
        $this->Line(11,$this->GetY(),200,$this->GetY());
        $this->Ln(2);
        $this->cell(65,1,'*Harap ditanda tangani sebagai bukti.',0,0,'L');
    }

    function FooterSubTotal(){
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        $this->Ln(4);
        $this->cell(18,1,'Keterangan :',0,0,'L');
        $this->cell(132,1,$this->header['keterangan'],0,0,'L');
        $this->cell(10,1,'Sub Total ',0,0,'L');
        $this->cell(25,1,$this->grand_total,0,0,'R');
        $this->Ln(4);
        $this->Line(11,$this->GetY(),199,$this->GetY());
    }

    function AutoPrint($printer='')
    {
        // Open the print dialog
        if($printer)
        {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        }
        else
            $script = 'print(true);';
        $this->IncludeJS($script);
    }
}
$pdf = new PDF ('P','mm','A4');
$pdf->SetTitle('Tanda Terima',true);

$pdf->SetAutoPageBreak(true);
foreach ($data as $key => $value) {
    if($printer == 'dot matrix'){
        $value['lampiran']   = '';
        $pdf->setData($value);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->Data();
    }else{
        $lampiran = array(
            'COPY ',
            'ASLI',
        );
        foreach ($lampiran as $val) {
            $value['lampiran']   = $val;
            $pdf->setData($value);
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->Data();
        }
    }
}
// $pdf->AutoPrint(true);
$pdf->Output();

?>
