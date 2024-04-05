<?php

include_once APPPATH . '/third_party/fpdf/fpdf.php';

class Pdf extends FPDF {
    // function __construct() {
    // }

    function Header()
    {
        // Logo
        // // $this->Image(base_url().'assets/image/logokertas.png',15,18,30);
        // // Arial bold 15
    }

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
        if ($text==='')
            return 0;
        $space = $this->GetStringWidth(' ');
        $lines = explode("\n", $text);
        $text = '';
        $count = 0;

        foreach ($lines as $line)
        {
            $words = preg_split('/ +/', $line);
            $width = 0;

            foreach ($words as $word)
            {
                $wordwidth = $this->GetStringWidth($word);
                if ($wordwidth > $maxwidth)
                {
                    // Word is too long, we cut it
                    for($i=0; $i<strlen($word); $i++)
                    {
                        $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                        if($width + $wordwidth <= $maxwidth)
                        {
                            $width += $wordwidth;
                            $text .= substr($word, $i, 1);
                        }
                        else
                        {
                            $width = $wordwidth;
                            $text = rtrim($text)."\n".substr($word, $i, 1);
                            $count++;
                        }
                    }
                }
                elseif($width + $wordwidth <= $maxwidth)
                {
                    $width += $wordwidth + $space;
                    $text .= $word.' ';
                }
                else
                {
                    $width = $wordwidth + $space;
                    $text = rtrim($text)."\n".$word.' ';
                    $count++;
                }
            }
            $text = rtrim($text)."\n";
            $count++;
        }
        $text = rtrim($text);
        return $count;
    }
}
?>