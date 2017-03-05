<footer id="footer" class="midnight-blue">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                &copy; 2013 <a target="_blank" href="http://shapebootstrap.net/"
                               title="Free Twitter Bootstrap WordPress Themes and HTML templates">ShapeBootstrap</a>.
                All Rights Reserved.
            </div>
            <div class="col-sm-6">
                <ul class="pull-right">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Faq</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer><!--/#footer-->


<!--侧边栏-->
<script>
    $(function () {
        $(".side ul li").hover(function () {
            $(this).find(".sidebox").stop().animate({"width": "124px"}, 200).css({
                "opacity": "1",
                "filter": "Alpha(opacity=100)",
                "background": "#ae1c1c"
            })
        }, function () {
            $(this).find(".sidebox").stop().animate({"width": "54px"}, 200).css({
                "opacity": "0.8",
                "filter": "Alpha(opacity=80)",
                "background": "#000"
            })
        });
    });
    //回到顶部函数
    function goTop() {
        $('html,body').animate({'scrollTop': 0}, 300);
    }
</script>
<!--侧边栏end-->
</body>
</html>