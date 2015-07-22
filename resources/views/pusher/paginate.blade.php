<?php
if ($totalPage <= 0 || $currentPage > $totalPage)
    return;
$startPage = $currentPage - 4;
if ($startPage < 1) {
    $startPage = 1;
}
$endPage = $currentPage + 4;
if ($endPage > $totalPage) {
    $endPage = $totalPage;
}
?>


<div class="pages">
    <ul class="pageWapper">
        <?php if ($currentPage <= 8) {
            $startPage = 1;
        }
        if ($totalPage - $currentPage < 8) {
            $endPage = $totalPage;
        }
        if($currentPage == 1){ ?>
        <li class="pageItem"><a class="PItemHref">上页</a></li>
        <?php }else{ ?>
        <li class="pageItem"><a class="PItemHref" href="${actionUrl}${currentPage - 1}${urlParas!}">上页</a></li>
        <?php }?>

        <? if($currentPage > 8){ ?>
        <li class="pageItem"><a class="PItemHref" href="${actionUrl}1${urlParas!}">1</a></li>
        <li class="pageItem"><a class="PItemHref" href="${actionUrl}2${urlParas!}">2</a></li>
        <li class="pageItem"><a class="PItemHref">...</a></li>
        <?php }
        $index = $startPage;
        while($index <= $endPage){
        if($currentPage == $index){ ?>
        <li class="pageItem"><a style="color: darkkhaki" class="PItemHref">${index}</a></li>
        <?php }else{ ?>
        <li class="pageItem"><a class="PItemHref" href="${actionUrl+index}${urlParas!}">${index}</a></li>
        <?php }
        $index = $index + 1;
        }

        if(($totalPage - $currentPage) >= 8){ ?>
        <li class="pageItem"><a class="PItemHref">…</a></li>
        <li class="pageItem"><a class="PItemHref" href="${actionUrl}${totalPage - 1}${urlParas!}">${totalPage - 1}</a>
        </li>
        <li class="pageItem"><a class="PItemHref" href="${actionUrl}${totalPage}${urlParas!}">${totalPage}</a></li>
        <?php }

        if($currentPage == $totalPage){ ?>
        <li class="pageItem"><a class="PItemHref">下页</a></li>
        <?php }else{ ?>
        <li class="pageItem"><a class="PItemHref" href="${actionUrl}${currentPage + 1}${urlParas!}" rel="next">下页</a>
        </li>
        <?php } ?>
    </ul>
</div>