<!-- ?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$mLetter->header;

?-->

    {{-- echo "<hr>", --}}
    {{-- $mLetter->title, --}}
<?= 
    $mLetter->header.
    $mLetter->body.
    $mLetter->footer;
?>