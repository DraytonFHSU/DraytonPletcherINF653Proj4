<?php
function get_toDos($categoryID) //not good!
{
    global $db;
    if ($categoryID) {
        $query = 'SELECT T.ItemNum, T.Title, T.Description, C.categoryName From todoitems T
            LEFT JOIN categories C ON T.categoryID = C.categoryID
                WHERE T.categoryID = :categoryID ORDER BY T.ItemNum';
    } else {
        $query = 'SELECT T.ItemNum, T.Title, T.Description, C.categoryName From todoitems T
            LEFT JOIN categories C ON T.categoryID = C.categoryID ORDER BY C.categoryID';
    }    
    $statement = $db->prepare($query);
    if ($categoryID) {
        $statement->bindValue(':categoryID', $categoryID);
    }
    $statement->execute();
    $ItemNum = $statement->fetchAll();
    $statement->closeCursor();
    return $ItemNum;
}

function delete_toDo($ItemNum)
{
    global $db;
    $query = 'DELETE FROM todoitems WHERE ItemNum = :ItemNum';
    $statement = $db->prepare($query);
    $statement->bindValue(':ItemNum', $ItemNum);
    $statement->execute();
    $statement->closeCursor();
}

function add_toDo($categoryID, $title, $description)
{
    global $db;
    $query = 'INSERT INTO todoitems (categoryID, Title, Description ) VALUES (:categoryID, :title, :description)';
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->execute();
    $statement->closeCursor();
}