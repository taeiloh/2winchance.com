<ul class="category inner">
    <li class="<?=empty($sub_menu)?'active':'';?>"><a href="/lobby/list.php?cate=<?=$cate;?>">ALL</a></li>
    <li class="<?=($sub_menu==1)?'active':'';?>"><a href="/lobby/list.php?sub_menu=1&cate=<?=$cate;?>">FREE ZONE</a></li>
    <li class="<?=($sub_menu==2)?'active':'';?>"><a href="/lobby/list.php?sub_menu=2&cate=<?=$cate;?>">TOP Ranking</a></li>
    <li class="<?=($sub_menu==3)?'active':'';?>"><a href="/lobby/list.php?sub_menu=3&cate=<?=$cate;?>">Double UP</a></li>
    <li class="<?=($sub_menu==4)?'active':'';?>"><a href="/lobby/list.php?sub_menu=4&cate=<?=$cate;?>">Triple UP</a></li>
    <li class="<?=($sub_menu==5)?'active':'';?>"><a href="/lobby/list.php?sub_menu=5&cate=<?=$cate;?>">10X UP</a></li>
    <li class="<?=($sub_menu==6)?'active':'';?>"><a href="/lobby/list.php?sub_menu=6&cate=<?=$cate;?>">50/50</a></li>
</ul>