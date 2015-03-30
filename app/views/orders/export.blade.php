@extends('default_activity')
@section('main')



 
  
<div >
    
   
        
        <table  >
            
                <thead>
                    <tr>
                        
                        <th>用户姓名<br>Customer Name</th>
                        <th>订单号<br>Order #</th>
                        <th>商品总数 <br> Total Quantity</th>
                        <th>总金额 <br> Total Amount</th>
                        <th>订单时间<br>Created at</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $row)
                    
                        
                            <tr>
                                
                                    <td >{{$row->owner->last_name}}</td>
                                    <td >
                                    {{$row->order_number}}
                                    </td>
                                    <td >{{$row->qty_total}}</td>
                                    <td >{{$row->amount_actual}}</td>
                                    <td >{{$row->created_at}}</td>
                                
                            </tr>
                        
                    
                    @endforeach
                </tbody>
        </table>  
           
</div>


@stop