<?php
$s='God Loves You';
echo 'Length of the string is: '.strlen($s).'<br>';
echo 'Reversed string is:   '.strrev($s).'<br>';
echo 'Lower string is:	   '.strtolower($s).'<br>';
echo 'Upper string is:      '.strtoupper($s).'<br>';
echo 'Splitted string is:   ';
print_r(str_split($s,3));
echo '<br>';
echo 'Word count is: ';
 print_r(str_word_count($s));

?>