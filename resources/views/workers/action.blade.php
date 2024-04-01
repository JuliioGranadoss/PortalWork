<a href="{{ route('workers.show',$model->id) }}" class="show btn btn-success mx-1" data-id="{{$model->id}}"><i class="fa fa-eye"></i></a>
<a href="javascript:void(0)" class="edit btn btn-primary mx-1 editModel" data-id="{{$model->id}}"><i class="fa fa-edit"></i></a>
<a href="javascript:void(0)" class="btn btn-danger btn-xs deleteModel" data-id="{{$model->id}}"><i class="fa fa-trash"></i></a>