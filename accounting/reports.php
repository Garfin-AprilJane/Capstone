<?php 
    include("../assets/connection/connection.php");
    include("../universal/accounting_cookie.php");
    include("../universal/session.php");
?>

<!DOCTYPE html>
<html lang="en">

    <?php include("../universal/head.php");?>

    <body>
        <?php include("../universal/top_nav.php");?>
        <?php include("../universal/accounting_left_nav.php");?>

        <section class="section-content">
            <header class="content-action">
                <button type="button" onclick="addNewAccountCta()"><img src="../assets/icons/add.svg">New Account</button>
            </header>

            <div class="data">
                <div class="top-actions">
                    <aside class="left">
                        <label for="entriesAccount">Show</label>
                        <select id="entriesAccount" onchange="entriesAccountCta()">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <label for="entriesAccount">entries per page</label>
                    </aside>
                    <aside class="right">
                        <div class="filter-by">
                            <label for="filter">Filter by:</label>
                            <select id="filterAccount">
                                <option value=""></option>
                                <option value="username">username</option>
                                <option value="role">role</option>
                                
                            </select>
                        </div>
                        <div class="search-bar">
                            <input type="search" oninput="searchAccountCta()" id="searchAccount" placeholder="Search">
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </body>
</html>