<div class="wrap">
    <h1>CSV Post Creator</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <p>Choose csv-file with posts</p>
        <p>
            <input type="file" name="csv" accept=".csv">
            <input type="submit" value="Apply">
        </p>
        <?= wp_nonce_field('submit_csv') ?>
    </form>
</div>
<?php
use CsvPostCreator\Controllers\CsvPostCreator;

if (!isset($_FILES['csv']['tmp_name'])
    || !isset($_FILES['csv']['error'])
    || !isset($_FILES['csv']['type'])
    || !isset($_REQUEST['_wpnonce'])
    || $_FILES['csv']['tmp_name'] === ''
    || !wp_verify_nonce($_REQUEST['_wpnonce'], 'submit_csv')
    || !is_admin()
) {
    return;
}

if ($_FILES['csv']['error'] !== 0) {
    echo '<p>There was error while loading csv-file.</p>';
    return;
}

if ($_FILES['csv']['type'] !== 'text/csv') {
    echo '<p>Incorrect file type.</p>';
    return;
}

if ($_FILES['csv']['size'] > CsvPostCreator::maxFileSize
    || filesize($_FILES['csv']['tmp_name']) > CsvPostCreator::maxFileSize) {
    echo '<p>File is too large.</p>';
    return;
}

if (CsvPostCreator::createCsvPosts($_FILES['csv']['tmp_name'])) {
    echo '<p>Posts was succesfully created.</p>';
} else {
    echo '<p>There was error while creating the posts.</p>';
}

?>