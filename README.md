# fz
article compression method Fz
## Target: 
to better compress articles
## Method: 
using Zipf law
## Name: 
Fz ( my proposal is the file extension to be fzt )
Description: In an article, the 128 most common words represents about the half of the article.
If we represent these words and their trailing space, with a number 0-127 in ascii text or 0-32767 in utf8 and a marker then we will save a lot of space for other compression methods.
## Header: 
In the header we should refer the text language.
## Example:

    Alice was published in 1865, three years after Charles Lutwidge Dodgson and the Reverend Robinson Duckworth rowed a boat up the Isis on 4 July 1862[3] (this popular date of the "golden afternoon"[4] might be a confusion or even another Alice-tale, for that particular day was cool, cloudy, and rainy[5]) with the three young daughters of Henry Liddell (the Vice-Chancellor of Oxford University and Dean of Christ Church): Lorina Charlotte Liddell (aged 13, born 1849, "Prima" in the book's prefatory verse); Alice Pleasance Liddell (aged 10, born 1852, "Secunda" in the prefatory verse); Edith Mary Liddell (aged 8, born 1853, "Tertia" in the prefatory verse).[6]

    The journey began at Folly Bridge in Oxford and ended 3 miles (5 km) north-west in the village of Godstow. During the trip, Dodgson told the girls a story that featured a bored little girl named Alice who goes looking for an adventure. The girls loved it, and Alice Liddell asked Dodgson to write it down for her. He began writing the manuscript of the story the next day, although that earliest version no longer exists. The girls and Dodgson took another boat trip a month later when he elaborated the plot to the story of Alice, and in November he began working on the manuscript in earnest.[7]

    To add the finishing touches, he researched natural history for the animals presented in the book, and then had the book examined by other children—particularly the children of George MacDonald. He added his own illustrations but approached John Tenniel to illustrate the book for publication, telling him that the story had been well liked by children.[7]

    On 26 November 1864, he gave Alice the handwritten manuscript of Alice's Adventures Under Ground, with illustrations by Dodgson himself, dedicating it as "A Christmas Gift to a Dear Child in Memory of a Summer's Day".[8] Some, including Martin Gardner, speculate that there was an earlier version that was destroyed later by Dodgson when he wrote a more elaborate copy by hand.[9]

    But before Alice received her copy, Dodgson was already preparing it for publication and expanding the 15,500-word original to 27,500 words,[10] most notably adding the episodes about the Cheshire Cat and the Mad Tea-Party.


## Summary:
The text above, extracted from Wikipedia article, in ascii was 2230 characters long and after 7z LZMA compression 1327 chars.
After Fz, the text is now 2106 characters long and after 7z LZMA compression is 1288 chars.
So, Fz compression is about 5.56% more efficient when comes to text and 2.94% better when used in 7z LZMA.

## Program in PHP: 
(matrix.csv constructed using the table in http://world-english.org/english500.htm using only 128 words in an array)

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


## License GNU/GPL3 :

Copyright (C) 2017  Filippos Filippides

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see \http://www.gnu.org/licenses/\.
