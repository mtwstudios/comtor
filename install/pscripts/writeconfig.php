<?php

// try writing the config file, and return any errors
$filename = "config.php";
echo "writeconfig pscript";

    if ($fp = fopen($filename, 'w'))
    {
        if (fwrite($fp, "<?php\n")===FALSE)
        {
            $errors = 1;
            $errortext = "Cannot write to the file!";
        }
        foreach ($_SESSION['toconfig'] as $key => $value)
            fwrite($fp, '$'.$key.' = "'.$value.'";'."\n");
        fwrite($fp, "?>\n");
        fclose($fp);
    }
    else
    {
        $errors = 1;
        $errortext = "Could not open the file!";
    }

// the content of 'data.txt' is now 123 and not 23!


?>