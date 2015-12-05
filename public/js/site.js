/**
 * Created by WhiteBlue on 15/10/23.
 */

$(document).ready(function () {
    $(".wb-show").hover(
        function () {
            $(this).find(".wb-show-shadow").stop().fadeTo(300, 0.8);
        },
        function () {
            $(this).find(".wb-show-shadow").stop().fadeTo(300, 0);
        });
});
