<?php

/**
 * Return true if the given path is valid. This check corelates to the safe_exec()
 * function in the function.save_exec.php. Paths can be put in strings which can
 * be executed on the commandline. So the constraints for the $exec_string are also
 * valid for the paths.
 *
 * @author Aaron Mueller <aaron.mueller@nitrado.net>
 * @version 0.1
 * @param string a pathname
 * @return boolean true if there is no special char in it
 */
function validatePath($localPath, $field='path')
{
    $badChars = array(';', '|', '&', '>', '<', '`', '$', '~', '?');
    $cleanedPath = validate($localPath, $field);

    foreach($badChars as $badChar)
        $cleanedPath = str_replace($badChar, '', $cleanedPath);

    return $cleanedPath;
}
