<?php



function rsha1($hash_source) {
                $hash = mhash (MHASH_SHA1, $hash_source);
                $hex_hash = bin2hex ($hash);
                return base64_encode ($hash);
//    return $hash_source;
        }

?>
