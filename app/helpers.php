<?php

function inputValidationClass(\Illuminate\Support\ViewErrorBag $errorBag, $fieldName) {
    if($errorBag->count() === 0)
        return ""; //no errors at all, no request sent

    $messages = $errorBag->getMessages();
    if(isset($messages[$fieldName]) && count($messages[$fieldName]) > 0)
        return "is-invalid";

    if(!isset($messages[$fieldName]) || count($messages[$fieldName]) == 0)
        return "is-valid";

    return "";
}

function inputValidationMessages(\Illuminate\Support\ViewErrorBag $errorBag, $fieldName) {
    $class = inputValidationClass($errorBag, $fieldName);
    if($class === "is-invalid") {
        $messages = $errorBag->getMessages();
        if(isset($messages[$fieldName])) {
            return new \Illuminate\Support\HtmlString(implode("<br>", $messages[$fieldName]));
        }
    }
    return "";
}