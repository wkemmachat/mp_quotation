@extends('layouts.back.blank')


@section('title')
    Test title
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

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Role
        <small>it all starts here</small>
      </h1>
      {{--  <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>  --}}
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">All Roles</h3>
			</div>

			<div class="box-body">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th>Title</th>
							<th>Description</th>
							<th>Modify</th>
						</tr>

					</thead>

					<tbody>

						@foreach($roles as $role)
							<tr>
								<td>{{$role->title}}</td>
								<td>{{$role->description}}</td>
								<td>
									<button class="btn btn-info" data-mytitle="{{$role->title}}" data-mydescription="{{$role->description}}" data-catid={{$role->id}} data-toggle="modal" data-target="#edit">Edit</button>
									/
									<button class="btn btn-danger" data-catid={{$role->id}} data-toggle="modal" data-target="#delete">Delete</button>
								</td>
							</tr>

						@endforeach
					</tbody>


				</table>
			</div>
		</div>
	</div>



	<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
 	Add New
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Role</h4>
      </div>
      <form action="{{route('role.store')}}" method="post">
      		{{csrf_field()}}
	      <div class="modal-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title">
            </div>

            <div class="form-group">
                <label for="des">Description</label>
                <textarea name="description" id="des" cols="20" rows="5" id='des' class="form-control"></textarea>
            </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save</button>
	      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit role</h4>
      </div>
      <form action="{{route('role.update','test')}}" method="post">
      		{{method_field('patch')}}
      		{{csrf_field()}}
	      <div class="modal-body">
	      		<input type="hidden" name="role_id" id="edit_cat_id" value="">
                <div class="form-group">
		        	<label for="title">Title</label>
		        	<input type="text" class="form-control" name="title" id="edit_title" value="">
	        	</div>

	        	<div class="form-group">
	        		<label for="des">Description</label>
	        		<textarea name="description" id="edit_des" cols="20" rows="5" value="" class="form-control"></textarea>
	        	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save Changes</button>
	      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
      </div>
      <form action="{{route('role.destroy','test')}}" method="post">
      		{{method_field('delete')}}
      		{{csrf_field()}}
	      <div class="modal-body">
				<p class="text-center">
					Are you sure you want to delete this?
				</p>
	      		<input type="hidden" name="role_id" id="del_cat_id" value="">

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success" data-dismiss="modal">No, Cancel</button>
	        <button type="submit" class="btn btn-warning">Yes, Delete</button>
	      </div>
      </form>
    </div>
  </div>
</div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>



<script>


    $('#edit').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget)
        var title = button.data('mytitle')
        var description = button.data('mydescription')
        var cat_id = button.data('catid')
        var modal = $(this)

        modal.find('.modal-body #edit_title').val(title);
        modal.find('.modal-body #edit_des').val(description);
        modal.find('.modal-body #edit_cat_id').val(cat_id);
    })


    $('#delete').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget)

        var cat_id = button.data('catid')
        var modal = $(this)

        modal.find('.modal-body #del_cat_id').val(cat_id);
    })


  </script>

  @endsection




