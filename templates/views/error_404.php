<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title><?php echo WEBSITE_NAME . " - Page Not Found"; ?></title>
</head>

<body>

<h1>404 Error : Page Not Found</h1>
<h2 onclick="goback()" style="text-decoration: underline; color:aqua; ">CLICK TO GO BACK</h2>

<style>
    body {
        font-size: 2em;
        /*background: #ff0000;*/
        /*color: #ddd;*/
        text-align: center;
        font-family: "Lucida Console", Monaco, monospace;
        cursor: default; /* 마우스 커서를 기본 화살표로 설정 */
    }

    h1 {
        margin-top: 2em;
    }

    h2:hover {
        color: inherit; /* 마우스 오버 시 색상 변경 없음 */
        background-color: inherit; /* 마우스 오버 시 배경 색상 변경 없음 */
    }

    h1,
    h2 {
        text-transform: uppercase;

    }

</style>

<script>
	function goback() {
		history.back();
	}
</script>
</body>

</html>
