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

                    <table class="table">
                      <thead>
                        <tr>
                          <th>种类</th>
                          <th>值</th>
                          <th>值(USD)</th>
                          <th>网站</th>
                          <th>7天</th>
                          <th>操作</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($invests as $invest)
                          <tr>
                            <td>{{ $invest->type }}</td>
                            <td>{{ $invest->value }}</td>
                            <td><strong>{{ round($invest->value_real, 2) }}</strong></td>
                            <td><a href="{{ $invest->site }}">{{ get_host_of_url($invest->site) }}</a></td>
                            <td>{{ isset($price_map[$invest->type]) ? $price_map[$invest->type]->percent_change_7d : '?' }}%</td>
                            <td>
                              <a href="/invest/{{ $invest->id }}/edit" class="btn btn-default btn-sm">删/编辑</a>
                            </td>
                          </tr>
                        @endforeach
                        <tr>
                          <td>总值</td>
                          <td></td>
                          <td><strong>{{ round($total,2) }}</strong></td>
                          <td></td>
                          <td></td>
                          <td>
                            <a href="/invest/add" class="btn btn-default btn-sm">增加项目</a>
                          </td>
                      </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
