<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fft
 *
 * @author snoblucha
 */
class Fft_Core {

 public function  FFT2D( $n,  $m, $inverse, &$gRe, &$gIm, &$GRe, &$GIm) {
    $l2n = 0; $p = 1; //l2n will become log_2(n)
    while($p < $n) {
        $p *= 2;
        $l2n++;
    }
    $l2m = 0;
    $p = 1; //l2m will become log_2(m)
    while($p < $m) {
        $p *= 2;
        $l2m++;
    }

    $m = 1 << $l2m;
    $n = 1 << $l2n; //Make sure m and n will be powers of 2, otherwise you'll get in an infinite loop

    //Erase all history of this array
    for($x = 0; $x < $m;    $x++) //for each column
    for($y = 0;$y < $m;$y++) //for each row
    for($c = 0; $c < 3;$c++) //for each color component
    {
        $GRe[3 * $m * $x + 3 * $y + $c] = $gRe[3 * $m * $x + 3 * $y + $c];
        $GIm[3 * $m * $x + 3 * $y + $c] = $gIm[3 * $m * $x + 3 * $y + $c];
    }

    //Bit reversal of each row
    $j;
    for($y = 0; $y < $m; $y++) //for each row
    for($c = 0;    $c < 3;   $c++) //for each color component
    {
        $j = 0;
        for($i = 0; $i < $n - 1; $i++) {
            $GRe[3 * $m * $i + 3 * $y + $c] = $gRe[3 * $m * $j + 3 * $y + $c];
            $GIm[3 * $m * $i + 3 * $y + $c] = $gIm[3 * $m * $j + 3 * $y + $c];
            $k = $n / 2;
            while ($k <= $j) {
                $j -= $k;
                $k /= 2;
            }
            $j += $k;
        }
    }
    //Bit reversal of each column
    $tx = 0; $ty = 0;
    for( $x = 0; $x < $n; $x++) //for each column
    for( $c = 0; $c < 3; $c++) //for each color component
    {
        $j = 0;
        for( $i = 0; $i < $m - 1; $i++) {
            if($i < $j) {
                $tx = $GRe[3 * $m * $x + 3 * $i + $c];
                $ty = $GIm[3 * $m * $x + 3 * $i + $c];
                $GRe[3 * $m * $x + 3 * $i + $c] = $GRe[3 * $m * $x + 3 * $j + $c];
                $GIm[3 * $m * $x + 3 * $i + $c] = $GIm[3 * $m * $x + 3 * $j + $c];
                $GRe[3 * $m * $x + 3 * $j + $c] = $tx;
                $GIm[3 * $m * $x + 3 * $j + $c] = $ty;
            }
            $k = $m / 2;
            while ($k <= $j) {
                $j -= $k;
                $k /= 2;
            }
            $j += $k;
        }
    }

    //Calculate the FFT of the columns
    for( $x = 0; $x < $n; $x++) //for each column
    for( $c = 0; $c < 3;  $c++) //for each color component
    {
        //This is the 1D FFT:
        $ca = -1.0;
        $sa = 0.0;
        $l1 = 1; $l2 = 1;
        for( $l=0; $l < $l2n; $l++) {
            $l1 = $l2;
            $l2 *= 2;
             $u1 = 1.0;
             $u2 = 0.0;
            for( $j = 0; $j < l1; $j++) {
                for( $i = $j; $i < $n;$i += $l2) {
                    $i1 = $i + $l1;
                    $t1 = $u1 * $GRe[3 * $m * $x + 3 * $i1 + $c] - $u2 * $GIm[3 * $m * $x + 3 * $i1 + $c];
                    $t2 = $u1 * $GIm[3 * $m * $x + 3 * $i1 + $c] + $u2 * $GRe[3 * $m * $x + 3 * $i1 + $c];
                    $GRe[3 * $m * $x + 3 * $i1 + $c] = $GRe[3 * $m * $x + 3 * $i + $c] - $t1;
                    $GIm[3 * $m * $x + 3 * $i1 + $c] = $GIm[3 * $m * $x + 3 * $i + $c] - $t2;
                    $GRe[3 * $m * $x + 3 * $i  + $c] += $t1;
                    $GIm[3 * $m * $x + 3 * $i  + $c] += $t2;
                }
                $z =  $u1 * $ca - $u2 * $sa;
                $u2 = $u1 * $sa + $u2 * $ca;
                $u1 = $z;
            }
            $sa = sqrt((1.0 - $ca) / 2.0);
            if(!$inverse) $sa = -$sa;
            $ca = sqrt((1.0 + $ca) / 2.0);
        }
    }

    //Calculate the FFT of the rows
    for(  $y = 0; $y < $m; $y++) //for each row
    for( $c = 0;    $c < 3;    $c++) //for each color component
    {
        //This is the 1D FFT:
        $ca = -1.0;
        $sa = 0.0;
        $l1= 1; $l2 = 1;
        for($l = 0; $l < $l2m; $l++) {
            $l1 = $l2;
            $l2 *= 2;
            $u1 = 1.0;
            $u2 = 0.0;
            for($j = 0;$j < l1;$j++) {
                for($i = $j;$i < $n;$i += $l2) {
                    $i1 = $i + $l1;
                    $t1 = $u1 * $GRe[3 * $m * $i1 + 3 * $y + $c] - $u2 * $GIm[3 * $m * $i1 + 3 * $y + $c];
                    $t2 = $u1 * $GIm[3 * $m * $i1 + 3 * $y + $c] + $u2 * $GRe[3 * $m * $i1 + 3 * $y + $c];
                    $GRe[3 * $m * $i1 + 3 * $y + $c] = $GRe[3 * $m * $i + 3 * $y + $c] - $t1;
                    $GIm[3 * $m * $i1 + 3 * $y + $c] = $GIm[3 * $m * $i + 3 * $y + $c] - $t2;
                    $GRe[3 * $m * $i + 3 * $y + $c] += $t1;
                    $GIm[3 * $m * $i + 3 * $y + $c] += $t2;
                }
                $z =  $u1 * $ca - $u2 * $sa;
                $u2 = $u1 * $sa + $u2 * $ca;
                $u1 = $z;
            }
            $sa = sqrt((1.0 - $ca) / 2.0);
            if(!$inverse) $sa = -$sa;
            $ca = $sqrt((1.0 + $ca) / 2.0);
        }
    }

    $d;
    if($inverse) $d = $n;
    else $d = $m;
    for($x = 0;$x < $n;$x++) for($y = 0;$y < $m;$y++) for($c = 0;$c < 3;$c++) //for every value of the buffers
    {
        $GRe[3 * $m * $x + 3 * $y + $c] /= $d;
        $GIm[3 * $m * $x + 3 * $y + $c] /= $d;
    }
}
}
?>
