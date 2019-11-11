<?php
namespace app\widgets;

Use app\itbz\fpdf\src\fpdf\fpdf;

/**
 * fpdf extended are fpdf library with additional method (rotate watermark, GetMultiCellHeight, bulan, terbilang, kekata etc)
 *
 * @author Heru Arief Wijaya <heru@belajararief.com>
 */
class FpdfExtended extends  \fpdf\FPDF
{
    /**
     * rotated text
     * to create rotatedtext in pdf header like a watermark
     * example use below
     * function Header(){
     * // masukkan watermark apabila kd_sah == 0
     * IF($this->model->kd_sah == 0){
     *      //Put the watermark
     *      $this->SetFont('Arial','B',50);
     *      $this->SetTextColor(163,163,163);
     *      $this->RotatedText(120,170,'DRAFT USULAN',45);
     * }        
    }
     */
    var $angle=0;

    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }

    function _endpage()
    {
        if($this->angle!=0)
        {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }

    /**
     * bulan dan terbilang
     * to create bulan and terbilan usually uses in Laporan
     *  
     */

    function bulan($bulan){
        Switch ($bulan){
            case 1 : $bulan="Januari";
                Break;
            case 2 : $bulan="Februari";
                Break;
            case 3 : $bulan="Maret";
                Break;
            case 4 : $bulan="April";
                Break;
            case 5 : $bulan="Mei";
                Break;
            case 6 : $bulan="Juni";
                Break;
            case 7 : $bulan="Juli";
                Break;
            case 8 : $bulan="Agustus";
                Break;
            case 9 : $bulan="September";
                Break;
            case 10 : $bulan="Oktober";
                Break;
            case 11 : $bulan="November";
                Break;
            case 12 : $bulan="Desember";
                Break;
            }
        return $bulan;
    }

    function convertHariIndonesia($tanggal){
        $hariArray = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
        return $hariArray[date('N', strtotime($tanggal))];
    }
    
    
    function kekata($x) {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x <12) {
            $temp = " ". $angka[$x];
        } else if ($x <20) {
            $temp = $this->kekata($x - 10). " belas";
        } else if ($x <100) {
            $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
        } else if ($x <200) {
            $temp = " seratus" . $this->kekata($x - 100);
        } else if ($x <1000) {
            $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
        } else if ($x <2000) {
            $temp = " seribu" . $this->kekata($x - 1000);
        } else if ($x <1000000) {
            $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
        } else if ($x <1000000000) {
            $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
        } else if ($x <1000000000000) {
            $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
        } else if ($x <1000000000000000) {
            $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
        }     
            return $temp;
    }

    function terbilang($x, $style=4) {
        if($x<0) {
            $hasil = "minus ". trim($this->$this->kekata($x));
        } else {
            $hasil = trim($this->$this->kekata($x));
        }     
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }     
        return $hasil;
    }     

    /**
     * getMultiCellHeight to get height of a multicell before render it
     * @param w is width of multicell
     * @param h is height of multicell row
     * @param txt is string text to render
     * @param border is border applied or not (BTLR) default to null
     * @param align is align of text (J, L, R) default to J
     */
    public function GetMultiCellHeight($w, $h, $txt, $border=null, $align='J') {
        // Calculate MultiCell with automatic or explicit line breaks height
        // $border is un-used, but I kept it in the parameters to keep the call
        //   to this function consistent with MultiCell()
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $height = 0;
        while($i<$nb)
        {
            // Get next character
            $c = $s[$i];
            if($c=="\n")
            {
                // Explicit line break
                if($this->ws>0)
                {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                //Increase Height
                $height += $h;
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                continue;
            }
            if($c==' ')
            {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if($l>$wmax)
            {
                // Automatic line break
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    if($this->ws>0)
                    {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    //Increase Height
                    $height += $h;
                }
                else
                {
                    if($align=='J')
                    {
                        $this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                        $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                    }
                    //Increase Height
                    $height += $h;
                    $i = $sep+1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
            }
            else
                $i++;
        }
        // Last chunk
        if($this->ws>0)
        {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        //Increase Height
        $height += $h;
    
        return $height;
    }

    /**
     * Draws text within a box defined by width = w, height = h, and aligns
     * the text vertically within the box ($valign = M/B/T for middle, bottom, or top)
     * Also, aligns the text horizontally ($align = L/C/R/J for left, centered, right or justified)
     * drawTextBox uses drawRows
     *
     * This function is provided by TUFaT.com
     */
    function drawTextBox($strText, $w, $h, $align='L', $valign='T', $border=true)
    {
        $xi=$this->GetX();
        $yi=$this->GetY();
        
        $hrow=$this->FontSize;
        $textrows=$this->drawRows($w,$hrow,$strText,0,$align,0,0,0);
        $maxrows=floor($h/$this->FontSize);
        $rows=min($textrows,$maxrows);

        $dy=0;
        if (strtoupper($valign)=='M')
            $dy=($h-$rows*$this->FontSize)/2;
        if (strtoupper($valign)=='B')
            $dy=$h-$rows*$this->FontSize;

        $this->SetY($yi+$dy);
        $this->SetX($xi);

        $this->drawRows($w,$hrow,$strText,0,$align,false,$rows,1);

        if ($border)
            $this->Rect($xi,$yi,$w,$h);
    }

    function drawRows($w, $h, $txt, $border=0, $align='J', $fill=false, $maxline=0, $prn=0)
    {
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $b=0;
        if($border)
        {
            if($border==1)
            {
                $border='LTRB';
                $b='LRT';
                $b2='LR';
            }
            else
            {
                $b2='';
                if(is_int(strpos($border,'L')))
                    $b2.='L';
                if(is_int(strpos($border,'R')))
                    $b2.='R';
                $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
            }
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $ns=0;
        $nl=1;
        while($i<$nb)
        {
            //Get next character
            $c=$s[$i];
            if($c=="\n")
            {
                //Explicit line break
                if($this->ws>0)
                {
                    $this->ws=0;
                    if ($prn==1) $this->_out('0 Tw');
                }
                if ($prn==1) {
                    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                }
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                if ( $maxline && $nl > $maxline )
                    return substr($s,$i);
                continue;
            }
            if($c==' ')
            {
                $sep=$i;
                $ls=$l;
                $ns++;
            }
            $l+=$cw[$c];
            if($l>$wmax)
            {
                //Automatic line break
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    if($this->ws>0)
                    {
                        $this->ws=0;
                        if ($prn==1) $this->_out('0 Tw');
                    }
                    if ($prn==1) {
                        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                    }
                }
                else
                {
                    if($align=='J')
                    {
                        $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                        if ($prn==1) $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                    }
                    if ($prn==1){
                        $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                    }
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                if ( $maxline && $nl > $maxline )
                    return substr($s,$i);
            }
            else
                $i++;
        }
        //Last chunk
        if($this->ws>0)
        {
            $this->ws=0;
            if ($prn==1) $this->_out('0 Tw');
        }
        if($border && is_int(strpos($border,'B')))
            $b.='B';
        if ($prn==1) {
            $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
        }
        $this->x=$this->lMargin;
        return $nl;
    }        

    /**
     * create a paragraph text
     * will return paragraph without rendering it
     * you can get how many lines this text will take 
     * $textLines = $pdf->WordWrap($text, $maxWidth); // output for example 8
     * @param string $text
     * @param int $maxWidth
     */
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

    /**
     * Membuat tanggal terbilang
     * @param date $tanggal
     * @param int $format, terdiri dari seperti di bawah ini
     * Format:
     * ---- 1 => 20 Mei 2019
     * ---- 2 => Selasa, 20 Mei 2019
     * ---- 3 => tanggal 10 bulan Mei Tahun 2019
     * ---- 4 => tanggal sepuluh bulan mei tahun dua ribu sembilan belas
     */
    public function tanggalTerbilang($tanggal, $format){
        switch ($format) {
            case 1:
                return date("d", strtotime($tanggal))." ".$this->bulan(date('m', strtotime($tanggal)))." ".date('Y', strtotime($tanggal));
                break;
            case 2:
                return ucwords($this->convertHariIndonesia($tanggal)).", ".date("d", strtotime($tanggal))." ".$this->bulan(date('m', strtotime($tanggal)))." ".date('Y', strtotime($tanggal));
                break;
            
            default:
                # code...
                break;
        }
    }
}
