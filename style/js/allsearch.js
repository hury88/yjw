/**
 * Created by lianglong on 16/1/22.
 */
var base_search_input = $(".search_text"),
    base_search_btn = $(".search .btn"),
    searchVal = null,
    keyword = $(".keyword");

base_search_input.focus(function(){
    document.onkeydown = function(e){
        if(base_search_input.val()!=""&&e.which==13){
            searchVal = base_search_input.val();
            search();
        }
    };
});

base_search_btn.click(function(){
    searchVal = base_search_input.val();
    search();
});

keyword.find("a").click(function(){
    searchVal = $(this).html();
    search();
});

function search(){
    window.open(prevdomein+"/searchResult.html?"+searchVal);
}
