
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
        $this->cell(0,6,'TANDA TERIMA - '.$this->header['kode_dokumen'],0,0,'C');
        $this->Ln(10);
        $this->setFont('Arial','',8);
        $this->cell(30,1,'Pengirim',0,0,'L');
        $this->cell(100,1,': '.$this->header['pengirim'],0,0,'L');
        $this->cell(25,1,'Nomor',0,0,'L');
        $this->cell(0,1,': '.$this->header['nomor_transaksi'],0,0,'L');
        $this->Ln(4);
        $this->cell(30,1,'Penerima',0,0,'L');
        $this->cell(100,1,': '.$this->header['penerima'],0,0,'L');
        $this->cell(25,1,'Tanggal',0,0,'L');
        $this->cell(0,1,': '.$this->header['tanggal'],0,0,'L');
        $this->Ln(4);
        $this->cell(30,1,'Tujuan',0,0,'L');
        $this->cell(100,1,': '.$this->header['tujuan'],0,0,'L');
        $this->Ln(4);
        $this->HeaderList();
    }

    function HeaderList(){
        $this->Ln(4);
        $this->Line(11,$this->GetY(),199,$this->GetY());
        $this->Ln(3);
        $this->cell(8,1,'NO.',0,0,'C');
        $this->cell(20,1,'KODE ',0,0,'L');
        $this->cell(2,1,'',0,0,'R');
        $this->cell(45,1,'NAMA BARANG',0,0,'L');
        $this->cell(30,1,'STATUS',0,0,'L');
        $this->cell(15,1,'QTY',0,0,'C');
        $this->cell(35,1,'KETERANGAN',0,0,'L');
        $this->Ln(3);
        $this->cell(40,1,'',0,0,'R');
        // $this->cell(10,1,'RUSAK',0,0,'C');
        $this->cell(175,1,'',0,0,'L');
        $this->Ln(4);
        $this->Line(11,$this->GetY(),199,$this->GetY());
        $this->Ln(4);
    }
    function Data(){
        $baris = 1;
        $urut = 1;
        // for ($ii=0; $ii < 12 ; $ii++) {
        foreach ($this->detail as $value) {
            if($baris==41){
                $this->FooterSubTotal();
                $this->AddPage();
                $baris = 1;
            }
            if($value['qty']!=0){

                $this->cell(8,1,$urut,0,0,'C');
                $this->cell(20,1,$value['kode_barang'],0,0,'L');
                $this->cell(2,1,'',0,0,'R');
                $this->cell(45,1,$value['nama_barang'],0,0,'L');
                $this->cell(30,1,$value['status_barang'],0,0,'L');
                $this->cell(15,1,$value['qty'],0,0,'C');
                $this->cell(35,1,$value['keterangan_barang'],0,0,'L');

                $this->grand_total += $value['qty'];
                $this->Ln(4);
                $baris++;
                $urut++;
            }
        }
        // }
        $this->jml_baris = $baris;

        $this->FooterTotal();

        $this->grand_total = 0;
    }

    function FooterTotal(){
        // Go to 1.5 cm from bottom
        // tesx($this->jml_baris);
        if($this->jml_baris <= 12){
            $this->SetY(-195);
        }else{
            $this->SetY(-75);
        }

        $this->Ln(4);
        $this->Line(11,$this->GetY(),200,$this->GetY());
        $this->Ln(4);
        $this->cell(18,1,'Keterangan :',0,0,'L');
        $this->cell(130,1,$this->header['keterangan'],0,0,'L');
        $this->cell(10,1,'Total ',0,0,'L');
        $this->cell(25,1,$this->grand_total,0,0,'R');
        $this->Ln(4);
        $this->Line(11,$this->GetY(),200,$this->GetY());
        $this->Ln(4);
        $this->cell(60,1,'Diterima Oleh,',0,0,'C');
        $this->cell(30,1,'',0,0,'C');
        $this->cell(40,1,'',0,0,'C');
        $this->cell(45,1,'Dikirim Oleh,',0,0,'C');
        $this->Ln(18);
        $this->cell(155,1,'',0,0,'C');
        $this->Ln(4);
        $this->cell(60,1,'('.$this->header['penerima'].')',0,0,'C');
        $this->cell(30,1,'',0,0,'C');
        $this->cell(40,1,'',0,0,'C');
        $this->cell(45,1,'('.$this->header['pengirim'].')',0,0,'C');
        $this->Ln(4);
        $this->Line(11,$this->GetY(),200,$this->GetY());
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
            'COPY 1 ',
            'Asli',
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
