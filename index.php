<?php
    require_once("config.php");

    function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return false;
        }
    
        if (!is_dir($dir)) {
            return unlink($dir);
        }
    
        $items = scandir($dir);
    
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $item;
    
            if (is_dir($path)) {
                deleteDirectory($path);
            } else {
                unlink($path);
            }
        }
    
        return rmdir($dir);
    }

    unset($argv[0]);

    if(is_dir($outFolderName)) {
        deleteDirectory(getcwd() . DIRECTORY_SEPARATOR . $outFolderName);
    };

    mkdir($outFolderName);

    $result = shell_exec("cd " . $outFolderName . "&&" . "rm -rf .git" . "&&" . "git init");

    chdir($outFolderName);

    $file = fopen("test.txt", "w");

    for($i = 0 ; $i < $commitCount ; $i++){
        fwrite($file, "\n" . $i);
        $random1 = rand(0, 60);
        $random2 = rand(0, 60);
        $random3 = rand(0, 12);
        $random4 = rand(0, 12);
        $random5 = rand(0, 12);
        $random6 = rand(0, 3);
        $result = shell_exec("git add ." . "&&" . "git commit --date '$year-$random6$random4-$random6$random5"."T"."$random3:$random2:$random1' -m 'commit $i'");
        echo $result;
    }

    fclose($file);

    if($autoConnect){
        $result = shell_exec("git branch -M main && git remote add origin $repo && git push origin main -f");
    }

    print_r($result);
?>