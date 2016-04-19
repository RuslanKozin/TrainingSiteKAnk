<?php
$text = 'PHP рулит!';

if (preg_match('/PHP/', $text)) {
    $output = '$text содержит строку &ldquo;PHP&rdquo;.';
}
else {
    $output = '$text не содержит строку &ldquo;PHP&rdquo;.';
}
include 'output.html.php';