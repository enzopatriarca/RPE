var btn = document.getElementById("s_h_natureza");


btn.addEventListener("click",function(){
    var col_natureza = document.getElementById('naturezas_');
    if (col_natureza.style.display === "none") {
        col_natureza.style.display = "block";
        
    }else{
        col_natureza.style.display = "none";
    }
});


var btn1 = document.getElementById("s_h_area");



btn1.addEventListener("click",function(){
    var col_area = document.getElementById('areas_');
    if (col_area.style.display === "none") {
        col_area.style.display = "block";
    }else{
        col_area.style.display = "none";
    }
});

var btn2 = document.getElementById("s_h_locais");


btn2.addEventListener("click",function(){
    var col_local = document.getElementById('locais_');
    if (col_local.style.display === "none") {
        col_local.style.display = "block";
    }else{

        col_local.style.display = "none";
    }
});

var btn_scroll = document.getElementById("scroll_btn");

btn_scroll.addEventListener("click",function () {
    window.scrollTo(0, 1000);

});





