<?php

for ($i = 0; $i < 7; $i++) { // perulangan sebanyak 7 
    for ($j = 0; $j < 7; $j++) { 
        if ($j == $i || $j == 7 - $i - 1) { 
            echo "x ";
        } else {
            echo "o ";
        }
    }
    echo PHP_EOL; // baris baru
}
