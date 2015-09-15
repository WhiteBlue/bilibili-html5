
//icon hover
$(".wb-show").hover(function () {
        $(this).find(".wb-show-shadow").stop().fadeTo(400, 0.7);
    },
    function () {
        $(this).find(".wb-show-shadow").stop().fadeTo(500, 0);
    }
);