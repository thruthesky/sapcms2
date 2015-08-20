<?php
namespace sap\src;
class ErrorHandler {
    public function Run() {
        register_shutdown_function(array($this, 'shutdownFunction'));
        set_error_handler(array($this, 'errorHandler'));
    }




    public function errorHandler($errno, $errstr, $errfile, $errline) {

        while ( ob_get_clean() ) ;

        switch ($errno) {
            case E_USER_ERROR:
                $message = "<b>My ERROR</b> [$errno] $errstr<br />\n";
                $message .= "  Fatal error on line $errline in file $errfile";
                $message .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                $message .= "Aborting...<br />\n";
                break;

            case E_USER_WARNING:
                $message = "<b>My WARNING</b> [$errno] $errstr<br />\n";
                break;

            case E_USER_NOTICE:
                $message = "<b>My NOTICE</b> [$errno] $errstr<br />\n";
                break;

            default:
                $message = "Unknown error type: [$errno] $errstr<br />\n";
                break;
        }
        $this->showErrorBox($message);
        $this->showIncludedFiles();
        exit(1);
    }
    public function shutdownFunction() {

        $error = error_get_last();
        if ( empty($error) ) return;
        while ( ob_get_clean() ) ;



        $this->showErrorBox('<pre>' . $error['message'] .'</pre>');
        $this->showIncludedFiles();

    }

    public function showErrorBox($message) {
        echo "<div style='background-color:#740000;color:white;word-wrap: break-word;padding:1em; box-sizing: border-box; line-height:140%; font-size:120%;border-radius:2px;'>";
        echo $message;
        echo "</div>";
    }
    public function showIncludedFiles() {

        $files = array_reverse(get_included_files());

        echo "<h3>Included files</h3>";
        echo "<div style='background-color:#c5c3b3;color:black;word-wrap: break-word;padding:1em; box-sizing: border-box; line-height:140%; font-size:120%;border-radius:2px;'>";
        foreach( $files as $file ) {
            echo "<div>$file</div>";
        }

        echo "</div>";

    }

}
