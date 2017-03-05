@include('header');

<section id="blog" class="container">
    <div class="center">
        <h2>{{ $down_title }}</h2>
        <p class="lead">{{ $site_intro }}</p>
    </div>

    <div class="blog">
        <div class="row">
            <table class="table table-striped table-bordered" style="margin-left: 15px;">
                <thead>
                <th width="30%">课件名称</th>
                <th width="20%">课件类型</th>
                <th width="30%">所属科目</th>
                <th width="20%">下载</th>
                </thead>
                <tbody>
                @foreach($files as $file)
                    <div class="single_comments">

                        <tr>
                            <td>{{ $file->file_name }}</td>
                            @if($file->file_type == 2)
                                <td class="text-danger">WORD</td>
                            @elseif($file->file_type == 3)
                                <td class="text-success">PPT</td>
                            @endif
                            <td>{{ $file->object_name }}</td>
                            <td>
                                @if(!is_file($file->path))
                                    <i style="color: red">文件已失效,请联系老师更新</i>
                                @else
                                    <a href="{{ $file->path }}" class="text-success">点击下载</a>
                                @endif
                            </td>
                        </tr>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>

        @include('page');
    </div><!--/.col-md-8-->


</section><!--/#blog-->
@include('footer');
<!--侧边栏-->

