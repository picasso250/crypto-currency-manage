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

                    <a href="/invest/add" class="btn btn-default">增加投资项目</a>
                    <a href="/invest/refresh/value/real" class="btn btn-default pull-right">刷新价格</a>
                    
                    <table class="table">
                      <thead>
                        <tr>
                          <th>种类</th>
                          <th>值</th>
                          <th>值(USD)</th>
                          <th>网站</th>
                          <th>操作</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($invests as $invest)
                          <tr>
                            <td>{{ $invest->type }}</td>
                            <td><strong>{{ $invest->value }}</strong></td>
                            <td><strong>{{ $invest->value_real }}</strong></td>
                            <td><a href="{{ $invest->site }}">{{ $invest->site }}</a></td>
                            <td>
                              <form action="/invest/{{ $invest->id }}" method="POST">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}

                                  <button class="btn btn-danger btn-sm" >Delete</button>
                              </form>
                              
                            </td>
                          </tr>
                        @endforeach
                        <tr>
                          <td>总值</td>
                          <td></td>
                          <td><strong>{{ $total }}</strong></td>
                          <td></td>
                          <td>
                          </td>
                      </tbody>
                    
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
