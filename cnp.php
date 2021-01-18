<?php
/*
 * Test Tehnic
 * Validare CNP 
 *
 */
$p_cnp=readline("Introdu CNP: ");
print(validareCNP($p_cnp));
function validareCNP($p_cnp) {
    if(strlen($p_cnp) != 13) {
        return print("CNP-ul trebuie sa contina 13 cifre");
    }
    $cnp = str_split($p_cnp);
    unset($p_cnp);
    $hashTable = array( 2 , 7 , 9 , 1 , 4 , 6 , 3 , 5 , 8 , 2 , 7 , 9 );
    $cifradecontrol = 0;
    // Toate caracterele trebuie sa fie cifre
    for($i=0 ; $i<13 ; $i++) {
        if(!is_numeric($cnp[$i])) {
            return print("CNP-ul trebuie sa contina doar cifre");
        }
        $cnp[$i] = (int)$cnp[$i];
        if($i < 12) {
            $cifradecontrol += (int)$cnp[$i] * (int)$hashTable[$i];
        }
    }
    unset($hashTable, $i);
    $cifradecontrol = $cifradecontrol % 11;
    if($cifradecontrol == 10) {
        $cifradecontrol = 1;
    }
    // Verificam anul
    $year = ($cnp[1] * 10) + $cnp[2];
    switch( $cnp[0] ) {
        case 1  : case 2 : { $year += 1900; } break; // cetateni romani nascuti intre 1 ian 1900 si 31 dec 1999
        case 3  : case 4 : { $year += 1800; } break; // cetateni romani nascuti intre 1 ian 1800 si 31 dec 1899
        case 5  : case 6 : { $year += 2000; } break; // cetateni romani nascuti intre 1 ian 2000 si 31 dec 2099
        case 7  : case 8 : case 9 : {                // rezidenti si Cetateni Straini
            $year += 2000;
            if($year > (int)date('Y')-14) {
                $year -= 100;
            }
        } break;
        default : {
            return print("CNP invalid, prima cifra nu poate fi zero");
        } break;
    }
    $day=($cnp[5]*10)+$cnp[6];
    $jud=($cnp[7]*10)+$cnp[8];

    if($year > 1800 && $year < 2099 && $day > 0 && $day < 32 && $jud > 0 && $jud < 54 && $cnp[12] == $cifradecontrol)
    {return print("CNP valid");}
    else {print("CNP invalid");}
}
?>