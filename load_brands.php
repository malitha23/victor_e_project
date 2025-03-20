<?php
require "connection.php";

if (isset($_POST['offset'])) {
    $offset = intval($_POST['offset']);
    $brand = Database::Search("SELECT * FROM `brand` LIMIT 6 OFFSET " . $offset);
    $brandnum = $brand->num_rows;

    if ($brandnum > 0) {
        for ($i = 0; $i < $brandnum; $i++) {
            $branddata = $brand->fetch_assoc();
            echo

            ' <li class="mb-2">
                                        <input type="checkbox" id="brand" value="' .  $branddata["id"] . '"/>
                                        <button class="text-gray-900 hover-text-main-600">
                                        ' . $branddata["name"] . '
                                        </button>
                                    </li>
                  ';
        }
    } else {
        echo '<div class="text-center text-muted">No more brands available.</div>';
    }
}
