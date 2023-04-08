<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title></title>
        <link rel="stylesheet" type="text/css" href="css/test.css">
        <style>
            .bg {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                z-index: -999;
            }

            .bg img {
                min-height: 100%;
                width: 100%;
                opacity: 0.6;
            }
        </style>

    </head>

    <body class="bg">
        <div class="bg">
            <img src="place.jpg">
        </div>
        <div class="a-1">
            <h1 align="center">種植區塊 Hello, <?php echo $_SESSION['name']; ?></h1>
            <?php
            include('db_conn.php');
            $query = "select * from paintingblock";
            $query_run = mysqli_query($conn, $query);
            ?>
        </div>

        <div class="container" style="font-size:27px;">
            <table class="tb-1" style="text-align:center;" align="center" width="700" height="350">
                <thead style="text-align:center;">
                    <tr style="text-align:center;">
                        <th>土地編號</th>
                        <th>土地狀態</th>
                        <th>產量</th>
                        <th>生產天數</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- 大括號的上、下半部分 分別用 PHP 拆開 ，這樣中間就可以純用HTML語法-->
                    <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                    ?>
                            <tr>
                                <!-- $row['(輸入資料表的欄位名稱)'];  <<用雙引號也行 -->
                                <td>B0<?php echo $row['block_id']; ?></td>
                                <td><?php echo $row['state']; ?></td>
                                <td><?php echo $row['output']; ?></td>
                                <td><?php echo $row['time']; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="footer" style="font-size:25px;" align="center">
            <footer>
                <?php
                require_once('db_conn.php');
                $result = $conn->query('select now() as n;');
                if (!$result) {
                    die($conn->error);
                }
                $row = $result->fetch_assoc();
                ?>
                <h6>更新時間<?php echo ': ' . $row['n']; ?></h6>
                <a href="logout.php" class="lo">登出</a>
            </footer>
        </div>
    </body>

    </html>
<?php
} else {
    header("Location:index.php");
    exit();
}
?>