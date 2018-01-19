@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Type -->
                        <div class="form-group">
                            <label for="task" class="col-sm-3 control-label">Type</label>

                            <div class="col-sm-6">
                                <input type="text" name="type" id="task-name" class="form-control">
                            </div>
                    
                        </div>
                        
                        <!-- Value -->
                        <div class="form-group">
                            <label for="task" class="col-sm-3 control-label">Value</label>

                            <div class="col-sm-6">
                                <input type="text" name="value" id="task-name" class="form-control">
                            </div>
                    
                        </div>
                        
                        <!-- Site -->
                        <div class="form-group">
                            <label for="task" class="col-sm-3 control-label">Site</label>

                            <div class="col-sm-6">
                                <input type="text" name="site" id="task-name" class="form-control">
                            </div>
                    
                        </div>
                        
                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-plus"></i> Add Invest
                                </button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
