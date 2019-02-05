@extends('layouts.back.blank')


@section('title')
    User
@endsection

@section('content')

<div class="content-wrapper">

    {!! Toastr::render() !!}

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="content-header">
        <h1>
          Manage Role to User
          <small>Add/Edit/List Role To User</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Examples</a></li>
          <li class="active">Blank page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
                    <div class="box box-primary" style="">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Role To User</h3>
                        </div>

                        <div class="box-body">
                                <div class="register-box-body">

                                        <form action="{{route('role_user.update',$userSelected->id)}}" method="post">
                                            @method('PATCH')
                                            @csrf
                                            <div class="form-group has-feedback">
                                                <label>Name</label>
                                                <select name="user_id" class="form-control select2" placeholder="User" required>
                                                    <option value="">Please Select User</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}" {{ ($user->id == $userSelected->id)?"selected":"" }}>{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Role</label>
                                                @foreach ($roles as $role)
                                                    <div class="checkbox">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="checkbox" name="role_id[]" value="{{ $role->id }}" {{ ($userSelected->roles->contains($role->id))? "checked" : ""  }}/>
                                                        <label>{{ $role->title }}</label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{--  <div class="form-group">
                                                <select name="role_id[]" select class="form-control select2" multiple="multiple" data-placeholder="Select a role" style="width: 100%;">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>  --}}


                                            <div class="row">
                                                <div class="col-xs-8">
                                                </div>
                                            <!-- /.col -->
                                                <div class="col-xs-4">
                                                    <button type="submit" class="btn btn-warning btn-block btn-flat">Edit</button>
                                                </div>
                                            <!-- /.col -->
                                            </div>
                                        </form>

                                        {{--  <div class="social-auth-links text-center">
                                            <p>- OR -</p>
                                            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
                                            Facebook</a>
                                            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
                                            Google+</a>
                                        </div>  --}}

                                        {{--  <a href="{{ route('login') }}" class="text-center">I already have a membership</a>  --}}
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">User Role</h3>
                    </div>
                    <div class="box-body">
                        <p>1) User can have multiple roles </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- List User -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Users_Roles</h3>
                    </div>

                    <div class="box-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>User Type</th>
                                    <th>Roles</th>
                                    <th>Modify</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->user_type}}</td>
                                        <td>
                                            @for( $i=0;$i < count($user->roles); $i++)
                                                @if($i!=0)
                                                ,
                                                @endif
                                                {{ $user->roles[$i]->title }}
                                            @endfor
                                        </td>

                                        <td><a href="{{ route('role_user.edit',$user->id) }}" class="btn btn-block btn-warning">Edit<a></td>
                                    </tr>

                                @endforeach
                            </tbody>


                        </table>
                    </div>

                </div>
            </div>
        </div>




      <!-- /.box -->


    </section>
    <!-- /.content -->


</div>



@endsection




