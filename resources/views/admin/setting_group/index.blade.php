@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<!--数据列表页面-->
<section class="content">

    <!--顶部搜索筛选-->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-inline searchForm" id="searchForm" action="{{route('admin.setting_group.index')}}" method="GET">

                        <div class="form-group">
                            <input value="{{isset($_keywords) ? $_keywords : ''}}"
                                   name="_keywords" id="_keywords" class="form-control input-sm" placeholder="名称/描述/代码">
                        </div>


                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search"></i> 查询
                            </button>
                        </div>

                        <div class="form-group">
                            <button onclick="clearSearchForm()" class="btn btn-sm btn-default" type="button"><i
                                    class="fa  fa-eraser"></i> 清空查询
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <!--数据列表顶部-->
                <div class="box-header">
                    <div>
                        <a title="添加" data-toggle="tooltip" class="btn btn-primary btn-sm " href="{{route('admin.setting_group.add')}}">
                            <i class="fa fa-plus"></i> 添加
                        </a>
                        <a class="btn btn-danger btn-sm AjaxButton" data-toggle="tooltip" title="删除选中数据"
                           data-confirm-title="删除确认" data-confirm-content="您确定要删除选中的数据吗？" data-id="checked"
                           data-url="{{route('admin.setting_group.del')}}">
                            <i class="fa fa-trash"></i> 删除
                        </a>

                        <a class="btn btn-success btn-sm ReloadButton" data-toggle="tooltip" title="刷新">
                            <i class="fa fa-refresh"></i> 刷新
                        </a>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered datatable" width="100%">
                        <thead>
                        <tr>
                            <th>
                                <input id="dataCheckAll" type="checkbox" onclick="checkAll(this)" class="checkbox"
                                       placeholder="全选/取消">
                            </th>
                            <th>ID</th>
                            <th>名称</th>
                            <th>描述</th>
                            <th>作用模块</th>
                            <th>代码</th>
                            <th>排序</th>
                            <th>自动生成菜单</th>
                            <th>自动生成配置文件</th>
                            <th>创建时间</th>
                            <th>更新时间</th>

                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>
                                <input type="checkbox" onclick="checkThis(this)" name="data-checkbox"
                                       data-id="{{$item['id']}}" class="checkbox data-list-check" value="{{$item['id']}}"
                                       placeholder="选择/取消">
                            </td>
                            <td>{{$item['id']}}</td>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['description']}}</td>
                            <td>{{$item['module']}}</td>
                            <td>{{$item['code']}}</td>
                            <td>{{$item['sort_number']}}</td>
                            <td>@if(1 == $item['auto_create_menu']) <span class="label label-success">是</span> @else <span class="label label-warning">否</span> @endif</td>
                            <td>@if(1 == $item['auto_create_file']) <span class="label label-success">是</span> @else <span class="label label-warning">否</span> @endif</td>
                            <td>{{$item['create_time']}}</td>
                            <td>{{$item['update_time']}}</td>
                            <td class="td-do">
                                <a href="{{route('admin.setting_group.edit',['id'=>$item['id']])}}"
                                   class="btn btn-primary btn-xs" title="修改" data-toggle="tooltip">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <a class="btn btn-success btn-xs AjaxButton" data-toggle="tooltip" title="生成配置文件"
                                   data-id="{{$item['id']}}" data-confirm-title="生成配置文件确认"
                                   data-confirm-content='您确定要生成ID为 <span class="text-red">{{$item['id']}}</span> 的配置文件吗'
                                   data-url="{{route('admin.setting_group.file')}}">
                                    <i class="fa fa-file-code-o"></i>
                                </a>

                                <a class="btn btn-warning btn-xs AjaxButton" data-toggle="tooltip" title="生成菜单"
                                   data-id="{{$item['id']}}" data-confirm-title="生成菜单确认"
                                   data-confirm-content='您确定要生成ID为 <span class="text-red">{{$item['id']}}</span> 的菜单吗'
                                   data-url="{{route('admin.setting_group.menu')}}">
                                    <i class="fa fa-list"></i>
                                </a>

                                <a class="btn btn-danger btn-xs AjaxButton" data-toggle="tooltip" title="删除"
                                   data-id="{{$item['id']}}" data-confirm-title="删除确认"
                                   data-confirm-content='您确定要删除ID为 <span class="text-red">{{$item['id']}}</span> 的数据吗'
                                   data-url="{{route('admin.setting_group.del')}}">
                                    <i class="fa fa-trash"></i>
                                </a>

                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- 数据列表底部 -->
                <div class="box-footer">
                    {{ $data->withQueryString()->links() }}
                    <label class="control-label pull-right" style="margin-right: 10px; font-weight: 100;">
                        <small>共{{$data->total()}}条记录</small>&nbsp;
                        <small>每页显示</small>
                        &nbsp;
                        <select class="input-sm" onchange="changePerPage(this)">
                            @foreach($admin['per_page_config'] as $val)
                                <option value="{{$val}}" @if($admin['per_page'] == $val) selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                        &nbsp;
                        <small>条记录</small>
                    </label>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

