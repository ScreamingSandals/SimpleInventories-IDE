<?php

if (isset($_GET["service"])) {
    if ($_GET["service"] == "groovyPreProcessor") {
        if (isset($_POST['groovyContent'])) {
            $content = base64_decode($_POST['groovyContent']);
            $path_input = tempnam(sys_get_temp_dir(), 'groovypreprocessor_input');
            file_put_contents($path_input, $content);

            $path_output = tempnam(sys_get_temp_dir(), 'groovypreprocessor_output');

            shell_exec('cd ' . __DIR__ . '/groovy-preprocessor/ && java -jar build/libs/$(cd build/libs && ls | grep \'groovy\-.*\-all\.jar\') ' . $path_input . ' ' . $path_output);

            header('Content-Type: application/json');
            echo file_get_contents($path_output);
        }
    }
}
