<?php

//Drayton Pletcher
//Back-end web development 1
//Project 3

require_once('model/database.php');
require_once('model/category_db.php');
require_once('model/toDo_db.php');

// Filter input to prevent XSS and SQL Injection
$ItemNum = filter_input(INPUT_POST, 'ItemNum', FILTER_VALIDATE_INT);
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

$category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_SPECIAL_CHARS);
// Attempt to get $categoryID from POST, fallback to GET if not available
$categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_VALIDATE_INT) ?: filter_input(INPUT_GET, 'categoryID', FILTER_VALIDATE_INT);

// Determine the action to take, defaulting to listing the to do's if none specified
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ?: filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?: 'list_toDos';

switch ($action) {
    case "list_categories":
        $categories = get_categories();
        include('view/categoryList.php');
        break; // Prevent fall-through
    case "add_category":
        if (!empty($category_name)) {
            add_category($category_name);
            header("Location: .?action=list_categories");
            exit(); // Exits the script, making a break optional but good practice
        } else {
            $error = "Invalid category name. Please check the field and try again.";
            include("view/error.php");
            exit(); // Exits the script, making a break optional but good practice
        }
        break; // Good practice even after exit()
    case "add_toDo":
        if ($categoryID && $title && $description) {

            add_toDo($categoryID, $title, $description);
            header("Location: .?action=list_toDos" . $ItemNum);
            exit(); // Exits the script, making a break optional but good practice
        } else {
            $error_message = "Invalid toDo data. Check all fields and try again.";
            include("view/error.php");
            exit(); // Exits the script, making a break optional but good practice
        }
        break; // Good practice even after exit()
    case "delete_category":
        if ($categoryID) {
            try {
                delete_category($categoryID);
                header("Location: .?action=list_categories");
                exit(); // Exits the script, making a break optional but good practice
            } catch (PDOException $e) {
                $error = "You cannot delete a category if to Do's exist in the category.";
                include('view/error.php');
                exit(); // Exits the script, making a break optional but good practice
            }
        }
        break; // Prevent fall-through
    case "delete_toDo":
        if ($ItemNum) {
            delete_toDo($ItemNum);
            header("Location: .?action=list_toDos" . $ItemNum);
            exit(); // Exits the script, making a break optional but good practice
        } else {
            $error_message = "Missing or incorrect toDo id.";
            include('view/error.php');
            exit(); // Exits the script, making a break optional but good practice
        }
        break; // Good practice even after exit()
    default:
        $categories = get_categories();
        $toDos = get_toDos($categoryID);
        include('view/toDolist.php');
        // No break needed after default as it's the last case
}