<?php

function generateUUIDv4() {
        // Menghasilkan 16 bytes (128 bits) acak
        $data = random_bytes(16);
    
        // Mengatur versi ke 4 (0100)
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    
        // Mengatur varian ke RFC 4122 (10xx)
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    
        // Format UUID ke string
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}