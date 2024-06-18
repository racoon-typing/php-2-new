<?php
require_once "vendor/autoload.php";
ini_set('assert.exception', 1);

// use Taskforce\exceptions\TaskException;
// use Taskforce\logic\actions\ResponseAction;
// use Taskforce\logic\Task;

use Taskforce\exceptions\ConverterException;
use Taskforce\logic\convertor\CsvSqlConverter;


// try {
//     $task = new Task(
//         Task::STATUS_NEW, 
//         3, // client
//         1 // performer
//     );

//     $nextStatus = $task->getNextStatus(new ResponseAction());
// } catch (\Exception $e) {
//     die($e->getMessage());
// } catch (TaskException $e) {
//     die($e->getMessage());
// } 

// var_dump('new -> performer,alien', $task->getAvailableActions(Task::ROLE_PERFORMER, 2));
// var_dump('new -> performer,same', $task->getAvailableActions(Task::ROLE_PERFORMER, 1));

// var_dump('new -> client,alien', $task->getAvailableActions(Task::ROLE_CLIENT, 2));
// var_dump('new -> client,same', $task->getAvailableActions(Task::ROLE_CLIENT, 3));



// Импортирует csv файл
try {
    $converter = new CsvSqlConverter('data/csv');
    $result = $converter->convertFiles('data/sql');

    var_dump($result);
} catch (ConverterException $err) {
    die($err->getMessage());
}


// $csvFilePath = 'data/cities.csv';
// $tableName = 'cities';
// $csvFilePath = 'data/categories.csv';
// $tableName = 'categories';

// $converter = new CsvSqlConverter($csvFilePath, $tableName);
// $converter->convert();
// print_r($converter->getData());
// file_put_contents('output.sql', $sql);

// echo "CSV file converted to SQL successfully!";