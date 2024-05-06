@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Roles</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Roles</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Form</h3>
                            </div>
                            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                                @csrf()
                                @method('patch')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="role">Role Name</label>
                                        <input value="{{ $role->role }}" type="text" class="form-control" id="role" placeholder="Role Name" name="role" required>
                                    </div>
                                    <div class="row">
                                        @foreach($menus as $key => $menu)
                                            <div class="col-12 p-2">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success main-menu">
                                                        <input {{ $loop->iteration==1? 'checked' : null }} {{ in_array($menu->id, array_column($privileges,'menu_id')) ? 'checked' : null}} name="menu_id[]" type="checkbox" class="custom-control-input" id="main-menu-{{ $menu->id }}" value="{{ $menu->id }}">
                                                        <label class="custom-control-label" for="main-menu-{{ $menu->id }}">{{ $menu->menu_name }}</label>
                                                    </div>
                                                    <div class="row ml-2">
                                                        @foreach($menu->submenu as $submenukey => $submenu)
                                                        <div style="width: 20%">
                                                                <div class="custom-control custom-switch custom-switch-off-warning custom-switch-on-success sub-menu">
                                                                    <input {{ in_array($submenu->id, array_column($privileges,'menu_id')) ? 'checked' : null}} name="menu_id[]" type="checkbox" class="custom-control-input main-menu-{{ $menu->id }}" main-menu-id="{{ $submenu->parent_id }}" id="sub-menu-{{ $submenu->id }}" value="{{ $submenu->id }}">
                                                                    <label class="custom-control-label" for="sub-menu-{{ $submenu->id }}">{{ $submenu->menu_name }}</label>
                                                                </div>
                                                                <div class="row ml-2">
                                                                    @foreach($submenu->subchild as $subchildkey => $subchild)
                                                                        <div class="col-12">
                                                                            <div class="custom-control custom-switch custom-switch-off-gray custom-switch-on-success child-menu">
                                                                                <input {{ in_array($subchild->id, array_column($privileges,'menu_id')) ? 'checked' : null}} name="menu_id[]" type="checkbox" class="custom-control-input sub-menu-{{ $submenu->id }}" sub-menu-id="{{ $subchild->child_id }}"  id="child-menu-{{ $subchild->id }}" value="{{ $subchild->id }}">
                                                                                <label class="custom-control-label" for="child-menu-{{ $subchild->id }}">{{ $subchild->menu_name }}</label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div> 
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('.main-menu').on('click',function(){
            var main_id = $(this).children('input:nth-child(1)').attr('id');
            var checked = $(this).children('input:nth-child(1)').prop('checked');
            var children = $('.'+main_id);
            children.each(function() {
                $(this).prop("checked", checked);
                var sub_id = $(this).prop('id');
                var subChecked = $(this).prop('checked');
                var subchildren = $('.'+sub_id);
                subchildren.each(function(){
                    $(this).prop("checked",subChecked);
                });
            })
        });
        $('.sub-menu').on('click',function(){
            var id = $(this).children('input:nth-child(1)').attr('main-menu-id');
            $('#main-menu-'+id).prop("checked", true);

            var sub_id = $(this).children('input:nth-child(1)').attr('id');
            var subChecked = $(this).children('input:nth-child(1)').prop('checked');
            var subchildren = $('.'+sub_id);
            subchildren.each(function(){
                $(this).prop("checked",subChecked);
            });

        });
        $('.child-menu').on('click',function(){
            var id = $(this).children('input:nth-child(1)').attr('sub-menu-id');
            $('#sub-menu-'+id).prop("checked", true);
            var id = $('#sub-menu-'+id).attr('main-menu-id');
            $('#main-menu-'+id).prop("checked", true);
        });
    });
</script>
@endsection