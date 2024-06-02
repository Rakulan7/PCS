<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once __DIR__ . "/libraries/path.php";
require_once __DIR__ . "/libraries/method.php";


//Voyageurs
if (isPath("/voyageurs")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/voyageurs/get.php";
        die();
    }

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/voyageurs/post.php";
        die();
    }
}

if (isPath("/voyageurs/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/voyageurs/:id/get.php";
        die();
    }

    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/voyageurs/:id/delete.php";
        die();
    }

    if (isUpdateMethod()) {  
        require_once __DIR__ . "/routes/voyageurs/:id/update.php";
        die();
    }
}


//Bailleurs
if (isPath("/bailleurs")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/bailleurs/get.php";
        die();
    }

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/bailleurs/post.php";
        die();
    }
}

if (isPath("/bailleurs/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/bailleurs/:id/get.php";
        die();
    }

    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/bailleurs/:id/delete.php";
        die();
    }

    if (isUpdateMethod()) {  
        require_once __DIR__ . "/routes/bailleurs/:id/update.php";
        die();
    }
}


//Prestataires
if (isPath("/prestataires")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/prestataires/get.php";
        die();
    }

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/prestataires/post.php";
        die();
    }
}

if (isPath("/prestataires/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/prestataires/:id/get.php";
        die();
    }

    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/prestataires/:id/delete.php";
        die();
    }

    if (isUpdateMethod()) {  
        require_once __DIR__ . "/routes/prestataires/:id/update.php";
        die();
    }
}


//Prestations
if (isPath("/prestations")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/prestations/get.php";
        die();
    }

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/prestations/post.php";
        die();
    }
}

if (isPath("/prestations/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/prestations/:id/get.php";
        die();
    }

    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/prestations/:id/delete.php";
        die();
    }

    if (isUpdateMethod()) {  
        require_once __DIR__ . "/routes/prestations/:id/update.php";
        die();
    }
}


//Biens
if (isPath("/biens")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/get.php";
        die();
    }

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/biens/post.php";
        die();
    }
}

if (isPath("/biens/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/:id/get.php";
        die();
    }

    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/biens/:id/delete.php";
        die();
    }

    if (isUpdateMethod()) {  
        require_once __DIR__ . "/routes/biens/:id/update.php";
        die();
    }
}


//Occupations
if (isPath("/occupations")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/occupations/get.php";
        die();
    }

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/occupations/post.php";
        die();
    }
}

if (isPath("/occupations/:id")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/occupations/:id/get.php";
        die();
    }

    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/occupations/:id/delete.php";
        die();
    }

    if (isUpdateMethod()) {  
        require_once __DIR__ . "/routes/occupations/:id/update.php";
        die();
    }
}


require_once __DIR__ . "/routes/all.php";
