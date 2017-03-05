@include('header');

<section id="blog" class="container">
    <div class="center">
        <h2>{{ $msg_board }}</h2>
        <p class="lead">{{ $site_intro }}</p>
    </div>

    <div class="blog">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-item">
                    <div class="row">
                        <div class="row">
                            <div class="col-sm-12">
                                @foreach($messages as $message)
                                    <div class="single_comments">
                                        @if(is_file($message->avatar))
                                            <img style="margin-left: 20px;width: 64px;height:64px"
                                                 src="{{ $message->avatar}}" alt=""/>
                                        @else
                                            <img style="margin-left: 20px" src="front/images/blog/avatar3.png" alt=""/>
                                        @endif
                                        <p>{{ $message->content }} </p>
                                        <div class="entry-meta small ">
                                            <span style="float: left">By <a href="#">{{ $message->name }}</a></span>
                                            <span>On <a href="#">{{ date('Y-m-d H:i:s', $message->create_at) }}</a></span>
                                        </div>
                                        @if(mb_strlen($message->content) < 60)
                                            <br/>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div><!--/.messages-item-->
                    @include('page');
                </div><!--/.col-md-8-->
                <div class="row">
                    <textarea id="txt" class="col-lg-8 col-md-8 col-sm-8" placeholder="发表一下你的看法吧......"></textarea>
                    <div id="div3">发表</div>
                </div>
            </div><!--/.row-->
        </div>
    </div>
</section><!--/#blog-->
<script>
    $(function () {
        $("#div3").click(function () {
            var val = $("#txt").val();
            @if(!empty($user))
            $.post("message", {content: val, user_id:{{ $user->student_id }}}, function (result) {
                @else
                $.post("message", {content: val}, function (result) {
                    @endif
                    if (result.dec.code != 200000) {
                        alert(result.dec.msg);
                    } else {
                        alert('留言成功');
                        window.location.href = 'messages';
                    }
                });
            });

        });
</script>
@include('footer');

