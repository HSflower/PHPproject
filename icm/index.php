<!-- 모바일 이동 시작 -->
<script type="text/javascript">
var mobileKeyWords = new Array('iPhone', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson');
for (var word in mobileKeyWords){
    if (navigator.userAgent.match(mobileKeyWords[word]) != null){
        location.href = "http://burynicm.cafe24.com/mobile";
        break;
    }

}
</script>
<!-- 모바일 이동 끝 -->

<html>
    <meta http-equiv="refresh" content="0; url=/home.html"></meta>
</html>