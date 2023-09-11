<?php

const FILES_PATH = __DIR__ . "/../public/";
const TEMPLATE_PATH = __DIR__ . "/../views/";
const IMAGE_FILE_PATH = "img/";
const UPLOAD_ALLOWED_EXTENSIONS = ["image/jpeg", "image/png", "image/gif"];
const MESSAGE_DEFAULT = "default";
const MESSAGE_ERROR = "error";
const MESSAGE_WARNING = "warning";
const MESSAGE_SUCCESS = "success";

const DB_HOST = "db";
const DB_NAME = "aluraplay";
const DB_USER = "root";
const DB_PASS = "a654321";
const DB_OPTIONS = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_CASE => PDO::CASE_NATURAL
];