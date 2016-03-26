<?php

include("db_c.php");//DB Connection details

?>

<html>
<head>
    <title>香港Telegram Group Link Director</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript"
                src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js?=hl=zh-HK'></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
              type="text/css">
        <link href="style.css" rel="stylesheet" type="text/css">
    <script>
        $(function () {

            $('form').on('submit', function (e) {

                e.preventDefault();

                $.ajax({
                    type: 'post',
                    url: 'reply.php',
                    data: $('form').serialize(),
                    success: function () {
                        //alert('貼出了...如果你不是機械人');

                        setTimeout(
                            function()
                            {
                                location.reload();
                            }, 0001);
                    },
                    error: function(){
                        alert('發貼失敗');
                    }
                });

            });

        });
    </script>

</head>
<body>

<div class="navbar navbar-default navbar-static-top">
        <div class="container">
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target="#navbar-ex-collapse"><span class="sr-only">Toggle navigation</span><span
                                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand"><span>香港Telegram Group Link Directory</span></a></div>
                <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                        <ul class="nav navbar-nav navbar-right"></ul>
                </div>
        </div>
</div>
<div class="section">
        <div class="container">
                <div class="row">
                        <div class="col-md-12"><h1 class="text-center">你想搵咩Group?</h1></div>
                </div>
                <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                                <form role="form">
                                        <div class="form-group">
                                                <div class="input-group"><input type="text" class="form-control"
                                                                                placeholder="Search(未寫)"
                                                                                disabled="disabled"> <span
                                                            class="input-group-btn"> <a class="btn btn-success"
                                                                                        type="submit">Go</a> </span>
                                                </div>
                                        </div>
                                </form>
                        </div>
                </div>
        </div>
</div>
<div class="section">
        <div class="container">
                <div class="row">
                        <div class="col-md-12">
                                <div class="panel panel-primary">
                                        <div class="panel-heading"><h3 class="panel-title">最新Group Link</h3></div>
                                        <div class="panel-body">
                                                <ul class="media-list">
                                                <?php

                                                #spilt pages
                                                $requested_page = isset($_GET['page']) ? intval($_GET['page']) : 1;// Assume the page is 1

                                                $r = mysqli_query($link,"SELECT COUNT(glink) FROM yellowpage");
                                                $d = mysqli_fetch_row($r);
                                                $thread_count = $d[0];

                                                $thread_per_page = 10;

                                                // 55 products => $page_count = 3
                                                $page_count = ceil($thread_count / $thread_per_page);

                                                // You can check if $requested_page is > to $page_count OR < 1,
                                                // and redirect to the page one.

                                                $first_thread_shown = ($requested_page - 1) * $thread_per_page;




                                                #Get post thread

$sql = <<<SQL
SELECT * FROM `yellowpage` ORDER BY id DESC LIMIT $first_thread_shown, $thread_per_page
SQL;


                                                #Prompt Error Query
                                                if (!$result = $link->query($sql)) {
                                                    die('There was an error running the query [' . $link->error . ']');
                                                }

                                                while ($row = $result->fetch_assoc()) {

                                                    echo "<li class=\"media\"><div class=\"media-body\"><h4 class=\"media-heading\">" . $row['title'] . "</h4><p><a href=\"". $row['glink'] ."\">" . $row['glink'] . "</a></p><p>". $row['detail'] . "</p></div></li><hr>" ;

                                                }
                                                $total_pages = ceil($row / 10);
                                                    ?>

                                                </ul>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>
<div class="section">
        <div class="container">
                <div class="row">
                        <div class="col-md-12">
                                <ul class="pagination">

                                    <?php
                                    #Generate list of links
                                    for($i=1; $i<=$page_count; $i++) {
                                        if($i == $requested_page) {
                                            echo "<li><a href=\"?page=1\">1</a></li>";
                                        } else {
                                            echo '<li><a href="?page='.$i.'">'.$i.'</a></li> ';
                                        }
                                    }
                                    ?>
                                </ul>
                        </div>
                </div>
        </div>
</div>
<div class="section section-warning">
        <div class="container">
                <div class="row">
                        <div class="col-md-12"><h1>提交新Group Link</h1>
                                <form role="form" action="reply.php" method="POST">
                                        <div class="form-group"><label class="control-label" >Group名</label><input
                                                    class="form-control"
                                                    placeholder="(必須填寫)" type="text" name="title"></div>
                                        <div class="form-group"><label class="control-label"
                                                                       >個Group傾咩架</label><input
                                                    class="form-control"
                                                    placeholder="(必須填寫)" type="text" name ="detail"></div>
                                        <div class="form-group"><label class="control-label"
                                                                       >Group
                                                        Link</label><input class="form-control"
                                                                           placeholder="(必須填寫)" type="text" name="glink"></div>
                                    <div class="g-recaptcha" data-sitekey="YOUR KEY HERE!!!!!!!!!!!!!"></div>
                                        <button type="submit" class="btn btn-default">提交<br></button>
                                </form>
                        </div>
                </div>
        </div>
</div>
<footer class="section section-primary">
        <div class="container">
                <div class="row">
                        <div class="col-sm-6"><h1>..Beta</h1>
                                <p>...Beta...</p></div>
                        <div class="col-sm-6"><p class="text-info text-right"><br><br></p>
                                <div class="row">
                                        <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left"><a href="#"><i
                                                            class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a> <a
                                                    href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                                                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                                                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-12 text-right"><a href="#"><i
                                                            class="fa fa-3x fa-fw fa-github text-inverse"></i></a></div>
                                </div>
                        </div>
                </div>
        </div>
</footer>
</body>
</html>