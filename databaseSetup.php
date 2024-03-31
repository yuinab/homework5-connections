<?php

    // Note that these are for the local Docker container
    $host = "db";
    $port = "5432";
    $database = "example";
    $user = "localuser";
    $password = "cs4640LocalUser!"; 

    $dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

    if ($dbHandle) {
        echo "Success connecting to database";
    } else {
        echo "An error occurred connecting to the database";
    }

    // Drop tables and sequences (that are created later)
    $res  = pg_query($dbHandle, "drop sequence if exists question_seq;");
    $res  = pg_query($dbHandle, "drop sequence if exists user_seq;");
    $res  = pg_query($dbHandle, "drop sequence if exists userquestion_seq;");
    $res  = pg_query($dbHandle, "drop table if exists questions;");
    $res  = pg_query($dbHandle, "drop table if exists users;");

    // Create sequences
    $res  = pg_query($dbHandle, "create sequence question_seq;");
    $res  = pg_query($dbHandle, "create sequence user_seq;");
    $res  = pg_query($dbHandle, "create sequence userquestion_seq;");

    // Create tables

$res  = pg_query($dbHandle, "create table categories (
    id  int primary key default nextval('category_seq'),
    category_name    text,
    keywords      jsonb
);");

    // Read json and insert the trivia questions into the database, assuming
    // the trivia-s24.json file is in the same directory as this script.
    $questions = json_decode(
        file_get_contents("data/connections.json"), true);

        $res = pg_prepare($dbHandle, "myinsert", "insert into categories (category_name, keywords) values ($1, $2);");
        foreach ($categories as $categoryName => $keywords) {
            $res = pg_execute($dbHandle, "myinsert", [$categoryName, json_encode($keywords)]);
        }