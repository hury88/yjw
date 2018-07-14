/**
 * Created by lianglong on 16/2/17.
 */


var base_search_textA = $(".base_search_text a");

base_search_textA.click(function(){
    searchListUl.empty();
    base_search_input.val($(this).html());
    productName = encodeURI(base_search_input.val());
    index = 1;
    search();
});