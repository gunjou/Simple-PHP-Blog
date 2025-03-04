<?php
include("header.php");
include("connect.php");
?>

<div class="w3-panel">
    <p>This is a simple blog project for my PHP development skills.
    im here because hacktoberfest 2019</p>
</div>

<?php
// COUNT 
$sql = "SELECT COUNT(*) FROM posts";
$result = mysqli_query($dbcon, $sql);
$r = mysqli_fetch_row($result);
$numrows = $r[0];

$rowsperpage = 5;
$totalpages = ceil($numrows / $rowsperpage);

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (INT)$_GET['page'];
}

if ($page > $totalpages) {
    $page = $totalpages;
}

if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $rowsperpage;

$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $offset, $rowsperpage";
$result = mysqli_query($dbcon, $sql);

if (mysqli_num_rows($result) < 1) {
    echo '<div class="w3-panel w3-pale-red w3-card-2 w3-border w3-round">Nothing to display</div>';
}
while ($row = mysqli_fetch_assoc($result)) {

    $id = htmlentities($row['id']);
    $title = htmlentities($row['title']);
    $des = htmlentities($row['description']);
    $time = htmlentities($row['date']);

    echo '<div class="w3-panel w3-sand w3-card-4">';
    echo "<h3><a href='view.php?id=$id'>$title</a></h3><p>";

    echo substr($des, 0, 100);

    echo '</p><div class="w3-text-teal">';
    echo "<a href='view.php?id=$id'>Read more...</a>";

    echo '</div> <div class="w3-text-grey">';
    echo "$time</div>";
    echo '</div>';
}


echo "<div class='w3-bar w3-center'>";
if ($page > 1) {
    echo "<a href='?page=1'>&laquo;</a>";
    $prevpage = $page - 1;
    echo "<a href='?page=$prevpage' class='w3-btn'><</a>";
}
$range = 5;
for ($x = $page - $range; $x < ($page + $range) + 1; $x++) {
    if (($x > 0) && ($x <= $totalpages)) {
        if ($x == $page) {
            echo "<div class='w3-teal w3-button'>$x</div>";
        } else {
            echo "<a href='?page=$x' class='w3-button w3-border'>$x</a>";
        }
    }
}

if ($page != $totalpages) {
    $nextpage = $page + 1;
    echo "<a href='?page=$nextpage' class='w3-button'>></a>";
    echo "<a href='?page=$totalpages' class='w3-btn'>&raquo;</a>";
}
echo "</div>";
include("categories.php");
include("footer.php");
