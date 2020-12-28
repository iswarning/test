<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Export Customers List To PDF File</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
 <style> 
 #customers {
    font-family: 'Noto Sans', sans-serif;
  border-collapse: collapse;
  width: 100%;
}
   #customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers .th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
   h2{
       text-align:center;
   }
</style>
</head>
<body>

<section>
    <div>
        <h2>Danh sách khách hàng </h2>
    </div>
    <div class="row">
        <div class="col-12">
            <table id='customers'>
                <thead>
                    <tr>
                        {{-- <td class='th'>ID</td> --}}
                        <td class='th'>Họ và tên</td>
                        <td class='th'>CMND</td>
                        <td class='th'>Dự án</td>
                        <td class='th'>Mã lô</td>
                        <td class='th'>Tình trạng</td>
                        <td class='th'>Tiến độ</td>
                        <td class='th'>Trạng thái</td>
                    </tr>
                </thead>
                <tbody>


                    @foreach ($customers as $key => $customer)
                        <tr>
                            <td>
                                    {{ $customer['customerName'] }}
                            </td>
                            <td>{{$customer['cmnd']}}</td>
                            <td>{{$customer['projectName']}}</td>
                            <td>{{$customer['lot_number']}}</td>
                            <td>
                                {{ App\Enums\ContractStatus::statusName[$customer['contractStatus']] }}
                            </td>
                            <td>{{$customer['payment_progress']}}%</td>

                            
                                <td>
                                    @if(App\Models\BillLate::where('payment_id',$customer['paymentId'])->first())
                                        Trễ hạn
                                    @else
                                        Đúng hạn
                                    @endif
                                </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
       </div> 
   </div>
</section>
</body>
</html>