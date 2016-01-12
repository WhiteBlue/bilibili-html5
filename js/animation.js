/**
 * Created by WhiteBlue on 16/1/11.
 */

$(document).ready(function () {
    $(".wb-show").hover(
        function () {
            $(this).find(".wb-show-shadow").stop().fadeTo(300, 0.8);
        },
        function () {
            $(this).find(".wb-show-shadow").stop().fadeTo(300, 0);
        });

    $('.wb_action_element').hover(
        function () {
            $(this).toggleClass('wb_element_active');
        }, function () {
            $(this).toggleClass('wb_element_active');
        });

    $('.wb_action_text').hover(
        function () {
            $(this).toggleClass('wb_text_active');
        }, function () {
            $(this).toggleClass('wb_text_active');
        });
});