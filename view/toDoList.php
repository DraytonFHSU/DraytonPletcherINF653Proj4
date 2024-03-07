<?php 
include('view/header.php'); // Include the header part of the HTML page

?>

<!-- Section to Display to Dos -->
<section>
<h1>To Do's</h1>
    <!-- Form for Filtering To Do's by category -->
    <form action="." method="get">
        <select name="categoryID">
            <option value="0">View All Categories</option>
            <?php foreach ($categories as $category) : ?>
                <!-- Dynamically generate options for categories, mark selected based on current filter -->
                <option value="<?= $category['categoryID'] ?>" <?= $categoryID == $category['categoryID'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['categoryName']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Go</button> <!-- Submit button for the filter form -->
    </form>
    <!-- Check if there are to dos to display (fetched from index.php) -->
    <?php if ($toDos) : ?>
        <!-- Loop through each to do and display it -->
        <?php foreach ($toDos as $toDo) : ?>
            <div>
            <p><strong><?= htmlspecialchars($toDo['categoryName']) ?></strong></p> <!-- Display the to do category -->
                <p><strong><?= htmlspecialchars($toDo['Title']) ?></strong></p> <!-- Display the to do name -->
                <p><?= htmlspecialchars($toDo['Description']) ?></p> <!-- Display the to do description -->
                <!-- Form to delete the toDo, with hidden inputs for passing data -->
                <form action="." method="post">
                    <input type="hidden" name="action" value="delete_toDo">
                    <input type="hidden" name="ItemNum" value="<?= $toDo['ItemNum'] ?>">
                    <button type="submit">Delete this to do</button> <!-- Button to delete the to do -->
                </form>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <!-- Message displayed if no to do's exist -->
        <p>No to do's exist yet.</p>
    <?php endif; ?>
</section>

<section>
    <h2>Add toDo</h2>
    <!-- Form for Adding a New toDo -->
    <form action="." method="post">
        <select name="categoryID" required>
            <option value="">Please select a category</option>
            <?php foreach ($categories as $category) : ?>
                <!-- Options for selecting category, populated dynamically -->
                <option value="<?= $category['categoryID'] ?>">
                    <?= htmlspecialchars($category['categoryName']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <!-- Input field for the toDo description -->
        <input type="text" name="title" maxlength="120" placeholder="Title" required>
        <input type="text" name="description" maxlength="120" placeholder="Description" required>
        <button type="submit" name="action" value="add_toDo">Add</button> <!-- Submit button for adding the toDo -->
    </form>
</section>

<!-- Link to View/Edit categories Page -->
<p><a href=".?action=list_categories">View/Edit categories</a></p>

<?php 
include('view/footer.php'); // Include the footer part of the HTML page
?>