<?php 

class Messages {

    public static function render() {
        if (!isset($_SESSION['messages'])) {
            return null;
        } else {
            $html = "";
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
            $html .= "<div class='message'>";
            $html .=    implode('<br/>', $messages);
            $html .= "</div>";
            echo $html;
        }
    }

    public static function add($message) {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = array();
        }
        $_SESSION['messages'][] = $message;
    }

}