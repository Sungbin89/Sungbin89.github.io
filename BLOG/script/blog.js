$(window).on("click", function(e){
    switch(e.target.className){
        case "home_b":
            location.href="#home_area";
            break;
        case "bin_b":
            location.href="#bin_area";
            //$(".bin_explain_box").hide().delay(1000).slideDown(4000);
            break;
        case "do_b":
            location.href="#do_area";
            break;
        case "made_b":
            location.href="#made_area";
            break;
        case "contact_b":
            location.href="#contact_area";
            break;
        case "bin_korean_page":
            $(".korean_explain").stop().hide();
            $(".english_explain").stop().hide();
            $(".korean_explain").stop().show().css("transition", "all 0.4");
            break;
        case "bin_english_page":
            $(".korean_explain").stop().hide();
            $(".english_explain").stop().hide();
            $(".english_explain").stop().show().css("transition", "all 0.4");
            break;
        case "html_icon":
            let html_selceted = new Show_box(".html_icon", 90, "../icon/html_icon.png", "HTML_ICON", "전체적인 구조를 이해하고 있습니다.", "효율적으로 할 수 있도록 심도있게 공부하고 있습니다.");
            html_selceted.inner_to_box();
            break;
        case "css_icon":
            let css_selceted = new Show_box(".css_icon", 90, "../icon/css_icon.png", "CSS_ICON", "구조를 배치하고 효과를 주는데 능숙합니다.", "가상선택자 연습에 주력하고 있습니다.");
            css_selceted.inner_to_box();
            break;
        case "js_icon":
            let js_selceted = new Show_box(".js_icon", 92, "../icon/js_icon.png", "JS_ICON", "직접 코드를 작성하고 문제를 해결할 수 있습니다.", "기본에 충실 하도록 많은 예제를 공부하고 있습니다.");
            js_selceted.inner_to_box();
            break;
        case "jquery_icon":
            let jquery_selceted = new Show_box(".jquery_icon", 90, "../icon/jquery_icon.png", "JQUERY_ICON", "동적프로그램을 이해하고 사용할 수 있습니다.", "다양한 효과와 대상자사용을 공부하고 있습니다.");
            jquery_selceted.inner_to_box();
            break;
        case "php_icon":
            let php_selceted = new Show_box(".php_icon", 85, "../icon/php_icon.png", "PHP_ICON", "DB와 비동기 등을 접목 시킬 수 있습니다.", "DB연결과 다양한 변수에 집중하고 있습니다.");
            php_selceted.inner_to_box();
            break;
        case "ai_icon":
            let ai_selceted = new Show_box(".ai_icon", 65, "../icon/ai_icon.png", "AI_ICON", "폰트 제작 등을 활용하고 있습니다.", "인물의 이미지화를 공부하고 있습니다");
            ai_selceted.inner_to_box();
            break;
        case "ps_icon":
            let ps_selceted = new Show_box(".ps_icon", 75, "../icon/ps_icon.png", "PS_ICON", "제작에 필요한 그림을 수정 할 수 있습니다.", "섬세한 작업을 할 수 있도록 공부하고 있습니다.");
            ps_selceted.inner_to_box();
            break;
        case "cp_icon":
            let cp_selceted = new Show_box(".cp_icon", 55, "../icon/c_programming_icon.png", "C_ICON", "C/C++을 배움으로서 컴퓨터 언어를 체계적으로 학습 했습니다.", "JS처럼 문법의 사용을 공부하고 있습니다.");
            cp_selceted.inner_to_box();
            break;
        case "java_icon":
            let java_selceted = new Show_box(".java_icon", 65, "../icon/java_icon.png", "JAVA_ICON", "언어의 구성방법을 이해하고 있습니다.", "DB의 사용을 위해 심도 있게 공부하고 있습니다.");
            java_selceted.inner_to_box();
            break;
        case "sql_icon":
            let sql_selceted = new Show_box(".sql_icon", 75, "../icon/mysql_icon.png", "MYSQL_ICON", "테이블의 구성과 명령어를 이해하며 사용 할 수 있습니다.", "다양한 명령어를 공부하고 있습니다");
            sql_selceted.inner_to_box();
            break;
        case "node_icon":
            let node_selceted = new Show_box(".node_icon", 75, "../icon/nodejs_icon.png", "NODEJS_ICON", "동기와 비동기의 차이점을 이해하며 코드를 작성 할 수 있습니다.", "서버를 통한 작업을 공부하고 있습니다.");
            node_selceted.inner_to_box();
            break;
        case "pug_icon":
            let pug_selceted = new Show_box(".pug_icon", 50, "../icon/pug_icon.png", "PUG_ICON", "기본적인 사용법을 익히며 사용하고 있습니다.", "코드를 간략화 할 수 있도록 연습하고 있습니다.");
            pug_selceted.inner_to_box();
            break;
        case "sass_icon":
            let sass_selceted = new Show_box(".sass_icon", 85, "../icon/sass_icon.png", "SASS_ICON", "CSS를 더욱 간략화 하여 적용 할 수 있습니다.", "함수 사용법을 공부하고 있습니다.");
            sass_selceted.inner_to_box();
            break;
    }
});
class Show_box{
    constructor(class_name, score_point, photo_name, photo_alt, ...rest){
        this.class_name = class_name;
        this.score_point = score_point;
        this.photo_name = photo_name;
        this.photo_alt = photo_alt;
        this.rest = rest;
    }
    inner_to_box(){
        let i=0;
        $(".do_point_level").css("height", 0+"%");
        while(i<=this.score_point){
            $(".do_point_level").css("height", (1 * i)+"%");
            i++;
        }
        $(".do_ment_box").show();
        $(".do_ment_box>img").show().attr("src" , this.photo_name);
        $(".do_ment_box>ul>li:nth-child(1)").html(this.rest[0]);
        $(".do_ment_box>ul>li:nth-child(2)").html(this.rest[1]);
        $(".do_point_score").html(this.score_point + "%");
        i=0;
        while(i<=this.score_point){
            $(".do_point_score").css("margin-top", i+(this.score_point/3.5)+"%")//$(".do_point_score").css("margin-top", i+(this.score_point/2.7)+"%")
            i++;
        }
    }
}
$(".html_icon").click();
$(".bin_korean_page").on("click", function(){
    $(".korean_explain").stop().hide();
    $(".english_explain").stop().hide();
    $(".korean_explain").stop().show().css("transition", "all 0.4");
}); 
$(".bin_english_page").on("click", function(){
    $(".korean_explain").stop().hide();
    $(".english_explain").stop().hide();
    $(".english_explain").stop().show().css("transition", "all 0.4");
});
let margin_left = -35;
let interval_pointer = null;
$(".bin_right_button").on("click", function(){
    move_detail = () => {
        $(".bin_detail_box").css("margin-left", margin_left+"%").css("transition", "all 0.4");
        $(".bin_page_one, .bin_page_two, .bin_page_three").stop().hide();
        
        if(margin_left == -15){
            $(".bin_detail_box").show();
        }
        if(margin_left > 5){
            clearInterval(call_move);
            $(".korean_explain").stop().delay().show(1000).css("transition", "all 0.4");
            $(".bin_page_one, .bin_page_two, .bin_page_three").stop().show().css("transition", "all 0.4");
        }
        margin_left++;
    }
    call_move = setInterval(move_detail, 20);
});
let i=0;
setInterval(function(){
    let empty_array=["Hi~", "Hello~", "안녕하세요"]
    
    $('.home_first_sl').html(empty_array[i%empty_array.length]);
    i++;
}, 2000);
let idx = 0;
setInterval( () => {
    $(".home_move_area").css("margin-left",idx+"%").css("transition","all 0.6s");
    idx--;
    if(idx == -530) {
        setTimeout( () => {
            $(".home_move_area").css("margin-left",0+"%").css("transition","all 0.1s")
            idx = 0;
        }, 5);
    }
},100);
(function() {
    "use strict";
    var carousel = document.getElementsByClassName('carousel')[0],  //빅 박스
        slider = carousel.getElementsByClassName('carousel__slider')[0], // 각 박스의 0번째
        items = carousel.getElementsByClassName('carousel__slider__item'),  // 각박스 첫 자식 0번째
        prevBtn = carousel.getElementsByClassName('carousel__prev')[0], //왼쪽 버튼 0번째
        nextBtn = carousel.getElementsByClassName('carousel__next')[0]; //오른쪽 버튼 0번째
    var width, height, totalWidth, margin = 20, //너비 높이 전체 너비, 마진 
        currIndex = 0,                          
        interval, intervalTime = 3000;
    function init() {
        resize();
        move(Math.floor(items.length / 2)); // 각박스 첫 자식 0번째의 길이 /2
        bindEvents();                   //좌우 이동 
    }
    function resize() {                 
        width = Math.max(window.innerWidth * .2, 275),     //너비 = innerWidth의 가장 큰 수
        height = window.innerHeight * .4,                   //
        totalWidth = width * items.length;
        slider.style.width = totalWidth + "px";
        for(var i = 0; i < items.length; i++) {
            let item = items[i];
            item.style.width = (width - (margin * 2)) + "px";
            item.style.height = height + "px";
        }
    }
    function move(index) {
        if(index < 1) index = items.length;
        if(index > items.length) index = 1;
        currIndex = index;
        for(var i = 0; i < items.length; i++) {
            let item = items[i],
                box = item.getElementsByClassName('item__3d-frame')[0];
            if(i == (index - 1)) {
                item.classList.add('carousel__slider__item--active');
                box.style.transform = "perspective(1200px)"; 
            } else {
                item.classList.remove('carousel__slider__item--active');
                box.style.transform = "perspective(1200px) rotateY(" + (i < (index - 1) ? 40 : -40) + "deg)";
            }
        }
        slider.style.transform = "translate3d(" + ((index * -width) + (width / 2) + window.innerWidth / 2) + "px, 0, 0)";
    }
    function prev() {
        move(--currIndex);
    }
    function next() {
        move(++currIndex);    
    }
    function bindEvents() {         
        window.onresize = resize;
        prevBtn.addEventListener('click', () => { prev(); });
        nextBtn.addEventListener('click', () => { next(); });    
    }
    init();
})();