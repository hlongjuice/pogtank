@extends('admin.layouts.master')
@section('content')
  <div id="test2">
      <h1>MaxRound : @{{maxRound}}</h1>
      <label for="round">
          Round:
          <input id="round" type="number" v-model.number="round">
      </label>
      <ul>
          <li  v-for="n in maxRound">@{{n}}</li>
      </ul>
  </div>
@endsection
@section('script')
    <script>
        new Vue({
            el: '#test2',
            data: {
                round:3
            },
            computed:{
                maxRound:function(){
                    return this.round*2;
                }
            }
        });
    </script>
@endsection