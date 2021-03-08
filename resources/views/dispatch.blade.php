@extends('layouts.app')
@section('content')
<script src="{{ asset('js/app.js') }}" ></script>
<div class="container">
    <div class="row">
      <div class="card text-center filterable ml-auto mr-auto">
         <div class="card-header">
            <h5 class="card-title">Dispatch requests
            <div class="float-right">
               <button class="btn btn-primary btn-xs btn-filter ml-0"><span class="fa fa-search"></span> Search</button>
            </div>
            </h5>
         </div>
         <table class="table table-striped">
            <thead class="table-primary ">
               <tr class="filters">
                  <th><input type="text" class="form-control text-center" placeholder="#" disabled></th>
                  <th><input type="text" class="form-control text-center" placeholder="Transport name" disabled></th>
                  <th><input type="text" class="form-control text-center" placeholder="User name" disabled></th>
                  <th><input type="text" class="form-control text-center" placeholder="License No" disabled></th>
                  <th><input type="text" class="form-control text-center" placeholder="Status" disabled></th>
               </tr>
            </thead>
            <tbody>
               <?php $i = 1; ?>
               @foreach($transports as $transport)
               <tr>
                  <td>{{$i++}}</td>
                  <td>{{$transport->name}}</td>
                  <td>{{$transport->user->name}}</td>
                  <td>{{$transport->lno}}</td>
                  <td>
                     <form action=""method="post">
                        @csrf
                        <input type="hidden" value="1" name="a">
                        <input type="hidden" name="id" value="{{$transport->id}}">
                        <button type="submit" class="btn btn-primary">accept</button>
                     </form>
                     <form action=""method="post">
                        @csrf
                        <input type="hidden" value="2" name="r">
                        <input type="hidden" name="id" value="{{$transport->id}}">
                        <button type="submit" class="btn btn-danger">reject</button>
                     </form>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         <div class="ml-auto mr-auto" style="margin-top:20px;">{{$transports->links()}}</div>
      </div>
   </div>
</div>
<style>
   .filterable {
   margin-top: 15px;
   }
   .filterable .panel-heading .pull-right {
   margin-top: -20px;
   }
   .filterable .filters input[disabled] {
   background-color: transparent;
   border: none;
   cursor: auto;
   box-shadow: none;
   padding: 0;
   height: auto;
   }
   .filterable .filters input[disabled]::-webkit-input-placeholder {
   color: #333;
   }
   .filterable .filters input[disabled]::-moz-placeholder {
   color: #333;
   }
   .filterable .filters input[disabled]:-ms-input-placeholder {
   color: #333;
   }
</style>
<script src="{{ asset('js/app.js') }}" ></script>
<script>
   /*
   Please consider that the JS part isn't production ready at all, I just code it to show the concept of merging filters and titles together !
   */
   $(document).ready(function(){
       $('.filterable .btn-filter').click(function(){
           var $panel = $(this).parents('.filterable'),
           $filters = $panel.find('.filters input'),
           $tbody = $panel.find('.table tbody');
           if ($filters.prop('disabled') == true) {
               $filters.prop('disabled', false);
               $filters.first().focus();
           } else {
               $filters.val('').prop('disabled', true);
               $tbody.find('.no-result').remove();
               $tbody.find('tr').show();
           }
       });
   
       $('.filterable .filters input').keyup(function(e){
           /* Ignore tab key */
           var code = e.keyCode || e.which;
           if (code == '9') return;
           /* Useful DOM data and selectors */
           var $input = $(this),
           inputContent = $input.val().toLowerCase(),
           $panel = $input.parents('.filterable'),
           column = $panel.find('.filters th').index($input.parents('th')),
           $table = $panel.find('.table'),
           $rows = $table.find('tbody tr');
           /* Dirtiest filter function ever ;) */
           var $filteredRows = $rows.filter(function(){
               var value = $(this).find('td').eq(column).text().toLowerCase();
               return value.indexOf(inputContent) === -1;
           });
           /* Clean previous no-result if exist */
           $table.find('tbody .no-result').remove();
           /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
           $rows.show();
           $filteredRows.hide();
           /* Prepend no-result row if all rows are filtered */
           if ($filteredRows.length === $rows.length) {
               $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
           }
       });
   });
   
</script>
@endsection