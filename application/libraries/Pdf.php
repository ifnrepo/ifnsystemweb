<?php

include_once APPPATH . '/third_party/fpdf/fpdf.php';

class Pdf extends FPDF
{
    // function __construct() {
    // }

    // function Header()
    // {

    //     $this->Image(base_url() . 'assets/image/logodepanK.png', 0, 5, 55);


    //     $this->SetFont('Arial', 'I', 8);
    //     $this->Cell(0, 10, 'DATA BC MASUK', 0, 1, 'C');
    //     $this->Ln(8);

    //     $this->SetFont('Arial', 'I', 8); // Font untuk nomor halaman
    //     $this->SetY(14); // Atur kembali posisi Y
    //     $this->Cell(0, 10, 'Halaman: ' . $this->PageNo(), 0, 0, 'C'); // Nomor halaman di kanan atas
    //     $this->Ln(15);

    //     // sett lebar kolom
    //     $col_no = 10;
    //     $col_jenis = 12;
    //     $col_dokumen = 39;
    //     $col_penerimaan = 58;
    //     $col_pemasok = 80;
    //     $col_sat = 10;
    //     $col_jumlah = 21;
    //     $nilai_barang = 50;


    //     $this->Cell($col_no, 13, 'NO', 1, 0, 'C');
    //     $this->Cell($col_jenis, 13, 'JENIS', 1, 0, 'C');
    //     $this->Cell($col_dokumen, 6, 'DOKUMEN PABEAN', 1, 0, 'C');
    //     $this->Cell($col_penerimaan, 6, 'BUKTI PENERIMAAN BRG', 1, 0, 'C');
    //     $this->Cell($col_pemasok, 13, 'PEMASOK/PENGIRIM', 1, 0, 'C');
    //     $this->Cell($col_sat, 13, 'SAT', 1, 0, 'C');
    //     $this->Cell($col_jumlah, 13, 'JUMLAH', 1, 0, 'C');
    //     $this->Cell($nilai_barang, 6, 'NILAI BARANG', 1, 0, 'C');

    //     // Sub-header
    //     $this->SetXY(32, 35);
    //     $this->Cell(16, 7, 'NOMOR', 1, 0, 'C');
    //     $this->Cell(23, 7, 'TANGGAL', 1, 0, 'C');
    //     $this->Cell(35, 7, 'NOMOR', 1, 0, 'C');
    //     $this->Cell(23, 7, 'TANGGAL', 1, 0, 'C');
    //     $this->SetXY(240, 35);
    //     $this->Cell(27, 7, 'IDR', 1, 0, 'C');
    //     $this->Cell(23, 7, 'USD', 1, 0, 'C');
    //     $this->Ln(7);
    // }


    function Footer()
    {
        // //atur posisi 1.5 cm dari bawah
        // $this->SetY(-15);
        // //buat garis horizontal
        // $this->Line(10,$this->GetY(),200,$this->GetY());
        // //Arial italic 9
        // $this->SetFont('Arial','I',9);
        // //nomor halaman
        // // $this->Cell(0,10, $this->Image(base_url().'assets/images/sab/logoitalic1.png',10,$this->GetY()+2,15),0,0);
        // $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
    }
    function WordWrap(&$text, $maxwidth)
    {
        $text = trim($text);
        if ($text === '')
            return 0;
        $space = $this->GetStringWidth(' ');
        $lines = explode("\n", $text);
        $text = '';
        $count = 0;

        foreach ($lines as $line) {
            $words = preg_split('/ +/', $line);
            $width = 0;

            foreach ($words as $word) {
                $wordwidth = $this->GetStringWidth($word);
                if ($wordwidth > $maxwidth) {
                    // Word is too long, we cut it
                    for ($i = 0; $i < strlen($word); $i++) {
                        $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                        if ($width + $wordwidth <= $maxwidth) {
                            $width += $wordwidth;
                            $text .= substr($word, $i, 1);
                        } else {
                            $width = $wordwidth;
                            $text = rtrim($text) . "\n" . substr($word, $i, 1);
                            $count++;
                        }
                    }
                } elseif ($width + $wordwidth <= $maxwidth) {
                    $width += $wordwidth + $space;
                    $text .= $word . ' ';
                } else {
                    $width = $wordwidth + $space;
                    $text = rtrim($text) . "\n" . $word . ' ';
                    $count++;
                }
            }
            $text = rtrim($text) . "\n";
            $count++;
        }
        $text = rtrim($text);
        return $count;
    }
}

class PDF_Bcmasuk extends FPDF
{
    function Header()
    {
        $this->SetFont('Latob', '', 10);
        $this->Cell(0, 4, 'KAWASAN BERIKAT PT. INDONEPTUNE NET MANUFACTURING', 0, 1, 'L');
        $this->Cell(0, 4, 'LAPORAN PEMASUKAN BARANG PER DOKUMEN PABEAN', 0, 1, 'L');
        $this->Cell(0, 4, 'PERIODE: ' . $_SESSION['tglawal'] . ' S/D ' . $_SESSION['tglakhir'], 0, 1, 'L');
        $this->Ln(2);

        $this->SetFont('Latob', '', 8);
        $this->SetFillColor(220, 220, 220);
        $this->SetDrawColor(0, 0, 0);

        $y = $this->GetY();
        $this->Cell(6, 12, 'No', 1, 0, 'C', true);
        $this->Cell(10, 12, 'Jenis', 1, 0, 'C', true);
        $x_doc = $this->GetX();
        $this->Cell(25, 6, 'Dokumen Pabean', 1, 0, 'C', true);
        $this->SetXY($x_doc, $y + 6);
        $this->Cell(10, 6, 'Nomor', 1, 0, 'C', true);
        $this->Cell(15, 6, 'Tanggal', 1, 0, 'C', true);
        $this->SetXY($x_doc + 25, $y);

        $x_bukti = $this->GetX();
        $this->Cell(50, 6, 'Bukti Penerimaan Barang', 1, 0, 'C', true);
        $this->SetXY($x_bukti, $y + 6);
        $this->Cell(35, 6, 'Nomor', 1, 0, 'C', true);
        $this->Cell(15, 6, 'Tanggal', 1, 0, 'C', true);
        $this->SetXY($x_bukti + 50, $y);

        $this->Cell(45, 12, 'Pemasok/Pengirim', 1, 0, 'C', true);
        $this->Cell(13, 12, 'Kode', 1, 0, 'C', true);
        $this->Cell(70, 12, 'Nama Barang', 1, 0, 'C', true);
        $this->Cell(6, 12, 'Sat', 1, 0, 'C', true);
        $this->Cell(12, 12, 'Jum', 1, 0, 'C', true);
        $this->Cell(10, 12, 'Kgs', 1, 0, 'C', true);
        $this->Cell(18, 12, 'Nilai (IDR)', 1, 0, 'C', true);
        $this->Cell(15, 12, 'Nilai (USD)', 1, 1, 'C', true);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Lato', '', 7);
        $this->SetTextColor(100, 100, 100);

        $this->Cell(0, 5, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }


    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}
class PDF_Bckeluar extends FPDF
{
    function Header()
    {
        $this->SetFont('Latob', '', 10);
        $this->Cell(0, 4, 'KAWASAN BERIKAT PT. INDONEPTUNE NET MANUFACTURING', 0, 1, 'L');
        $this->Cell(0, 4, 'LAPORAN PEMASUKAN BARANG PER DOKUMEN PABEAN', 0, 1, 'L');
        $this->Cell(0, 4, 'PERIODE: ' . $_SESSION['tglawal'] . ' S/D ' . $_SESSION['tglakhir'], 0, 1, 'L');
        $this->Ln(2);

        $this->SetFont('Latob', '', 8);
        $this->SetFillColor(220, 220, 220);
        $this->SetDrawColor(0, 0, 0);

        $y = $this->GetY();

        $this->Cell(6, 12, 'No', 1, 0, 'C', true);
        $this->Cell(10, 12, 'Jenis', 1, 0, 'C', true);
        $x_doc = $this->GetX();
        $this->Cell(25, 6, 'Dokumen Pabean', 1, 0, 'C', true);
        $this->SetXY($x_doc, $y + 6);
        $this->Cell(10, 6, 'Nomor', 1, 0, 'C', true);
        $this->Cell(15, 6, 'Tanggal', 1, 0, 'C', true);
        $this->SetXY($x_doc + 25, $y);

        $x_bukti = $this->GetX();
        $this->Cell(42, 6, 'Bukti Penerimaan Barang', 1, 0, 'C', true);
        $this->SetXY($x_bukti, $y + 6);
        $this->Cell(27, 6, 'Nomor', 1, 0, 'C', true);
        $this->Cell(15, 6, 'Tanggal', 1, 0, 'C', true);
        $this->SetXY($x_bukti + 42, $y);
        $this->Cell(43, 12, 'Customer', 1, 0, 'C', true);
        $this->Cell(13, 12, 'Kode', 1, 0, 'C', true);
        $this->Cell(70, 12, 'Nama Barang', 1, 0, 'C', true);
        $this->Cell(8, 12, 'Sat', 1, 0, 'C', true);
        $this->Cell(12, 12, 'Jum', 1, 0, 'C', true);
        $this->Cell(12, 12, 'Kgs', 1, 0, 'C', true);
        $this->Cell(27, 12, 'Nilai (IDR)', 1, 0, 'C', true);
        $this->Cell(15, 12, 'Nilai (USD)', 1, 1, 'C', true);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Lato', '', 7);
        $this->SetTextColor(100, 100, 100);

        $this->Cell(0, 5, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function NbLines($w, $txt)
    {

        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}

class PDF_Kontrak extends FPDF
{
    protected $headerData;
    public $showHeader = true;

    public function setHeaderData($data)
    {
        $this->headerData = $data;
    }


    function Header()
    {

        if (!$this->showHeader) return;

        $header = $this->headerData;


        if ($this->PageNo() == 1) {
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 6, 'REALISASI PENGELUARAN SEMENTARA DAN PEMASUKAN KEMBALI BARANG IMPOR ATAS KEGIATAN DARI/KE TLDPP', 0, 1, 'C');
            $this->Cell(0, 6, 'UNTUK PENGEMBALIAN JAMINAN', 0, 1, 'C');
            $this->Ln(4);

            $this->SetFont('Arial', '', 8);
            $this->Cell(90, 5, '', 0, 0);
            $this->Cell(40, 5, 'Nama Perusahaan', 0, 0, 'R');
            $this->Cell(5, 5, ':', 0, 0, 'C');
            $this->Cell(60, 5, 'PT. INDONEPTUNE NET MANUFACTURING', 0, 1, 'L');

            $this->Cell(90, 5, '', 0, 0);
            $this->Cell(40, 5, 'Nomor Surat Persetujuan', 0, 0, 'R');
            $this->Cell(5, 5, ':', 0, 0, 'C');
            $this->Cell(60, 5, $header['nomor_kep'], 0, 1, 'L');

            $this->Cell(90, 5, '', 0, 0);
            $this->Cell(40, 5, 'Tanggal Surat Persetujuan', 0, 0, 'R');
            $this->Cell(5, 5, ':', 0, 0, 'C');
            $this->Cell(60, 5, tanggal_indonesia($header['tgl_kep']), 0, 1, 'L');

            $this->Cell(90, 5, '', 0, 0);
            $this->Cell(40, 5, 'Nomor BPJ', 0, 0, 'R');
            $this->Cell(5, 5, ':', 0, 0, 'C');
            $this->Cell(60, 5, $header['nomor_bpj'], 0, 1, 'L');

            $this->Cell(90, 5, '', 0, 0);
            $this->Cell(40, 5, 'Jatuh Tempo Jaminan', 0, 0, 'R');
            $this->Cell(5, 5, ':', 0, 0, 'C');
            $this->Cell(60, 5, tanggal_indonesia($header['tgl_expired']), 0, 1, 'L');
            $this->Ln(5);
        }


        $this->SetFont('Arial', 'B', 8);
        $this->Cell(130, 5, 'PENGELUARAN SEMENTARA', 0, 0, 'L');
        $this->Cell(11, 5, '', 0, 0);
        $this->Cell(130, 5, 'PEMASUKAN KEMBALI', 0, 1, 'L');

        $headerCols = ['No', 'No Dok', 'Tgl Dok', 'SKU', 'Uraian Barang', 'PCS', 'KGS'];
        $widths = [5, 12, 15, 20, 60, 12, 13];

        $this->SetFont('Arial', 'B', 7);
        foreach ($headerCols as $i => $col) $this->Cell($widths[$i], 6, $col, 1, 0, 'C');
        $this->Cell(5, 6, '', 0, 0);
        foreach ($headerCols as $i => $col) $this->Cell($widths[$i], 6, $col, 1, 0, 'C');
        $this->Ln();
    }

    function Footer()
    {

        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}
