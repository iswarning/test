<!DOCTYPE html>
<html>
<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1252">
        <META HTTP-EQUIV="Content-language" CONTENT="vi">
  <title>Export Customers List To PDF File</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Pridi:wght@200&display=swap" rel="stylesheet">
 <style>
     #customers {
    font-family: 'Noto Sans', serif;
  border-collapse: collapse;
  font-size: 12px;
}
   #customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers .th {
    font-family: 'Noto Sans', serif;
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
                        <td class='th'>id</td>
                        <td class='th'>Họ và Tên</td>
                        <td class='th'>Cmnd</td>
                        <td class='th'>Số điện thoại</td>
                        <td class='th'>Địa Chỉ</td>
                        <td class='th'>Hộ Khẩu</td>
                        <td class='th'>Ngày Sinh</td>
                        <td class='th'>Số hợp đồng</td>
                        <td class='th'>Diện tích kí</td>
                        <td class='th'>Loại hợp đồng</td>
                        <td class='th'>Đã kí hay chưa</td>
                        <td class='th'>Ngày kí</td>
                        <td class='th'>Giá bán</td>
                        <td class='th'>Mã lô</td>
                        <td class='th'>Dự án</td>
                        <td class='th'>Trạng thái hợp đồng</td>
                        <td class='th'>Giữ chỗ</td>
                        <td class='th'>Tiến độ thanh toán</td>
                        <td class='th'>Ngày thanh toán đủ 95%</td>

                        @if(isset($data['contractData']['billlateData']))
                        <td class='th'>Ngày trễ</td>
                        <td class='th'>Đợt trễ</td>
                        <td class='th'>Số tiền trễ</td>
                        <td class='th'>Lãi phạt</td>
                        <td class='th'>Số lần đã gửi thông báo</td>
                        <td class='th'>Văn bản, phương thức</td>
                        <td class='th'>Ngày khách nhận thông báo</td>
                        @endif

                        @if(isset($data['contractData']['juridicalData']))
                        <td class='th'>Thông tin hợp đồng</td>
                        <td class='th'>Tình trạng sổ</td>
                        <td class='th'>Ngày công chứng</td>
                        <td class='th'>Thủ tục đăng bộ</td>
                        <td class='th'>Thanh lý hợp đồng</td>
                        <td class='th'>Bộ phận giữ sổ</td>
                        <td class='th'>Hồ sơ thu lai của khách hàng</td>
                        <td class='th'>Ngày bàn giao đất</td>
                        <td class='th'>Cam kết thỏa thuận</td>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['contractData'] as $k => $v)
                        <tr>


                            {{-- Customer Data --}}
                            <td>{{ $data['id'] }}</td>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['cmnd'] }}</td>
                            <td>{{ $data['phone'] }}</td>
                            <td>{{ $data['address'] }}</td>
                            <td>{{ $data['household'] }}</td>
                            <td>{{ $data['birthday'] }}</td>
                            
                            {{-- Contract Data --}}
                            <td>{{ $v['contract_no'] }}</td>
                            <td>{{ $v['area_signed'] }}</td>
                            <td>{{ $v['type'] }}</td>
                            <td>{{ $v['signed'] == 1 ?  'Đã ký' : 'Chưa ký' }}</td>
                            <td>{{ $v['signed_date'] }}</td>
                            <td>{{ $v['value'] }}</td>
                            <td>{{ $v['lot_number'] }}</td>
                            <td>{{ $v['project_id'] }}</td>
                            <td>{{ $v['contract_no'] }}</td>
                            <td>{{ $v['status'] }}</td>
                            <td>{{ $v['status_created_by'] }}</td>
                            <td>{{ $v['paymentData']['payment_progress'] }}</td>
                            <td>{{ $v['paymentData']['payment_date_95'] ?? '' }}</td>

                            {{-- Billate Data --}}
                            @if($v['billlateData'] != null)
                            <td>{{ $v['billlateData']['day_late'] }}</td>
                            <td>{{ $v['billlateData']['batch_late'] }}</td>
                            <td>{{ $v['billlateData']['money_late'] }}</td>
                            <td>{{ $v['billlateData']['citation_rate'] }}</td>
                            <td>{{ $v['billlateData']['number_notifi'] }}</td>
                            <td>{{ $v['billlateData']['document'] }}</td>
                            <td>{{ $v['billlateData']['receipt_date'] }}</td>
                            @endif

                            {{-- Juridical Data --}}
                            @if($v['juridicalData'] != null)
                            <td>{{ $v['juridicalData']['contract_info'] }}</td>
                            <td>{{ $v['juridicalData']['status'] }}</td>
                            <td>{{ $v['juridicalData']['notarized_date'] }}</td>
                            <td>{{ $v['juridicalData']['registration_procedures'] }}</td>
                            <td>{{ $v['juridicalData']['delivery_book_date'] }}</td>
                            <td>{{ $v['juridicalData']['liquidation'] }}</td>
                            <td>{{ $v['juridicalData']['bill_profile'] }}</td>
                            <td>{{ $v['juridicalData']['book_holder'] }}</td>
                            <td>{{ $v['juridicalData']['delivery_land_date'] }}</td>
                            <td>{{ $v['juridicalData']['commitment'] }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
       </div> 
   </div>
</section>
</body>
</html>