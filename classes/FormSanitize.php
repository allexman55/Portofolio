<?php
class FormSanitize{
    public static function sanitizeText($input){
        strip_tags($input);
        str_replace(" ", "", $input);
        return $input;
    }
    public static function sanitizePwd($input){
        strip_tags($input);
        return $input;
    }
}


?>