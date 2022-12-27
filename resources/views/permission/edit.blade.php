@extends('layouts.app')

@section('content')

    <div class="container-fluid">

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Edit Role & Permission</h4>
                    </div>
                    <div>
                        <a href="{{ route('permission.index') }}" class="btn btn-light btn-round">View Employess</a>
                    </div>
                </div>
                <hr>
                <form action="{{route('permission.update', ['id' => $role->id ])}}" method="post">
                    
                    @include('message')
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="input-6">Full Name</label>
                        <input type="text" name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" id="input-6" placeholder="Enter Role Name" value="{{$role->name}}">
                        <span class="invalid-feedback">{{$errors->first('name')}}</span>
                    </div>
                    <div>
                         <div class="row">
                            <div class="col-12">
                                <label class="">
                                    <input class="all-permission" type="checkbox" {{ $role->hasAllDirectPermissions(\Spatie\Permission\Models\Permission::pluck('name')->toArray())?'checked':'' }}>
                                    <span>All Permission</span>
                                </label>
                            </div>
                            <br>
                            @foreach($permission_group as $group)
                            @php
                            $group_by_permission = \Spatie\Permission\Models\Permission::where('group_name_slug', $group->group_name_slug)->get();
                            @endphp
                            <div class="col-lg-3 col-md-4 mb-3">
                                <div class="card">
                                    <div labelclass="card-body" style="padding:15px;">
                                        <label class="">
                                            <input class="parent-permission" data-group="{{$group->group_name_slug}}" 
                                            type="checkbox" {{$role->hasAllDirectPermissions(\Spatie\Permission\Models\Permission::where('group_name_slug', $group->group_name_slug)->pluck('name')->toArray())?'checked':'' }}>
                                            <span>{{ucfirst($group->group_name)}}</span>
                                        </label>
                                        <ul class="list-unstyled ml-4 mb-0">
                                            @foreach($group_by_permission as $permission)
                                            <li>
                                                <label>
                                                    <input class="children-permission" data-parent="{{$group->group_name_slug}}" type="checkbox" name="permissions[]" value="{{$permission->id}}" {{$role->hasPermissionTo($permission->name)?'checked':''}}>
                                                    <span>{{ucfirst($permission->name)}}</span>
                                                </label>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-light btn-round px-5"><i class="icon-lock"></i> Update</button>
                    </div>
                </form>
                </div>
             </div>
        </div>
    </div><!--End Row-->

	<!--start overlay-->
		  <div class="overlay toggle-menu"></div>
		<!--end overlay-->

    </div>
    <!-- End container-fluid-->
    
    <script>

(function($) {
    "use strict";
$('.parent-permission').click(function(){

    var group = $(this).data('group');
    if($(this).is(':checked')){
        $('input[data-parent="'+group+'"]').prop("checked", true);
        ifcheckall();
    }else{
        $('input[data-parent="'+group+'"]').prop("checked", false);
        ifcheckall();
    }

});
$('.children-permission').click(function(){

    var parent = $(this).data('parent');
    if($('input[data-parent="'+parent+'"]:checked').length == $('input[data-parent="'+parent+'"]').length){
        $('input[data-group="'+parent+'"]').prop("checked", true);
        ifcheckall();
    }else{
        $('input[data-group="'+parent+'"]').prop("checked", false);
        ifcheckall();
    }

});
$('.all-permission').click(function(){

    var parent = $(this).data('parent');
    if($(this).is(':checked')){
        $('.parent-permission').prop("checked", true);
        $('.children-permission').prop("checked", true);
    }else{
        $('.parent-permission').prop("checked", false);
        $('.children-permission').prop("checked", false);
    }

});

function ifcheckall(){
    if($('.parent-permission:checked').length == $('.parent-permission').length){
        $('.all-permission').prop("checked", true);
    }else{
        $('.all-permission').prop("checked", false);
    }
}

ifcheckall();


})(jQuery);

</script>

@endsection