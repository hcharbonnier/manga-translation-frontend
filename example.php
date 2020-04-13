<?php
require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

$trans=new MangaImage($argv[1]);
$trans->detect_block();

// $trans->get_blocks(); // array

// $trans->add_block($x1,$y1,$x2,$y2,$x3,$y3,$x4,$y4);

//$trans->get_block_translation(int $id);
//$trans->get_block_ocr(int $id);

//to be call BEFORE translate() !!
//$trans->set_block_translation(6,"Translated text");

//$trans->set_cleaned_raw("toto_clean.jpg");


$trans->merge_near_block();
$trans->ocr();
$trans->translate();
$trans->clean_raw();

$trans-> write_translation();

$trans->export($argv[2],90);