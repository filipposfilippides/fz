<?php
/*
# Compressing / Decompressing articles using Zipf law
# 
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses>.
*/
/* 
Usage: fz --{compress|decompress} [--dictionary dictionary] filename
dictionary is a 2 column csv file. See matrix.csv

Work to come:
a) Compression: input a text file and ouput a fzt one according to usage
b) Decompression: decompress a file to its original state (read first 5 characters 
and extract the text language
c) fz should be used as a pipe 
d) Localize to specific languages by providing an appropriate matrix.csv dictionary
e) translate it to other more appropriate programming languages as C/C++ for better performance
*/
$language="en";
$file="matrix.csv";
$csv= file_get_contents($file);
$array0 = array_map("str_getcsv", explode("\n", $csv));
$file="article.txt";
$article= file_get_contents($file);
$outp="FZ${language}T";
foreach (explode("\n", $article) as $keya => $vala ) {
  $array=preg_split('/[\s,]+/',$vala);
  foreach ( $array as $key => $val ) {
    $found=false;
    foreach ( $array0 as $key0 => $val0 ) {
        $pval=$val;
        $repl='/\b'.$val0[0].'\b/u';
        $nv=preg_replace($repl, $key0, $val );
        if($nv != $pval) {
            $outp.= "#".chr($nv);
            $found=true;
            break;
            }
    }
    if(!$found) $outp.= $val;
    $outp.=" ";
  }
  $outp.="\n";
}
$outfile="article.fzt";
file_put_contents($outfile, $outp);
?>
