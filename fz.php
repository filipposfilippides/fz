<?php
$file="matrix.csv";
$csv= file_get_contents($file);
$array0 = array_map("str_getcsv", explode("\n", $csv));
$file="article.txt";
$article= file_get_contents($file);
$outp="FZTen;";
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
