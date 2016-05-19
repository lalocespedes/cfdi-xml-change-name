<?php

require_once('./vendor/autoload.php');

$dir_list_root = '/Users/arthaleon/lalocespedes/sat/xml/AAA010101AAA/';

$newdest = '';

function debug_dir_list($dir_recurse_depth = 0, $dir_list_root = '.' ) {

    // Create a recursive file system directory iterator.
    $dir_iter = new RecursiveDirectoryIterator(
        $dir_list_root,
        RecursiveDirectoryIterator::SKIP_DOTS // Skips dot files (. and ..)
    );

    // Create a recursive iterator.
    $iter = new RecursiveIteratorIterator(
        $dir_iter,
        RecursiveIteratorIterator::SELF_FIRST, // Lists leaves and parents in iteration with parents coming first.
        RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore exceptions such as "Permission denied"
    );

    // The maximum recursive path.
    $iter->setMaxDepth($dir_recurse_depth);

    // List of paths Include current paths
    $path = array($dir_list_root);

    foreach ($iter as $path => $dir) {
        if ($dir_recurse_depth == 0 && $dir->isDir()) $path .= "/";
        $paths[] = $path;
    }

    return $paths;
}

$items = debug_dir_list(0, $dir_list_root);

$i = 0;

foreach($items as $item) {

   $ext = substr(strrchr($item,'.'),1);

    if($ext === 'xml') {

        $i++;

        $parser = new lalocespedes\CfdiMx\Parser($item);

        $data = $parser->jsonSerialize();

        $newname = $data['Comprobante']['Complemento']['TimbreFiscalDigital']['@atributos']['UUID'] . '.xml';

        rename($item, $dir_list_root . $newname);

        echo $i . ' done ' . $item . '<br>';

    }

}
