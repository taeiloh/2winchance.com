<ul class="category inner">
    <li class="<?=empty($sub_menu)?'active':'';?>"><a href="/lobby/list.php?cate=<?=$cate;?>&g_date=<?=$g_date?>>">ALL</a></li>
    <li class="<?=($sub_menu==1)?'active':'';?>"><a href="/lobby/list.php?sub_menu=1&cate=<?=$cate;?>&g_date=<?=$g_date?>">FREE ZONE</a></li>
    <li class="<?=($sub_menu==2)?'active':'';?>"><a href="/lobby/list.php?sub_menu=2&cate=<?=$cate;?>&g_date=<?=$g_date?>">TOP 랭킹</a></li>
    <li class="<?=($sub_menu==3)?'active':'';?>"><a href="/lobby/list.php?sub_menu=3&cate=<?=$cate;?>&g_date=<?=$g_date?>">더블 랭킹</a></li>
    <li class="<?=($sub_menu==4)?'active':'';?>"><a href="/lobby/list.php?sub_menu=4&cate=<?=$cate;?>&g_date=<?=$g_date?>">트리플 랭킹</a></li>
    <li class="<?=($sub_menu==5)?'active':'';?>"><a href="/lobby/list.php?sub_menu=5&cate=<?=$cate;?>&g_date=<?=$g_date?>">데카 랭킹</a></li>
    <li class="<?=($sub_menu==6)?'active':'';?>"><a href="/lobby/list.php?sub_menu=6&cate=<?=$cate;?>&g_date=<?=$g_date?>">50/50</a></li>
</ul>