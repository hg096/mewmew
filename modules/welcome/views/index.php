<?php
echo "<pre>";
echo "<br>";
print_r(">>> welcome 페이지");
print_r($data);
echo "<br>";
echo "</pre>";

?>
<p>기본 welcome 페이지</p>


<div class="flex bg-green-300 rounded-lg p-3 m-3 text-white">
    <?php load('uis/sam', $data['data1']); ?>
</div>

<div class="flex bg-green-300 rounded-lg p-3 m-3 text-white">
    <?php load('uis/sam', $data['data2']); ?>
</div>

<!-- <div class="flex bg-green-300 rounded-lg p-3 m-3 text-white">
    <?php // echo $content1; ?>
</div> -->

<!-- <div class="flex bg-green-300 rounded-lg p-3 m-3 text-white">
    <?php // echo $content2; ?>
</div> -->




