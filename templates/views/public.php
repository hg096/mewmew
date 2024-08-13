<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/trongate.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/app.css">

    <title>mewmew 홈</title>

    <?php
    // 특정 페이지에서만 추가하거나 빼야할때 추가
    if(!empty($header_tag_arr[0])) {
        foreach ($header_tag_arr as $header_tag_arr_key => $header_tag_arr_value) {
            echo $header_tag_arr_value;
        }
    }
    ?>

    <!--    tailwind cdn -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <header>
            <div id="header-sm">
                <div id="hamburger" onclick="openSlideNav()">
                    &#9776;
                </div>
                <div class="logo">
                    <?= anchor(BASE_URL, WEBSITE_NAME); ?>
                </div>

                <div>
                    <?php

                echo anchor('account', '<i class="fa fa-user"></i>');
                echo anchor('logout', '<i class="fa fa-sign-out"></i>');

                ?>
                </div>
            </div>
            <div id="header-lg">
                <div class="logo">
                    <?= anchor(BASE_URL, WEBSITE_NAME); ?>
                </div>
                <div>
                    <ul id="top-nav">
                        <li><a class="flex items-center " href="<?= BASE_URL ?>"><i class="fa fa-home mr-2 w-4 "></i>홈</a></li>
                        <li><a class="flex items-center " href="<?= BASE_URL ?>"><i class="fa fa-lightbulb-o mr-2 w-4"></i>연락하기</a></li>
                        <li><a class="flex items-center " href="<?= BASE_URL ?>welcome/greeting"><i class="fa fa-lightbulb-o mr-2 w-4"></i>관리자 홈</a></li>

                        <li><a class="flex items-center " href="<?= BASE_URL . "members-account/login" ?>"><i class="fa fa-street-view mr-2 w-4"></i>로그인</a></li>

                    </ul>
                </div>
            </div>
        </header>
        <main class="container"><?= Template::display($data); ?></main>
    </div>


    <footer>
        <div class="container">
            <div>&copy; Copyright <?= date('Y') . ' ' . OUR_NAME ?></div>
            <!--        <div>--><?php //= anchor('https://trongate.io', 'Powered by Trongate') ?>
            <!--</div>-->
        </div>
    </footer>

    <div id="slide-nav">
        <div id="close-btn" onclick="closeSlideNav()">&times;</div>
        <ul auto-populate="true"></ul>
    </div>
    <script src="<?= BASE_URL; ?>js/app.js"></script>

    <?php
    if(!empty($footer_tag_arr[0])) {
        foreach ($footer_tag_arr as $footer_tag_arr_key => $footer_tag_arr_value) {
            echo $footer_tag_arr_value;
        }
    }
    ?>
</body>

</html>